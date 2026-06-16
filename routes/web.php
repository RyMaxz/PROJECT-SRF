<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CalendarController; // DITAMBAHKAN

Route::redirect('/', '/home');

// ✅ DIPERBAIKI: Menambahkan ->name('home') untuk route home
Route::get('/home', function () {
    return view('home');
})->name('home');

// API Route FullCalendar
Route::get('/reservation-calendar-events', [CalendarController::class, 'getEvents']);

// Route Create Ticket
Route::get('/tickets/create', [App\Http\Controllers\TicketController::class, 'create'])
    ->name('tickets.create');
Route::post('/tickets', [App\Http\Controllers\TicketController::class, 'store'])
    ->name('tickets.store');
Route::get('/tickets/success', [App\Http\Controllers\TicketController::class, 'success'])
    ->name('tickets.success');

