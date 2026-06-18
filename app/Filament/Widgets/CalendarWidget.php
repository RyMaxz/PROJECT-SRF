<?php

namespace App\Filament\Widgets;

use App\Models\Ticket;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Saade\FilamentFullCalendar\Widgets\FullCalendarWidget;

class CalendarWidget extends FullCalendarWidget
{
    public Model|string|null $model = Ticket::class;

    // status yang mau ditampilkan di calendar
    protected array $visibleStatuses = ['pending', 'approved', 'in_use', 'completed'];

    public function fetchEvents(array $fetchInfo): array
    {
        return Ticket::query()
            ->with(['facility', 'user'])
            ->whereIn('status', $this->visibleStatuses)
            ->where(function ($query) use ($fetchInfo) { // filter event yang masuk range calendar
            $query->where('date', '<', $fetchInfo['end'])
                ->where(function ($query) use ($fetchInfo) {
                    $query->where('date_end', '>', $fetchInfo['start'])
                        ->orWhereNull('date_end');
                });
        })
        ->get()
        ->map(function (Ticket $ticket) {
            $start = $ticket->date;

            // kalau date_end kosong, default durasi 1 jam
            $end = $ticket->date_end
                ? $ticket->date_end
                : Carbon::parse($ticket->date)->addHour();

            return [
                'id' => (string) $ticket->id,
                'title' => ($ticket->facility?->name ?? 'Fasilitas')
                    . ' - '
                    . ($ticket->event_name ?? 'Reservasi'),
                'start' => $start?->toIso8601String(),
                'end' => $end?->toIso8601String(),
                'backgroundColor' => $this->getStatusColor($ticket->status),
                'borderColor' => $this->getStatusColor($ticket->status),
                'extendedProps' => [
                    'ticket_code' => $ticket->ticket_code,
                    'event_name' => $ticket->event_name,
                    'purpose' => $ticket->purpose,
                    'facility' => $ticket->facility?->name,
                    'user' => $ticket->user?->name,
                    'status' => $ticket->status,
                ],
            ];
        })
        ->values()
        ->toArray();
    }

    protected function getStatusColor(string $status): string
    {
        return match ($status) {
            'pending' => '#f59e0b',   // amber
            'approved' => '#3b82f6',  // blue
            'in_use' => '#10b981',    // green
            'completed' => '#6b7280', // gray
            default => '#9ca3af',
        };
    }

    public function config(): array
    {
        return [
            'initialView' => 'dayGridMonth',

            'headerToolbar' => [
                'left' => 'prev,next today',
                'center' => 'title',
                'right' => 'dayGridMonth,timeGridWeek,timeGridDay',
            ],

            'eventTimeFormat' => [
                'hour' => '2-digit',
                'minute' => '2-digit',
                'hour12' => false,
            ],
        ];
    }

    protected function getHeaderActions(): array
    {
        return [];
    }
}