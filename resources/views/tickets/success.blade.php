<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Reservasi Berhasil</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 text-gray-900">

    <div class="flex min-h-screen items-center justify-center px-4">
        <div class="max-w-md rounded-xl bg-white p-8 text-center shadow">
            <div class="mb-4 text-5xl">
                ✅
            </div>

            <h1 class="mb-2 text-2xl font-bold">
                Reservasi Berhasil Diajukan
            </h1>

            <p class="mb-6 text-sm text-gray-600">
                Data peminjaman sudah masuk ke sistem dan sedang menunggu konfirmasi admin.
            </p>

            <a href="{{ route('home') }}"
               class="inline-flex rounded-lg bg-blue-600 px-5 py-2.5 text-sm font-semibold text-white hover:bg-blue-700">
                Kembali ke Beranda
            </a>
        </div>
    </div>

</body>
</html>