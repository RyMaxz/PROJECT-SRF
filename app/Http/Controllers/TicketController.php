<?php

namespace App\Http\Controllers;

use App\Models\Facility;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class TicketController extends Controller
{
    public function create()
    {
        // ambil data sub kategori (lokasi/gedung) untuk dropdown pertama
        $subCategories = \App\Models\SubCategory::query()
            ->where('is_active', true)
            ->orderBy('name')
            ->get();

        // ambil data fasilitas, lengkap dengan subcategory_id untuk filter JS
        $facilities = Facility::query()
            ->where('is_available', true)
            ->orderBy('name')
            ->get();

        return view('tickets.create', compact('subCategories', 'facilities'));
    }

    public function store(Request $request)
    {
        // validasi inputan
        $validated = $request->validate([
            'email' => ['required', 'email', 'ends_with:@pkl.co'], // validasi email
            'password' => ['required', 'string'],

            'sub_category_id' => ['required', 'exists:sub_categories,id'], // DITAMBAHKAN - validasi lokasi/gedung
            'facility_id' => ['required', 'exists:facilities,id'], // validasi fasilitas/ticket
            'event_name' => ['required', 'string', 'max:255'],
            'purpose' => ['nullable', 'string'],
            'note' => ['nullable', 'string'],
            'date' => ['required', 'date_format:Y-m-d\TH:i', 'after_or_equal:now'],
            'date_end' => ['required', 'date_format:Y-m-d\TH:i', 'after:date'], // DITAMBAHKAN - validasi jam selesai
        ], [
            'email.ends_with' => 'Reservasi hanya bisa menggunakan email kampus dengan domain @pkl.co.', // DITAMBAHKAN
            'date_end.after' => 'Jam selesai harus lebih besar dari jam mulai.', // DITAMBAHKAN
            'date.date_format' => 'Format tanggal dan jam mulai tidak valid.',
            'date_end.date_format' => 'Format tanggal dan jam selesai tidak valid.',
        ]);

        $user = User::where('email', $validated['email'])->first();
        // cek apkaha user terdafar
        if (! $user || ! Hash::check($validated['password'], $user->password)) {
            return back()
                ->withInput($request->except('password'))
                ->withErrors([
                    'credential' => 'Data tidak ditemukan. Email kampus atau password tidak sesuai.',
                ]);
        }

        // DITAMBAHKAN - pastikan facility yang dipilih benar-benar milik sub_category yang dipilih
        // mencegah manipulasi form (ubah value lewat devtools)
        $facility = Facility::query()
            ->where('id', $validated['facility_id'])
            ->where('subcategory_id', $validated['sub_category_id'])
            ->first();

        if (! $facility) {
            return back()
                ->withInput($request->except('password'))
                ->withErrors([
                    'facility_id' => 'Fasilitas yang dipilih tidak sesuai dengan lokasi/gedung yang dipilih.',
                ]);
        }

        // DIPERBAIKI - cek tabrakan jadwal berdasarkan overlap rentang waktu (date - date_end)
        // bukan cuma cek kesamaan jam mulai persis
        $hasConflict = Ticket::query()
            ->where('facility_id', $validated['facility_id'])
            ->whereIn('status', ['pending', 'approved', 'in_use'])
            ->where('date', '<', $validated['date_end'])
            ->where(function ($query) use ($validated) {
                $query->where('date_end', '>', $validated['date'])
                    ->orWhereNull('date_end');
            })
            ->exists();

        if ($hasConflict) {
            return back()
                ->withInput($request->except('password'))
                ->withErrors([
                    'date' => 'Jadwal fasilitas pada rentang waktu tersebut sudah digunakan atau sedang menunggu konfirmasi.',
                ]);
        }

        // simpan reservasi ke tabel tickets
        Ticket::create([
            'user_id' => $user->id,
            'facility_id' => $validated['facility_id'],
            'ticket_code' => 'RSV-' . now()->format('Ymd') . '-' . strtoupper(Str::random(5)),
            'event_name' => $validated['event_name'],
            'purpose' => $validated['purpose'] ?? null,
            'note' => $validated['note'] ?? null,
            'date' => $validated['date'],
            'date_end' => $validated['date_end'], // DITAMBAHKAN
            'status' => 'pending',
        ]);

        return redirect()
            ->route('tickets.success')
            ->with('success', 'Reservasi berhasil diajukan. Menunggu konfirmasi admin.');
    }

    public function success()
    {
        return view('tickets.success');
    }
}