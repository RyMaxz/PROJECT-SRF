<x-filament-widgets::widget>
    <x-filament::section>
        <x-slot name="heading">
            Kalender Reservasi Fasilitas
        </x-slot>

        <x-slot name="description">
            Menampilkan jadwal reservasi berdasarkan data ticket.
        </x-slot>

        <link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.20/index.global.min.css" rel="stylesheet" />

        <div
            wire:ignore
            x-data="{}"
            x-init="
                setTimeout(() => {
                    if (window.initReservationCalendar && $refs.calendar) {
                        window.initReservationCalendar($refs.calendar, @js($this->getEvents()))
                    }
                }, 100)
            "
        >
            <div x-ref="calendar" id="reservation-calendar" style="height: 600px;"></div>
        </div>
    </x-filament::section>
</x-filament-widgets::widget>