<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use Carbon\Carbon;

class CalendarController extends Controller
{
    // DITAMBAHKAN - Method untuk mengambil data event kalender
    public function getEvents()
    {
        // Query tickets dengan status approved, in_use, completed (tanpa pending)
        $events = Ticket::whereIn('status', ['approved', 'in_use', 'completed'])
            ->with(['facility', 'user'])
            ->get()
            ->map(function ($ticket) {
                // kalau date_end kosong, fallback durasi 1 jam dari date
                $end = $ticket->date_end
                    ? $ticket->date_end
                    : Carbon::parse($ticket->date)->addHour();

                return [
                    'id' => $ticket->id,
                    'title' => $ticket->facility->name . ' - ' . $ticket->event_name,
                    'start' => $ticket->date->toIso8601String(),
                    'end' => $end->toIso8601String(),
                    'extendedProps' => [
                        'ticket_code' => $ticket->ticket_code,
                        'event_name' => $ticket->event_name,
                        'facility' => $ticket->facility->name,
                        'user' => $ticket->user->name,
                        'status' => $ticket->status,
                    ]
                ];
            });

        return response()->json($events);
    }
}