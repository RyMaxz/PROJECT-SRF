<?php

namespace App\Http\Controllers;

use App\Models\Ticket;

class CalendarController extends Controller
{
    // DITAMBAHKAN - Method untuk mengambil data event kalender
    public function getEvents()
    {
        // Query tickets dengan status 'approved', include relasi user dan facility
        $events = Ticket::where('status', 'approved')
            ->with(['facility', 'user'])
            ->get()
            ->map(function ($ticket) {
                return [
                    'id' => $ticket->id,
                    'title' => $ticket->facility->name . ' - ' . $ticket->event_name,
                    'start' => $ticket->date->toIso8601String(),
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
