<x-filament-widgets::widget>
    <x-filament::section>
        <x-slot name="heading">
            Kalender Reservasi Fasilitas
        </x-slot>

        <x-slot name="description">
            Menampilkan jadwal reservasi berdasarkan data ticket.
        </x-slot>

        @vite(['resources/js/filament-calendar.js'])

        <div
            wire:ignore
            x-data
            x-init="
                $nextTick(() => {
                    window.initReservationCalendar($refs.calendar, @js($this->getEvents()))
                })
            "
        >
            <div x-ref="calendar" id="reservation-calendar" style="height: 600px;"></div>
        </div>
    </x-filament::section>
</x-filament-widgets::widget>