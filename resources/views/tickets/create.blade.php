<!DOCTYPE html>
<html lang="id">
    <head>
        <meta charset="UTF-8">
        <title>Ajukan Reservasi Fasilitas</title>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>

    <body class="bg-slate-50 text-gray-900">

        <div class="min-h-screen py-12">
            <div class="mx-auto max-w-3xl px-4">

                <div class="mb-6">
                    <a href="{{ route('home') }}"
                        class="inline-flex items-center gap-1 text-sm font-medium text-blue-600 hover:text-blue-700 hover:underline">
                        ← Kembali ke Beranda
                    </a>
                </div>

                <div class="overflow-hidden rounded-2xl bg-white shadow-sm ring-1 ring-gray-200">

                    {{-- Header --}}
                    <div class="border-b border-gray-100 bg-gradient-to-r from-blue-50 via-white to-white px-8 py-7">
                        <h1 class="text-2xl font-bold text-gray-900">
                            Ajukan Ticket Peminjaman Fasilitas
                        </h1>
                        <p class="mt-1.5 text-sm text-gray-500">
                            Masukkan email kampus dan password yang sudah terdaftar untuk mengajukan reservasi.
                        </p>
                    </div>

                    <div class="px-8 py-8">

                        @if ($errors->any())
                            <div class="mb-6 rounded-xl border border-red-200 bg-red-50 p-4 text-sm text-red-700">
                                <strong class="font-semibold">Terjadi kesalahan:</strong>
                                <ul class="mt-2 list-inside list-disc space-y-0.5">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form action="{{ route('tickets.store') }}" method="POST" class="space-y-8">
                            @csrf

                            {{-- Section: Verifikasi --}}
                            <div class="rounded-xl border border-blue-100 bg-blue-50/40 p-5">
                                <div class="mb-4 flex items-center gap-2.5">
                                    <span
                                        class="flex h-7 w-7 items-center justify-center rounded-lg bg-blue-600 text-xs font-bold text-white">1</span>
                                    <h2 class="text-base font-semibold text-gray-900">
                                        Verifikasi Data Peminjam
                                    </h2>
                                </div>

                                <div class="grid gap-5 md:grid-cols-2">
                                    <div>
                                        <label for="email" class="mb-1.5 block text-sm font-medium text-gray-700">
                                            Email Instansi
                                        </label>
                                        <input type="email" name="email" id="email" value="{{ old('email') }}"
                                            required placeholder="contoh@email.pkl.co"
                                            class="w-full rounded-lg border-gray-300 bg-white px-3.5 py-2.5 text-sm shadow-sm transition focus:border-blue-500 focus:ring-2 focus:ring-blue-500/30">
                                    </div>

                                    <div>
                                        <label for="password" class="mb-1.5 block text-sm font-medium text-gray-700">
                                            Password
                                        </label>
                                        <input type="password" name="password" id="password" required
                                            placeholder="Masukkan password"
                                            class="w-full rounded-lg border-gray-300 bg-white px-3.5 py-2.5 text-sm shadow-sm transition focus:border-blue-500 focus:ring-2 focus:ring-blue-500/30">
                                    </div>
                                </div>
                            </div>

                            {{-- Section: Detail Fasilitas --}}
                            <div class="rounded-xl border border-emerald-100 bg-emerald-50/30 p-5">
                                <div class="mb-4 flex items-center gap-2.5">
                                    <span
                                        class="flex h-7 w-7 items-center justify-center rounded-lg bg-emerald-600 text-xs font-bold text-white">2</span>
                                    <h2 class="text-base font-semibold text-gray-900">
                                        Detail Fasilitas
                                    </h2>
                                </div>

                                <div class="space-y-5">
                                    <div>
                                        <label for="sub_category_id" class="mb-1.5 block text-sm font-medium text-gray-700">
                                            Pilih Lokasi / Gedung
                                        </label>
                                        <select name="sub_category_id" id="sub_category_id" required
                                            class="w-full rounded-lg border-gray-300 bg-white px-3.5 py-2.5 text-sm shadow-sm transition focus:border-blue-500 focus:ring-2 focus:ring-blue-500/30">
                                            <option value="">-- Pilih Lokasi / Gedung --</option>
                                            @foreach ($subCategories as $subCategory)
                                                <option value="{{ $subCategory->id }}" @selected(old('sub_category_id') == $subCategory->id)>
                                                    {{ $subCategory->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div>
                                        <label for="facility_id" class="mb-1.5 block text-sm font-medium text-gray-700">
                                            Pilih Fasilitas
                                        </label>
                                        <select name="facility_id" id="facility_id" required disabled
                                            class="w-full rounded-lg border-gray-300 bg-white px-3.5 py-2.5 text-sm shadow-sm transition focus:border-blue-500 focus:ring-2 focus:ring-blue-500/30 disabled:cursor-not-allowed disabled:bg-gray-100 disabled:text-gray-400">
                                            <option value="">-- Pilih Lokasi / Gedung terlebih dahulu --</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            {{-- Section: Info Kegiatan --}}
                            <div class="rounded-xl border border-amber-100 bg-amber-50/30 p-5">
                                <div class="mb-4 flex items-center gap-2.5">
                                    <span
                                        class="flex h-7 w-7 items-center justify-center rounded-lg bg-amber-600 text-xs font-bold text-white">3</span>
                                    <h2 class="text-base font-semibold text-gray-900">
                                        Informasi Kegiatan
                                    </h2>
                                </div>

                                <div class="space-y-5">
                                    <div>
                                        <label for="event_name" class="mb-1.5 block text-sm font-medium text-gray-700">
                                            Nama Kegiatan
                                        </label>
                                        <input type="text" name="event_name" id="event_name"
                                            value="{{ old('event_name') }}" required
                                            placeholder="Contoh: Seminar, Rapat, Ujian Lab"
                                            class="w-full rounded-lg border-gray-300 bg-white px-3.5 py-2.5 text-sm shadow-sm transition focus:border-blue-500 focus:ring-2 focus:ring-blue-500/30">
                                    </div>

                                    <div>
                                        <label for="purpose" class="mb-1.5 block text-sm font-medium text-gray-700">
                                            Tujuan Peminjaman
                                        </label>
                                        <textarea name="purpose" id="purpose" rows="3" placeholder="Jelaskan tujuan peminjaman fasilitas"
                                            class="w-full rounded-lg border-gray-300 bg-white px-3.5 py-2.5 text-sm shadow-sm transition focus:border-blue-500 focus:ring-2 focus:ring-blue-500/30">{{ old('purpose') }}</textarea>
                                    </div>

                                    <div class="grid gap-5 md:grid-cols-2">
                                        <div>
                                            <label for="date" class="mb-1.5 block text-sm font-medium text-gray-700">
                                                Tanggal & Jam Mulai
                                            </label>
                                            <input type="datetime-local" name="date" id="date"
                                                value="{{ old('date') }}" required
                                                class="w-full rounded-lg border-gray-300 bg-white px-3.5 py-2.5 text-sm shadow-sm transition focus:border-blue-500 focus:ring-2 focus:ring-blue-500/30">
                                        </div>

                                        <div>
                                            <label for="date_end" class="mb-1.5 block text-sm font-medium text-gray-700">
                                                Tanggal & Jam Selesai
                                            </label>
                                            <input type="datetime-local" name="date_end" id="date_end"
                                                value="{{ old('date_end') }}" required
                                                class="w-full rounded-lg border-gray-300 bg-white px-3.5 py-2.5 text-sm shadow-sm transition focus:border-blue-500 focus:ring-2 focus:ring-blue-500/30">
                                        </div>
                                    </div>

                                    <div>
                                        <label for="note" class="mb-1.5 block text-sm font-medium text-gray-700">
                                            Catatan Tambahan
                                        </label>
                                        <textarea name="note" id="note" rows="3" placeholder="Opsional"
                                            class="w-full rounded-lg border-gray-300 bg-white px-3.5 py-2.5 text-sm shadow-sm transition focus:border-blue-500 focus:ring-2 focus:ring-blue-500/30">{{ old('note') }}</textarea>
                                    </div>
                                </div>
                            </div>

                            {{-- Actions --}}
                            <div class="flex items-center justify-end gap-3 border-t border-gray-100 pt-6">
                                <a href="{{ route('home') }}"
                                    class="rounded-lg border border-gray-300 px-5 py-2.5 text-sm font-semibold text-gray-700 transition hover:bg-gray-50">
                                    Batal
                                </a>

                                <button type="submit"
                                    class="rounded-lg bg-blue-600 px-6 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-blue-700 hover:shadow-md">
                                    Ajukan Reservasi
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>

        <script>
            const allFacilities = @json($facilities);

            const subCategorySelect = document.getElementById('sub_category_id');
            const facilitySelect = document.getElementById('facility_id');
            const oldFacilityId = '{{ old('facility_id') }}';
            const dateInput = document.getElementById('date');
            const dateEndInput = document.getElementById('date_end');
            const form = document.querySelector('form');

            function renderFacilityOptions(subCategoryId) {
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

            dateInput.addEventListener('change', validateDateRange);
            dateEndInput.addEventListener('change', validateDateRange);

            form.addEventListener('submit', function(e) {
                if (!validateDateRange()) {
                    e.preventDefault();
                    dateEndInput.reportValidity();
                }
            });

            subCategorySelect.addEventListener('change', function() {
                renderFacilityOptions(this.value);
            });

            document.addEventListener('DOMContentLoaded', function() {
                if (subCategorySelect.value) {
                    renderFacilityOptions(subCategorySelect.value);
                }
            });
        </script>
    </body>
</html>