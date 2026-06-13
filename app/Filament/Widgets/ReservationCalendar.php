<?php

namespace App\Filament\Widgets;

use App\Models\Ticket;
use Filament\Widgets\Widget;

class ReservationCalendar extends Widget
{
    protected string $view = 'filament.widgets.reservation-calendar';

    protected int | string | array $columnSpan = 'full';

    public function getEvents(): array
    {
        return Ticket::query()
            ->with(['facility', 'user'])
            ->whereNotIn('status', ['rejected', 'cancelled'])
            ->get()
            ->map(function (Ticket $ticket) {
                return [
                    'id' => $ticket->id,

                    'title' => $this->makeEventTitle($ticket),

                    'start' => $ticket->date?->toIso8601String(),

                    'extendedProps' => [
                        'ticket_code' => $ticket->ticket_code,
                        'event_name' => $ticket->event_name,
                        'facility' => $ticket->facility?->name,
                        'user' => $ticket->user?->name,
                        'status' => $ticket->status,
                    ],
                ];
            })
            ->filter(fn (array $event) => filled($event['start']))
            ->values()
            ->toArray();
    }

    private function makeEventTitle(Ticket $ticket): string
    {
        $facilityName = $ticket->facility?->name ?? 'Fasilitas tidak ditemukan';
        $eventName = $ticket->event_name ?? 'Reservasi';
        $status = strtoupper($ticket->status);

        return "{$facilityName} - {$eventName} ({$status})";
    }
}