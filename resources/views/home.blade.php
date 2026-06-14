<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Reservasi Fasilitas</title>

    @vite('resources/css/app.css')
    @vite('resources/js/app.js')

    <!-- DITAMBAHKAN - FullCalendar CSS -->
    <link href='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.css' rel='stylesheet' />

    <!-- DITAMBAHKAN - Custom FullCalendar Styling -->
    <style>
        /* Styling toolbar buttons kalender */
        .fc .fc-button-primary {
            background-color: #2563eb !important;
            /* Biru dasar */
            border-color: #2563eb !important;
            color: white !important;
            box-shadow: none !important;
        }

        .fc .fc-button-primary:hover {
            background-color: #1e40af !important;
            /* Biru lebih tua saat hover */
            border-color: #1e40af !important;
            color: white !important;
        }

        .fc .fc-button-primary.fc-button-active,
        .fc .fc-button-primary:active {
            background-color: #1e40af !important;
            /* Sama seperti hover — konsisten */
            border-color: #1e40af !important;
            color: white !important;
            box-shadow: inset 0 1px 2px rgba(0, 0, 0, 0.1) !important;
        }

        /* Optional: focus ring untuk aksesibilitas */
        .fc .fc-button-primary:focus {
            outline: 2px solid rgba(37, 99, 235, 0.5) !important;
            outline-offset: 2px !important;
        }

        /* Styling header teks */
        .fc .fc-col-header-cell {
            background-color: #f1f5f9;
            border-color: #e2e8f0;
        }

        /* Styling event */
        .fc .fc-daygrid-day:hover {
            background-color: #f8fafc;
        }

        .fc .fc-highlight {
            background-color: rgba(37, 99, 235, 0.1);
        }

        /* Styling today highlight */
        .fc .fc-daygrid-day.fc-day-today {
            background-color: rgba(37, 99, 235, 0.05);
        }
    </style>
</head>

