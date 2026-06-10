<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Reservasi Fasilitas</title>
    
    @vite('resources/css/app.css')
    @vite('resources/js/app.js')
</head>
<body class="bg-slate-50 font-sans antialiased text-slate-800">

    <nav class="fixed top-0 left-0 w-full h-16 bg-white border-b border-slate-100 shadow-sm z-50 transition-all duration-300">
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
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-slate-400 group-hover:text-blue-600 transition-colors duration-200" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </div>
                        <!-- Input Pencarian -->
                        <input 
                            type="text" 
                            placeholder="Cari fasilitas..." 
                            class="w-48 pl-10 pr-4 py-2 bg-slate-50 border border-slate-200 rounded-lg text-sm text-slate-700 focus:outline-none focus:bg-white focus:border-blue-500 focus:w-64 transition-all duration-300 placeholder-slate-400"
                        >
                    </div>
                    <!-- Tombol Login -->
                    <a href="/admin/login" class="px-5 py-2 text-sm font-semibold text-white bg-blue-600 hover:bg-blue-700 rounded-lg shadow-sm hover:shadow-md transition-all duration-200">
                        Admin Login
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <main class="min-h-screen flex items-center justify-center pt-16 px-4">
        <div class="max-w-4xl w-full text-center">

            <h1 class="mt-6 text-4xl sm:text-5xl font-extrabold text-slate-900 tracking-tight leading-tight">
                Peminjaman Fasilitas Kampus <br>
                <span class="text-blue-600">Jadi Lebih Mudah & Cepat</span>
            </h1>
            
            <p class="mt-4 text-base sm:text-lg text-slate-500 max-w-2xl mx-auto">
                Sistem platform terpadu untuk Mahasiswa dan Dosen guna melakukan reservasi ruangan, laboratorium, maupun alat penunjang belajar mengajar secara real-time.
            </p>

            <div class="mt-10 max-w-md mx-auto bg-white p-6 sm:p-8 rounded-2xl shadow-xl shadow-slate-200/50 border border-slate-100">
                <h3 class="text-lg font-bold text-slate-800 mb-2">Mulai Pengajuan Reservasi</h3>
                <p class="text-sm text-slate-500 mb-6">Silakan masuk ke halaman peminjaman khusus Mahasiswa dan Dosen.</p>
                
                <a href="/peminjaman" class="block w-full py-3 px-6 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-xl shadow-lg shadow-blue-500/20 transform hover:-translate-y-0.5 transition-all duration-200 text-center">
                    Mulai Peminjaman Sekarang
                </a>
                
                <div class="mt-4 flex items-center justify-center gap-2 text-xs text-slate-400">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                    </svg>
                    <span>Gunakan Akun Email Kampus aktif</span>
                </div>
            </div>

        </div>
    </main>

</body>
</html>