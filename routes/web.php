<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CalendarController; // DITAMBAHKAN

Route::redirect('/', '/home');

Route::get('/home', function () {
    return view('home');
});

// DITAMBAHKAN - API Route untuk FullCalendar
Route::get('/reservation-calendar-events', [CalendarController::class, 'getEvents']);