<body class="bg-slate-50 font-sans antialiased text-slate-800">

    <nav
        class="fixed top-0 left-0 w-full h-16 bg-white border-b border-slate-100 shadow-sm z-50 transition-all duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <!-- logo dan nama sistem -->
                <div class="flex items-center gap-3">
                    <img src="{{ asset('images/logo-itb.png') }}" alt="Logo Kampus" class="h-10 w-auto object-contain">
                    <span class="text-lg font-bold text-slate-800 tracking-tight whitespace-nowrap">
                        Sistem Reservasi Fasilitas
                    </span>
                </div>
                <!-- Tombol Pencarian Dan Login -->
                <div class="flex items-center gap-4">
                    <div class="relative group hidden sm:block">
                        <!-- Icon Pencarian -->
                        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                            <svg xmlns="http://www.w3.org/2000/svg"
                                class="h-5 w-5 text-slate-400 group-hover:text-blue-600 transition-colors duration-200"
                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </div>
                        <!-- Input Pencarian -->
                        <input type="text" placeholder="Cari fasilitas..."
                            class="w-48 pl-10 pr-4 py-2 bg-slate-50 border border-slate-200 rounded-lg text-sm text-slate-700 focus:outline-none focus:bg-white focus:border-blue-500 focus:w-64 transition-all duration-300 placeholder-slate-400">
                    </div>
                    <!-- Tombol Login -->
                    <a href="/admin/login"
                        class="px-5 py-2 text-sm font-semibold text-white bg-blue-600 hover:bg-blue-700 rounded-lg shadow-sm hover:shadow-md transition-all duration-200">
                        Admin Login
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <main class="min-h-screen pt-16 px-4">
        <div class="max-w-7xl mx-auto">

            <!-- DITAMBAHKAN - Section Hero -->
            <div class="py-12 text-center">
                <h1 class="text-4xl sm:text-5xl font-extrabold text-slate-900 tracking-tight leading-tight">
                    Peminjaman Fasilitas Kampus <br>
                    <span class="text-blue-600">Jadi Lebih Mudah & Cepat</span>
                </h1>

                <p class="mt-4 text-base sm:text-lg text-slate-500 max-w-2xl mx-auto">
                    Sistem platform terpadu untuk Mahasiswa dan Dosen guna melakukan reservasi ruangan, laboratorium,
                    maupun alat penunjang belajar mengajar secara real-time.
                </p>

                <div
                    class="mt-10 max-w-md mx-auto bg-white p-6 sm:p-8 rounded-2xl shadow-xl shadow-slate-200/50 border border-slate-100">
                    <h3 class="text-lg font-bold text-slate-800 mb-2">Mulai Pengajuan Reservasi</h3>
                    <p class="text-sm text-slate-500 mb-6">Silakan masuk ke halaman peminjaman khusus Mahasiswa dan
                        Dosen.</p>

                    <a href="/peminjaman"
                        class="block w-full py-3 px-6 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-xl shadow-lg shadow-blue-500/20 transform hover:-translate-y-0.5 transition-all duration-200 text-center">
                        Mulai Peminjaman Sekarang
                    </a>

                    <div class="mt-4 flex items-center justify-center gap-2 text-xs text-slate-400">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-emerald-500" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                        </svg>
                        <span>Gunakan Akun Email Kampus aktif</span>
                    </div>
                </div>
            </div>

            <!-- DITAMBAHKAN - Section Calendar -->
            <div class="mt-16 mb-12">
                <div class="bg-white rounded-2xl shadow-lg shadow-slate-200/50 border border-slate-100 p-6 sm:p-8">
                    <h2 class="text-2xl sm:text-3xl font-bold text-slate-900 mb-2">Jadwal Reservasi Fasilitas</h2>
                    <p class="text-slate-600 mb-6">Lihat semua jadwal reservasi fasilitas yang telah disetujui</p>

                    <!-- DITAMBAHKAN - Calendar Container -->
                    <div id="calendar" class="rounded-lg overflow-hidden border border-slate-200"></div>
                </div>
            </div>

        </div>
    </main>

    <!-- DITAMBAHKAN - Modal Detail Event -->
    <div id="eventModal" class="fixed inset-0 bg-black/15 flex items-center justify-center z-50 p-4"
        style="display: none;">
        <div class="bg-white rounded-2xl shadow-2xl max-w-md w-full">
            <div
                class="bg-linear-to-r rounded-t-2xl from-blue-600 to-blue-700 px-6 py-4 flex items-center justify-between">
                <h3 class="text-xl font-bold text-white">Detail Reservasi</h3>
                <button onclick="closeEventModal()" class="text-white hover:text-blue-100 transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <div class="p-6 space-y-4">
                <div class="border-b border-slate-200 pb-4">
                    <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1">Kode Tiket</p>
                    <p id="eventTicketCode" class="text-lg font-bold text-slate-900"></p>
                </div>

                <div class="border-b border-slate-200 pb-4">
                    <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1">Nama Kegiatan</p>
                    <p id="eventName" class="text-lg font-semibold text-slate-800"></p>
                </div>

                <div class="border-b border-slate-200 pb-4">
                    <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1">Fasilitas</p>
                    <p id="eventFacility" class="text-lg font-semibold text-blue-600"></p>
                </div>

                <div class="border-b border-slate-200 pb-4">
                    <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1">Peminjam</p>
                    <p id="eventUser" class="text-lg font-semibold text-slate-800"></p>
                </div>

                <div class="border-b border-slate-200 pb-4">
                    <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1">Tanggal & Waktu</p>
                    <p id="eventDate" class="text-lg font-semibold text-slate-800"></p>
                </div>

                <div class="bg-emerald-50 border border-emerald-200 rounded-lg p-3">
                    <p class="text-xs font-semibold text-emerald-600 uppercase tracking-wider">Status</p>
                    <p id="eventStatus" class="text-sm font-bold text-emerald-700 mt-1"></p>
                </div>
            </div>

            <div class="bg-slate-50 px-6 py-3 flex justify-end rounded-b-2xl border-t border-slate-200">
                <button onclick="closeEventModal()"
                    class="px-4 py-2 bg-slate-200 hover:bg-slate-300 text-slate-800 font-medium rounded-lg transition">
                    Tutup
                </button>
            </div>
        </div>
    </div>

    <!-- DITAMBAHKAN - FullCalendar JS -->
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.js'></script>

    <!-- DITAMBAHKAN - Custom Calendar Script -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const calendarEl = document.getElementById('calendar');

            const calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay'
                },
                events: {
                    url: '/reservation-calendar-events',
                    failure: function() {
                        alert('Gagal memuat data kalender');
                    }
                },
                eventClick: function(info) {
                    showEventModal(info.event);
                },
                locale: 'id',
                buttonText: {
                    today: 'Hari Ini',
                    month: 'Bulan',
                    week: 'Minggu',
                    day: 'Hari',
                    list: 'Daftar'
                },
                eventDisplay: 'block',
                height: 'auto',
                contentHeight: 'auto',
                eventBackgroundColor: '#2563eb',
                eventBorderColor: '#1e40af',
                eventTextColor: '#ffffff'
            });

            calendar.render();
        });

        // DITAMBAHKAN - Fungsi untuk menampilkan modal dengan detail event
        function showEventModal(event) {
            document.getElementById('eventTicketCode').textContent = event.extendedProps.ticket_code;
            document.getElementById('eventName').textContent = event.extendedProps.event_name;
            document.getElementById('eventFacility').textContent = event.extendedProps.facility;
            document.getElementById('eventUser').textContent = event.extendedProps.user;

            // Format tanggal ke Indonesia
            const startDate = new Date(event.start);
            const formattedDate = startDate.toLocaleDateString('id-ID', {
                weekday: 'long',
                year: 'numeric',
                month: 'long',
                day: 'numeric',
                hour: '2-digit',
                minute: '2-digit'
            });
            document.getElementById('eventDate').textContent = formattedDate;

            document.getElementById('eventStatus').textContent = event.extendedProps.status.toUpperCase();

            document.getElementById('eventModal').style.display = 'flex';
        }

        // DITAMBAHKAN - Fungsi untuk menutup modal
        function closeEventModal() {
            document.getElementById('eventModal').style.display = 'none';
        }

        // DITAMBAHKAN - Tutup modal saat klik background
        document.getElementById('eventModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeEventModal();
            }
        });
    </script>

</body>

</html>
