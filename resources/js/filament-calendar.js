import { Calendar } from '@fullcalendar/core'
import dayGridPlugin from '@fullcalendar/daygrid'
import timeGridPlugin from '@fullcalendar/timegrid'
import idLocale from '@fullcalendar/core/locales/id.js'
import '@fullcalendar/core/index.css'
import '@fullcalendar/daygrid/index.css'
import '@fullcalendar/timegrid/index.css'

window.initReservationCalendar = function (element, events) {
    if (!element) {
        return
    }

    if (element._calendar) {
        element._calendar.destroy()
    }

    const calendar = new Calendar(element, {
        plugins: [
            dayGridPlugin,
            timeGridPlugin,
        ],

        locale: idLocale,

        initialView: 'dayGridMonth',

        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,timeGridWeek,timeGridDay',
        },

        events: events,

        height: 'auto',

        nowIndicator: true,

        eventTimeFormat: {
            hour: '2-digit',
            minute: '2-digit',
            hour12: false,
        },

        eventClick: function (info) {
            const event = info.event
            const props = event.extendedProps

            alert(
                `Kode Ticket: ${props.ticket_code ?? '-'}\n` +
                `Acara: ${props.event_name ?? '-'}\n` +
                `Fasilitas: ${props.facility ?? '-'}\n` +
                `Peminjam: ${props.user ?? '-'}\n` +
                `Status: ${props.status ?? '-'}`
            )
        },
    })

    calendar.render()

    element._calendar = calendar
}