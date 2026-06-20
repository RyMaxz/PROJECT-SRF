<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Ajukan Reservasi Fasilitas</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-100 text-gray-900">

    <div class="min-h-screen py-10">
        <div class="mx-auto max-w-3xl px-4">

            <div class="mb-6">
                <a href="{{ route('home') }}" class="text-sm text-blue-600 hover:underline">
                    ← Kembali ke Beranda
                </a>
            </div>

            <div class="rounded-xl bg-white p-6 shadow">
                <h1 class="mb-2 text-2xl font-bold">
                    Ajukan Ticket Peminjaman Fasilitas
                </h1>

                <p class="mb-6 text-sm text-gray-600">
                    Masukkan email kampus dan password yang sudah terdaftar untuk mengajukan reservasi.
                </p>

                @if ($errors->any())
                    <div class="mb-5 rounded-lg border border-red-200 bg-red-50 p-4 text-sm text-red-700">
                        <strong>Terjadi kesalahan:</strong>
                        <ul class="mt-2 list-inside list-disc">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('tickets.store') }}" method="POST" class="space-y-5">
                    @csrf

                    <div class="rounded-lg border border-gray-200 bg-gray-50 p-4">
                        <h2 class="mb-4 text-lg font-semibold">
                            Verifikasi Data Peminjam
                        </h2>

                        <div class="grid gap-5 md:grid-cols-2">
                            <div>
                                <label for="email" class="mb-1 block text-sm font-medium">
                                    Email Instansi
                                </label>

                                <input type="email" name="email" id="email" value="{{ old('email') }}" required
                                    placeholder="contoh email@pkl.co"
                                    class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            </div>

                            <div>
                                <label for="password" class="mb-1 block text-sm font-medium">
                                    Password
                                </label>

                                <input type="password" name="password" id="password" required
                                    placeholder="Masukkan password"
                                    class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            </div>
                        </div>
                    </div>

                    <div>
                        <label for="sub_category_id" class="mb-1 block text-sm font-medium">
                            Pilih Lokasi / Gedung
                        </label>

                        <select name="sub_category_id" id="sub_category_id" required
                            class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            <option value="">-- Pilih Lokasi / Gedung --</option>

                            @foreach ($subCategories as $subCategory)
                                <option value="{{ $subCategory->id }}" @selected(old('sub_category_id') == $subCategory->id)>
                                    {{ $subCategory->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label for="facility_id" class="mb-1 block text-sm font-medium">
                            Pilih Fasilitas
                        </label>

                        <select name="facility_id" id="facility_id" required disabled
                            class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 disabled:bg-gray-100 disabled:cursor-not-allowed">
                            <option value="">-- Pilih Lokasi / Gedung terlebih dahulu --</option>
                        </select>
                    </div>
                    <div>
                        <label for="event_name" class="mb-1 block text-sm font-medium">
                            Nama Kegiatan
                        </label>

                        <input type="text" name="event_name" id="event_name" value="{{ old('event_name') }}" required
                            placeholder="Contoh: Seminar, Rapat, Ujian Lab"
                            class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    </div>

                    <div>
                        <label for="purpose" class="mb-1 block text-sm font-medium">
                            Tujuan Peminjaman
                        </label>

                        <textarea name="purpose" id="purpose" rows="3" placeholder="Jelaskan tujuan peminjaman fasilitas"
                            class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">{{ old('purpose') }}</textarea>
                    </div>

                    <div class="grid gap-5 md:grid-cols-2">
                        <div>
                            <label for="date" class="mb-1 block text-sm font-medium">
                                Tanggal & Jam Mulai
                            </label>

                            <input type="datetime-local" name="date" id="date" value="{{ old('date') }}"
                                required
                                class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        </div>

                        <div>
                            <label for="date_end" class="mb-1 block text-sm font-medium">
                                Tanggal & Jam Selesai
                            </label>

                            <input type="datetime-local" name="date_end" id="date_end" value="{{ old('date_end') }}"
                                required
                                class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        </div>
                    </div>

                    <div>
                        <label for="note" class="mb-1 block text-sm font-medium">
                            Catatan Tambahan
                        </label>

                        <textarea name="note" id="note" rows="3" placeholder="Opsional"
                            class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">{{ old('note') }}</textarea>
                    </div>

                    <div class="flex items-center justify-end gap-3">
                        <a href="{{ route('home') }}"
                            class="rounded-lg border border-gray-300 px-5 py-2.5 text-sm font-semibold text-gray-700 hover:bg-gray-50">
                            Batal
                        </a>

                        <button type="submit"
                            class="rounded-lg bg-blue-600 px-5 py-2.5 text-sm font-semibold text-white hover:bg-blue-700">
                            Ajukan Reservasi
                        </button>
                    </div>
                </form>
            </div>

        </div>
    </div>
    <script>
        // Data fasilitas lengkap dengan subcategory_id, dikirim dari controller
        const allFacilities = @json($facilities);

        const subCategorySelect = document.getElementById('sub_category_id');
        const facilitySelect = document.getElementById('facility_id');
        const oldFacilityId = '{{ old('facility_id') }}';
        const dateInput = document.getElementById('date');
        const dateEndInput = document.getElementById('date_end');
        const form = document.querySelector('form');

        function renderFacilityOptions(subCategoryId) {
            // reset dulu
            facilitySelect.innerHTML = '';

            if (!subCategoryId) {
                facilitySelect.disabled = true;
                facilitySelect.innerHTML = '<option value="">-- Pilih Lokasi / Gedung terlebih dahulu --</option>';
                return;
            }

            const filtered = allFacilities.filter(
                (facility) => String(facility.subcategory_id) === String(subCategoryId)
            );

            if (filtered.length === 0) {
                facilitySelect.disabled = true;
                facilitySelect.innerHTML = '<option value="">-- Tidak ada fasilitas tersedia di lokasi ini --</option>';
                return;
            }

            facilitySelect.disabled = false;

            const defaultOption = document.createElement('option');
            defaultOption.value = '';
            defaultOption.textContent = '-- Pilih Fasilitas --';
            facilitySelect.appendChild(defaultOption);

            filtered.forEach((facility) => {
                const option = document.createElement('option');
                option.value = facility.id;
                option.textContent = facility.capacity ?
                    `${facility.name} - Kapasitas ${facility.capacity}` :
                    facility.name;

                if (oldFacilityId && String(oldFacilityId) === String(facility.id)) {
                    option.selected = true;
                }

                facilitySelect.appendChild(option);
            });
        }

        function validateDateRange() {
            if (!dateInput.value || !dateEndInput.value) return true;
            
            const dateStart = new Date(dateInput.value);
            const dateEnd = new Date(dateEndInput.value);
            
            if (dateEnd <= dateStart) {
                dateEndInput.setCustomValidity('Jam selesai harus lebih besar dari jam mulai');
                return false;
            } else {
                dateEndInput.setCustomValidity('');
                return true;
            }
        }

        // Validasi saat user berubah input date/time
        dateInput.addEventListener('change', validateDateRange);
        dateEndInput.addEventListener('change', validateDateRange);

        // Validasi sebelum form disubmit
        form.addEventListener('submit', function(e) {
            if (!validateDateRange()) {
                e.preventDefault();
                dateEndInput.reportValidity();
            }
        });

        subCategorySelect.addEventListener('change', function() {
            renderFacilityOptions(this.value);
        });

        // kalau form di-reload setelah error validasi (old input), restore pilihan sebelumnya
        document.addEventListener('DOMContentLoaded', function() {
            if (subCategorySelect.value) {
                renderFacilityOptions(subCategorySelect.value);
            }
        });
    </script>
</body>

</html>
