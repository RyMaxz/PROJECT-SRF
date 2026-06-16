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
        // ambil data fasilitas
        $facilities = Facility::query()
            ->where('is_available', true)
            ->orderBy('name')
            ->get();

        return view('tickets.create', compact('facilities'));
    }

    public function store(Request $request)
    {
        // validasi inputan
        $validated = $request->validate([
            'email' => ['required', 'email', 'ends_with:@pkl.co'], // validasi email
            'password' => ['required', 'string'],

            'facility_id' => ['required', 'exists:facilities,id'], // validasi fasilitas/ticket
            'event_name' => ['required', 'string', 'max:255'],
            'purpose' => ['nullable', 'string'],
            'note' => ['nullable', 'string'],
            'date' => ['required', 'date', 'after_or_equal:now'],
        ], [
            'email.ends_with' => 'Reservasi hanya bisa menggunakan email kampus dengan domain @pkl.co.', // DITAMBAHKAN
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

        // cek apakah fasilitas udah punya ticket aktif di waktu yang sama
        $hasConflict = Ticket::query()
            ->where('facility_id', $validated['facility_id'])
            ->whereIn('status', ['pending', 'approved', 'in_use'])
            ->where('date', $validated['date'])
            ->exists();

        if ($hasConflict) {
            return back()
                ->withInput($request->except('password'))
                ->withErrors([
                    'date' => 'Jadwal fasilitas pada waktu tersebut sudah digunakan atau sedang menunggu konfirmasi.',
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
