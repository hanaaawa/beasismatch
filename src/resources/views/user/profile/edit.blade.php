<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cari Beasiswa - BeasisMatch</title>
    <!-- Modern Google Font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Plus Jakarta Sans', 'sans-serif'],
                    },
                },
            },
        }
    </script>
    <style>
        .glass-card {
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border: 1px solid rgba(15, 23, 42, 0.08);
        }
        .glow-effect {
            box-shadow: 0 0 20px rgba(30, 64, 175, 0.08);
        }
        /* Custom radio card active state helper */
        input[type="radio"]:checked + span, input[type="checkbox"]:checked + span {
            color: #1d4ed8;
        }
        input[type="radio"]:checked + .card-wrapper, input[type="checkbox"]:checked + .card-wrapper {
            border-color: #2563eb;
            background-color: rgba(37, 99, 235, 0.08);
        }
    </style>
    <!-- Alpine.js CDN -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="bg-slate-50 text-slate-800 font-sans min-h-screen selection:bg-blue-200 selection:text-blue-900 overflow-x-hidden">

    <!-- DECORATIVE BACKGROUND GLOW -->
    <div class="absolute top-0 left-1/4 w-96 h-96 bg-blue-200/30 rounded-full blur-[100px] pointer-events-none"></div>
    <div class="absolute top-1/3 right-1/4 w-[400px] h-[400px] bg-indigo-200/30 rounded-full blur-[120px] pointer-events-none"></div>

    @php
        $genderValue = old('gender', $profile?->gender);
        $educationStatusValue = old('education_status', $profile?->education_status);
        $educationLevelValue = old('education_level', $profile?->education_level);
        $institutionTypeValue = old('institution_type', $profile?->institution_type);
        $targetEducationLevelValue = old('target_education_level', $profile?->target_education_level);
        $scholarshipScopeValue = old('scholarship_scope', $profile?->scholarship_scope);

        $oldTargetSemesters = old('target_semesters', $profile?->target_semesters ?? []);

        $oldTargetCountries = old(
            'target_countries',
            is_array($profile?->target_countries) ? implode(', ', $profile->target_countries) : ''
        );

        $hasActiveScholarshipValue = old(
            'has_active_scholarship',
            $profile?->has_active_scholarship === null ? null : (int) $profile->has_active_scholarship
        );

        $isLowIncomeValue = old(
            'is_low_income',
            $profile?->is_low_income === null ? null : (int) $profile->is_low_income
        );
    @endphp

    <!-- HEADER -->
    <header class="sticky top-0 z-40 bg-white/80 backdrop-blur-md border-b border-slate-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4 flex justify-between items-center">
            
            <a href="{{ route('user.dashboard') }}" class="flex items-center gap-2 group">
                <img src="{{ asset('images/logo.png') }}" alt="BeasisMatch Logo" class="h-10 w-auto object-contain">
            </a>

            <div class="flex items-center gap-2 sm:gap-4">
                <a href="{{ route('landing') }}" 
                   class="px-3 py-2 rounded-xl text-sm font-semibold text-slate-600 hover:text-blue-700 hover:bg-slate-100 transition duration-200">
                    Home
                </a>
                <a href="{{ route('user.dashboard') }}" 
                   class="px-3 py-2 rounded-xl text-sm font-semibold text-slate-600 hover:text-blue-700 hover:bg-slate-100 transition duration-200">
                    Dashboard
                </a>
                <a href="{{ route('user.scholarships.search') }}" 
                   class="px-3 py-2 rounded-xl text-sm font-semibold text-slate-600 hover:text-blue-700 hover:bg-slate-100 transition duration-200">
                    Cari Beasiswa
                </a>
                <a href="{{ route('user.forum.index') }}" 
                   class="px-3 py-2 rounded-xl text-sm font-semibold text-slate-600 hover:text-blue-700 hover:bg-slate-100 transition duration-200">
                    Forum
                </a>

                <!-- Profile Dropdown -->
                <div class="relative" x-data="{ open: false }">
                    <button @click="open = !open" @click.away="open = false" class="flex items-center focus:outline-none transition-transform hover:scale-105 duration-200">
                        <img class="h-9 w-9 rounded-full object-cover border border-slate-300 shadow-sm" 
                             src="{{ auth()->user()->getFilamentAvatarUrl() }}" 
                             alt="User Avatar">
                    </button>

                    <div x-show="open" 
                         x-transition:enter="transition ease-out duration-100"
                         x-transition:enter-start="transform opacity-0 scale-95"
                         x-transition:enter-end="transform opacity-100 scale-100"
                         x-transition:leave="transition ease-in duration-75"
                         x-transition:leave-start="transform opacity-100 scale-100"
                         x-transition:leave-end="transform opacity-0 scale-95"
                         class="absolute right-0 mt-2 w-48 rounded-2xl bg-white py-2 shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none z-50 border border-slate-100"
                         style="display: none;">

                        <div class="px-4 py-2 text-xs text-slate-500 border-b border-slate-100 font-semibold truncate">
                            {{ auth()->user()->name }}
                        </div>

                        <a href="{{ route('user.dashboard') }}" class="block px-4 py-2 text-sm text-slate-700 hover:bg-slate-50 transition duration-150">
                            Dashboard
                        </a>

                        <a href="{{ route('user.profile.edit') }}" class="block px-4 py-2 text-sm text-slate-700 hover:bg-slate-50 transition duration-150">
                            Edit Profil
                        </a>

                        <hr class="border-slate-100 my-1">

                        <form action="{{ route('user.logout') }}" method="POST" class="block w-full">
                            @csrf
                            <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50 transition duration-150">
                                Keluar
                            </button>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </header>

    <!-- MAIN -->
    <main class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-10 space-y-8">
        
        <!-- TITLE SECTION -->
        <section class="glass-card rounded-3xl p-8 text-center shadow-md glow-effect">
            <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-800">
                Temukan Beasiswa Pilihanmu 🎯
            </h2>
            <p class="mt-2 text-sm text-slate-500 max-w-xl mx-auto">
                Isi parameter data diri dan kondisi akademik Anda di bawah. *Matching engine* kami akan segera menganalisis opsi pendanaan beasiswa yang paling relevan.
            </p>
        </section>

        <!-- ERROR ALERTS -->
        @if ($errors->any())
            <div class="p-5 rounded-2xl bg-red-50 border border-red-200 text-red-600 text-xs">
                <p class="font-bold mb-2">Mohon perbaiki isian data berikut:</p>
                <ul class="list-disc pl-4 space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('user.profile.update') }}" class="space-y-6 relative pb-24">
            @csrf

            <!-- DATA DIRI -->
            <section class="glass-card rounded-3xl p-6 sm:p-8 space-y-6 shadow-sm">
                <div class="space-y-1">
                    <h3 class="text-lg font-bold text-slate-800 flex items-center gap-2">
                        <span class="w-1.5 h-6 bg-blue-600 rounded"></span>
                        Data Diri Dasar
                    </h3>
                    <p class="text-xs text-slate-500">Informasi utama identitas pencari beasiswa.</p>
                </div>

                <div class="space-y-5">
                    <!-- Gender -->
                    <div class="space-y-2">
                        <label class="text-xs font-semibold text-slate-600">Jenis Kelamin</label>
                        <div class="grid grid-cols-2 gap-4">
                            <label class="relative flex cursor-pointer items-center justify-between gap-3 rounded-xl border border-slate-200 bg-slate-50 p-4 hover:bg-slate-100 transition">
                                <span class="text-sm font-semibold text-slate-700">Laki-Laki</span>
                                <input type="radio" name="gender" value="male" required @checked($genderValue === 'male') class="text-blue-600 focus:ring-0 focus:ring-offset-0 bg-white border-slate-300">
                            </label>

                            <label class="relative flex cursor-pointer items-center justify-between gap-3 rounded-xl border border-slate-200 bg-slate-50 p-4 hover:bg-slate-100 transition">
                                <span class="text-sm font-semibold text-slate-700">Perempuan</span>
                                <input type="radio" name="gender" value="female" required @checked($genderValue === 'female') class="text-blue-600 focus:ring-0 focus:ring-offset-0 bg-white border-slate-300">
                            </label>
                        </div>
                    </div>

                    <!-- Birth Date & Phone -->
                    <div class="grid sm:grid-cols-2 gap-4">
                        <div class="space-y-1.5">
                            <label class="text-xs font-semibold text-slate-600">Tanggal Lahir</label>
                            <input
                                type="date"
                                name="birth_date"
                                value="{{ old('birth_date', $profile?->birth_date?->format('Y-m-d')) }}"
                                required
                                class="w-full rounded-xl bg-white border border-slate-300 focus:border-blue-500 focus:ring-1 focus:ring-blue-500/30 text-slate-800 px-4 py-2.5 text-sm focus:outline-none transition duration-200"
                            >
                        </div>

                        <div class="space-y-1.5">
                            <label class="text-xs font-semibold text-slate-600">Nomor HP / WhatsApp</label>
                            <input
                                type="text"
                                name="phone"
                                value="{{ old('phone', $profile?->phone) }}"
                                placeholder="Contoh: 08123456789"
                                class="w-full rounded-xl bg-white border border-slate-300 focus:border-blue-500 focus:ring-1 focus:ring-blue-500/30 text-slate-800 placeholder-slate-400 px-4 py-2.5 text-sm focus:outline-none transition duration-200"
                            >
                        </div>
                    </div>
                </div>
            </section>

            <!-- DOMISILI -->
            <section class="glass-card rounded-3xl p-6 sm:p-8 space-y-6 shadow-sm">
                <div class="space-y-1">
                    <h3 class="text-lg font-bold text-slate-800 flex items-center gap-2">
                        <span class="w-1.5 h-6 bg-indigo-600 rounded"></span>
                        Asal Domisili
                    </h3>
                    <p class="text-xs text-slate-500">Digunakan untuk beasiswa dengan kriteria daerah tertentu.</p>
                </div>

                <div class="grid sm:grid-cols-2 gap-4">
                    <div class="space-y-1.5">
                        <label class="text-xs font-semibold text-slate-600">Provinsi</label>
                        <select
                            id="provinceSelect"
                            name="province"
                            required
                            class="w-full rounded-xl bg-white border border-slate-300 focus:border-blue-500 focus:ring-1 focus:ring-blue-500/30 text-slate-800 px-4 py-2.5 text-sm focus:outline-none transition duration-200"
                        >
                            <option value="">Pilih provinsi kamu</option>
                        </select>
                    </div>

                    <div class="space-y-1.5">
                        <label class="text-xs font-semibold text-slate-600">Kota / Kabupaten</label>
                        <select
                            id="citySelect"
                            name="city"
                            required
                            class="w-full rounded-xl bg-white border border-slate-300 focus:border-blue-500 focus:ring-1 focus:ring-blue-500/30 text-slate-800 px-4 py-2.5 text-sm focus:outline-none transition duration-200"
                        >
                            <option value="">Pilih kota/kabupaten kamu</option>
                        </select>
                    </div>
                </div>
            </section>

            <!-- STATUS PENDIDIKAN SAAT INI -->
            <section class="glass-card rounded-3xl p-6 sm:p-8 space-y-6 shadow-sm">
                <div class="space-y-1">
                    <h3 class="text-lg font-bold text-slate-800 flex items-center gap-2">
                        <span class="w-1.5 h-6 bg-blue-600 rounded"></span>
                        Status Akademik Saat Ini
                    </h3>
                    <p class="text-xs text-slate-500">Kondisi status pendidikan Anda yang terdaftar sekarang.</p>
                </div>

                <div class="grid gap-4 sm:grid-cols-2">
                    <label class="relative flex cursor-pointer items-center justify-between gap-3 rounded-xl border border-slate-200 bg-slate-50 p-4 hover:bg-slate-100 transition">
                        <span class="text-sm font-semibold text-slate-700">Pelajar/Mahasiswa Aktif</span>
                        <input type="radio" name="education_status" value="active" required @checked($educationStatusValue === 'active') class="text-blue-600 focus:ring-0 focus:ring-offset-0 bg-white border-slate-300">
                    </label>

                    <label class="relative flex cursor-pointer items-center justify-between gap-3 rounded-xl border border-slate-200 bg-slate-50 p-4 hover:bg-slate-100 transition">
                        <span class="text-sm font-semibold text-slate-700">Tidak Aktif / Sudah Lulus</span>
                        <input type="radio" name="education_status" value="inactive_graduated" required @checked($educationStatusValue === 'inactive_graduated') class="text-blue-600 focus:ring-0 focus:ring-offset-0 bg-white border-slate-300">
                    </label>

                    <label class="relative flex cursor-pointer items-center justify-between gap-3 rounded-xl border border-slate-200 bg-slate-50 p-4 hover:bg-slate-100 transition">
                        <span class="text-sm font-semibold text-slate-700">Gap Year</span>
                        <input type="radio" name="education_status" value="gap_year" required @checked($educationStatusValue === 'gap_year') class="text-blue-600 focus:ring-0 focus:ring-offset-0 bg-white border-slate-300">
                    </label>

                    <label class="relative flex cursor-pointer items-center justify-between gap-3 rounded-xl border border-slate-200 bg-slate-50 p-4 hover:bg-slate-100 transition">
                        <span class="text-sm font-semibold text-slate-700">Umum</span>
                        <input type="radio" name="education_status" value="general" required @checked($educationStatusValue === 'general') class="text-blue-600 focus:ring-0 focus:ring-offset-0 bg-white border-slate-300">
                    </label>
                </div>
            </section>

            <!-- DETAIL PENDIDIKAN -->
            <section class="glass-card rounded-3xl p-6 sm:p-8 space-y-6 shadow-sm">
                <div class="space-y-1">
                    <h3 class="text-lg font-bold text-slate-800 flex items-center gap-2">
                        <span class="w-1.5 h-6 bg-indigo-600 rounded"></span>
                        Detail Akademik Terakhir
                    </h3>
                    <p class="text-xs text-slate-500">Parameter krusial untuk hard-filtering kualifikasi IPK dan instansi.</p>
                </div>

                <div class="grid gap-5 sm:grid-cols-2">
                    <div class="space-y-1.5">
                        <label class="text-xs font-semibold text-slate-600">Pendidikan Terakhir / Saat Ini</label>
                        <select name="education_level" required class="w-full rounded-xl bg-white border border-slate-300 focus:border-blue-500 focus:ring-1 focus:ring-blue-500/30 text-slate-800 px-4 py-2.5 text-sm focus:outline-none transition duration-200">
                            <option value="">Pilih jenjang</option>
                            @foreach (['SMP', 'SMA', 'D3', 'D4', 'S1', 'S2', 'S3', 'Profesi'] as $level)
                                <option value="{{ $level }}" @selected($educationLevelValue === $level)>
                                    {{ $level }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="space-y-1.5">
                        <label class="text-xs font-semibold text-slate-600">Nama Sekolah / Kampus</label>
                        <input
                            type="text"
                            name="institution_name"
                            value="{{ old('institution_name', $profile?->institution_name) }}"
                            placeholder="Contoh: Universitas Indonesia"
                            class="w-full rounded-xl bg-white border border-slate-300 focus:border-blue-500 focus:ring-1 focus:ring-blue-500/30 text-slate-800 placeholder-slate-400 px-4 py-2.5 text-sm focus:outline-none transition duration-200"
                        >
                    </div>

                    <div class="space-y-1.5">
                        <label class="text-xs font-semibold text-slate-600">Status Sekolah / Kampus</label>
                        <select name="institution_type" required class="w-full rounded-xl bg-white border border-slate-300 focus:border-blue-500 focus:ring-1 focus:ring-blue-500/30 text-slate-800 px-4 py-2.5 text-sm focus:outline-none transition duration-200">
                            <option value="">Pilih status</option>
                            <option value="school" @selected($institutionTypeValue === 'school')>Sekolah Dasar/Menengah (SMP/SMA/SMK)</option>
                            <option value="PTN" @selected($institutionTypeValue === 'PTN')>Perguruan Tinggi Negeri (PTN)</option>
                            <option value="PTS" @selected($institutionTypeValue === 'PTS')>Perguruan Tinggi Swasta (PTS)</option>
                            <option value="other" @selected($institutionTypeValue === 'other')>Lainnya</option>
                            <option value="not_applicable" @selected($institutionTypeValue === 'not_applicable')>Tidak Berlaku</option>
                        </select>
                    </div>

                    <div class="space-y-1.5">
                        <label class="text-xs font-semibold text-slate-600">IPK Aktual (GPA)</label>
                        <input
                            type="number"
                            step="0.01"
                            min="0"
                            max="4"
                            name="gpa"
                            value="{{ old('gpa', $profile?->gpa) }}"
                            placeholder="Kosongkan jika belum memiliki IPK"
                            class="w-full rounded-xl bg-white border border-slate-300 focus:border-blue-500 focus:ring-1 focus:ring-blue-500/30 text-slate-800 placeholder-slate-400 px-4 py-2.5 text-sm focus:outline-none transition duration-200"
                        >
                    </div>
                </div>
            </section>

            <!-- BEASISWA TARGET -->
            <section class="glass-card rounded-3xl p-6 sm:p-8 space-y-6 shadow-sm">
                <div class="space-y-1">
                    <h3 class="text-lg font-bold text-slate-800 flex items-center gap-2">
                        <span class="w-1.5 h-6 bg-blue-600 rounded"></span>
                        Preferensi Target Beasiswa
                    </h3>
                    <p class="text-xs text-slate-500">Tentukan tingkat target studi dan cakupan beasiswa yang dicari.</p>
                </div>

                <div class="space-y-5">
                    <div class="space-y-1.5">
                        <label class="text-xs font-semibold text-slate-600">Target Jenjang Pendidikan</label>
                        <select name="target_education_level" required class="w-full rounded-xl bg-white border border-slate-300 focus:border-blue-500 focus:ring-1 focus:ring-blue-500/30 text-slate-800 px-4 py-2.5 text-sm focus:outline-none transition duration-200">
                            <option value="">Pilih target jenjang</option>
                            @foreach (['SMP', 'SMA', 'D3', 'D4', 'S1', 'S2', 'S3', 'Profesi'] as $level)
                                <option value="{{ $level }}" @selected($targetEducationLevelValue === $level)>
                                    {{ $level }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Target Semester Checkboxes -->
                    <div class="space-y-3">
                        <label class="text-xs font-semibold text-slate-600 block">Kategori Target Semester Pendaftaran</label>
                        <div class="grid gap-3 sm:grid-cols-2">
                            @foreach ([
                                'calon_mahasiswa' => 'Calon Mahasiswa Baru / Gap Year',
                                'semester_1' => 'Semester 1 (Sudah Diterima)',
                                'semester_2' => 'Semester 2',
                                'semester_3' => 'Semester 3',
                                'semester_4' => 'Semester 4',
                                'semester_5' => 'Semester 5',
                                'semester_6' => 'Semester 6',
                                'semester_7' => 'Semester 7',
                                'semester_8' => 'Semester 8',
                                'semester_9_plus' => 'Semester 9 ke atas',
                            ] as $value => $label)
                                <label class="relative flex cursor-pointer items-center justify-between gap-3 rounded-xl border border-slate-200 bg-slate-50 p-4 hover:bg-slate-100 transition">
                                    <span class="text-xs font-semibold text-slate-700">{{ $label }}</span>
                                    <input
                                        type="checkbox"
                                        name="target_semesters[]"
                                        value="{{ $value }}"
                                        @checked(in_array($value, is_array($oldTargetSemesters) ? $oldTargetSemesters : []))
                                        class="text-blue-600 focus:ring-0 focus:ring-offset-0 bg-white border-slate-300 rounded"
                                    >
                                </label>
                            @endforeach
                        </div>
                    </div>
                </div>
            </section>

            <!-- LOKASI BEASISWA -->
            <section class="glass-card rounded-3xl p-6 sm:p-8 space-y-6 shadow-sm">
                <div class="space-y-1">
                    <h3 class="text-lg font-bold text-slate-800 flex items-center gap-2">
                        <span class="w-1.5 h-6 bg-indigo-600 rounded"></span>
                        Cakupan Geografis
                    </h3>
                    <p class="text-xs text-slate-500">Preferensi wilayah studi beasiswa.</p>
                </div>

                <div class="space-y-5">
                    <div class="grid gap-4 sm:grid-cols-3">
                        <label class="relative flex cursor-pointer items-center justify-between gap-3 rounded-xl border border-slate-200 bg-slate-50 p-4 hover:bg-slate-100 transition">
                            <span class="text-xs font-semibold text-slate-700">Dalam Negeri</span>
                            <input type="radio" name="scholarship_scope" value="domestic" required @checked($scholarshipScopeValue === 'domestic') class="text-blue-600 focus:ring-0 focus:ring-offset-0 bg-white border-slate-300">
                        </label>

                        <label class="relative flex cursor-pointer items-center justify-between gap-3 rounded-xl border border-slate-200 bg-slate-50 p-4 hover:bg-slate-100 transition">
                            <span class="text-xs font-semibold text-slate-700">Luar Negeri</span>
                            <input type="radio" name="scholarship_scope" value="abroad" required @checked($scholarshipScopeValue === 'abroad') class="text-blue-600 focus:ring-0 focus:ring-offset-0 bg-white border-slate-300">
                        </label>

                        <label class="relative flex cursor-pointer items-center justify-between gap-3 rounded-xl border border-slate-200 bg-slate-50 p-4 hover:bg-slate-100 transition">
                            <span class="text-xs font-semibold text-slate-700">Keduanya</span>
                            <input type="radio" name="scholarship_scope" value="both" required @checked($scholarshipScopeValue === 'both') class="text-blue-600 focus:ring-0 focus:ring-offset-0 bg-white border-slate-300">
                        </label>
                    </div>

                    <div class="space-y-1.5">
                        <label class="text-xs font-semibold text-slate-600">Negara Tujuan Spesifik (Opsional)</label>
                        <input
                            type="text"
                            name="target_countries"
                            value="{{ $oldTargetCountries }}"
                            placeholder="Contoh: Indonesia, Malaysia, Jepang"
                            class="w-full rounded-xl bg-white border border-slate-300 focus:border-blue-500 focus:ring-1 focus:ring-blue-500/30 text-slate-800 placeholder-slate-400 px-4 py-2.5 text-sm focus:outline-none transition duration-200"
                        >
                        <p class="text-[10px] text-slate-400 font-medium">Pisahkan nama negara dengan koma jika lebih dari satu.</p>
                    </div>
                </div>
            </section>

            <!-- KONDISI TAMBAHAN -->
            <section class="glass-card rounded-3xl p-6 sm:p-8 space-y-6 shadow-sm">
                <div class="space-y-1">
                    <h3 class="text-lg font-bold text-slate-800 flex items-center gap-2">
                        <span class="w-1.5 h-6 bg-blue-600 rounded"></span>
                        Parameter Tambahan
                    </h3>
                    <p class="text-xs text-slate-500">Untuk mengecualikan / memasukkan kriteria beasiswa bersyarat.</p>
                </div>

                <div class="grid gap-6 sm:grid-cols-2">
                    <!-- Active holder -->
                    <div class="space-y-3">
                        <label class="text-xs font-semibold text-slate-600 block">Apakah Anda sedang aktif menerima beasiswa lain?</label>
                        <div class="space-y-2">
                            <label class="relative flex cursor-pointer items-center justify-between gap-3 rounded-xl border border-slate-200 bg-slate-50 p-4 hover:bg-slate-100 transition">
                                <span class="text-xs font-semibold text-slate-700">Iya, Sedang Menerima</span>
                                <input type="radio" name="has_active_scholarship" value="1" required @checked((string) $hasActiveScholarshipValue === '1') class="text-blue-600 focus:ring-0 focus:ring-offset-0 bg-white border-slate-300">
                            </label>

                            <label class="relative flex cursor-pointer items-center justify-between gap-3 rounded-xl border border-slate-200 bg-slate-50 p-4 hover:bg-slate-100 transition">
                                <span class="text-xs font-semibold text-slate-700">Tidak Ada</span>
                                <input type="radio" name="has_active_scholarship" value="0" required @checked((string) $hasActiveScholarshipValue === '0') class="text-blue-600 focus:ring-0 focus:ring-offset-0 bg-white border-slate-300">
                            </label>
                        </div>
                    </div>

                    <!-- Low Income -->
                    <div class="space-y-3">
                        <label class="text-xs font-semibold text-slate-600 block">Apakah berasal dari keluarga prasejahtera (ekonomi rendah)?</label>
                        <div class="space-y-2">
                            <label class="relative flex cursor-pointer items-center justify-between gap-3 rounded-xl border border-slate-200 bg-slate-50 p-4 hover:bg-slate-100 transition">
                                <span class="text-xs font-semibold text-slate-700">Iya</span>
                                <input type="radio" name="is_low_income" value="1" required @checked((string) $isLowIncomeValue === '1') class="text-blue-600 focus:ring-0 focus:ring-offset-0 bg-white border-slate-300">
                            </label>

                            <label class="relative flex cursor-pointer items-center justify-between gap-3 rounded-xl border border-slate-200 bg-slate-50 p-4 hover:bg-slate-100 transition">
                                <span class="text-xs font-semibold text-slate-700">Tidak</span>
                                <input type="radio" name="is_low_income" value="0" required @checked((string) $isLowIncomeValue === '0') class="text-blue-600 focus:ring-0 focus:ring-offset-0 bg-white border-slate-300">
                            </label>
                        </div>
                    </div>
                </div>
            </section>

            <!-- STICKY BOTTOM FORM FOOTER -->
            <div class="fixed bottom-0 left-0 right-0 z-40 bg-white/90 backdrop-blur-lg border-t border-slate-200 py-4 shadow-2xl">
                <div class="max-w-4xl mx-auto px-4 flex justify-end gap-3">
                    <a href="{{ route('user.dashboard') }}" class="px-5 py-2.5 rounded-xl border border-slate-300 hover:border-slate-400 bg-white hover:bg-slate-100 text-xs font-semibold text-slate-600 transition duration-150">
                        Batal
                    </a>

                    <button type="submit" class="px-6 py-2.5 bg-gradient-to-r from-blue-700 to-indigo-700 hover:from-blue-800 hover:to-indigo-800 text-white rounded-xl text-xs font-bold transition duration-150 shadow-md shadow-blue-500/10 hover:scale-[1.02]">
                        Simpan Profil & Cari Beasiswa
                    </button>
                </div>
            </div>

        </form>
    </main>

    <!-- FOOTER -->
    <footer class="border-t border-slate-200 bg-white py-8 text-center text-xs text-slate-500 mt-20 relative z-10">
        <div class="max-w-7xl mx-auto px-4 space-y-2">
            <p class="font-semibold text-slate-600">BeasisMatch &copy; {{ date('Y') }}</p>
            <p>Sistem Rekomendasi Beasiswa Cerdas berbasis Laravel, Filament, & Livewire.</p>
        </div>
    </footer>

    <!-- DYNAMIC PROVINCE CITY SELECTOR SCRIPT -->
    <script>
        const provinceCityData = {
            'DKI Jakarta': [
                'Jakarta Pusat',
                'Jakarta Utara',
                'Jakarta Barat',
                'Jakarta Selatan',
                'Jakarta Timur',
                'Kepulauan Seribu',
            ],
            'Jawa Barat': [
                'Bandung',
                'Bekasi',
                'Bogor',
                'Cimahi',
                'Cirebon',
                'Depok',
                'Sukabumi',
                'Tasikmalaya',
                'Banjar',
                'Kabupaten Bandung',
                'Kabupaten Bandung Barat',
                'Kabupaten Bekasi',
                'Kabupaten Bogor',
                'Kabupaten Ciamis',
                'Kabupaten Cianjur',
                'Kabupaten Cirebon',
                'Kabupaten Garut',
                'Kabupaten Indramayu',
                'Kabupaten Karawang',
                'Kabupaten Kuningan',
                'Kabupaten Majalengka',
                'Kabupaten Pangandaran',
                'Kabupaten Purwakarta',
                'Kabupaten Subang',
                'Kabupaten Sukabumi',
                'Kabupaten Sumedang',
                'Kabupaten Tasikmalaya',
            ],
            'Banten': [
                'Cilegon',
                'Serang',
                'Tangerang',
                'Tangerang Selatan',
                'Kabupaten Lebak',
                'Kabupaten Pandeglang',
                'Kabupaten Serang',
                'Kabupaten Tangerang',
            ],
            'Jawa Tengah': [
                'Semarang',
                'Surakarta',
                'Magelang',
                'Pekalongan',
                'Salatiga',
                'Tegal',
                'Kabupaten Banyumas',
                'Kabupaten Cilacap',
                'Kabupaten Demak',
                'Kabupaten Jepara',
                'Kabupaten Klaten',
                'Kabupaten Kudus',
                'Kabupaten Magelang',
                'Kabupaten Pati',
                'Kabupaten Semarang',
                'Kabupaten Sukoharjo',
            ],
            'DI Yogyakarta': [
                'Yogyakarta',
                'Kabupaten Bantul',
                'Kabupaten Gunungkidul',
                'Kabupaten Kulon Progo',
                'Kabupaten Sleman',
            ],
            'Jawa Timur': [
                'Surabaya',
                'Malang',
                'Kediri',
                'Madiun',
                'Mojokerto',
                'Pasuruan',
                'Probolinggo',
                'Batu',
                'Kabupaten Banyuwangi',
                'Kabupaten Gresik',
                'Kabupaten Jember',
                'Kabupaten Kediri',
                'Kabupaten Malang',
                'Kabupaten Sidoarjo',
            ],
            'Bali': [
                'Denpasar',
                'Kabupaten Badung',
                'Kabupaten Bangli',
                'Kabupaten Buleleng',
                'Kabupaten Gianyar',
                'Kabupaten Jembrana',
                'Kabupaten Karangasem',
                'Kabupaten Klungkung',
                'Kabupaten Tabanan',
            ],
            'Sumatera Utara': [
                'Medan',
                'Binjai',
                'Pematangsiantar',
                'Tebing Tinggi',
                'Kabupaten Deli Serdang',
                'Kabupaten Karo',
                'Kabupaten Langkat',
                'Kabupaten Simalungun',
            ],
            'Sumatera Barat': [
                'Padang',
                'Bukittinggi',
                'Payakumbuh',
                'Solok',
                'Kabupaten Agam',
                'Kabupaten Lima Puluh Kota',
                'Kabupaten Padang Pariaman',
                'Kabupaten Tanah Datar',
            ],
            'Riau': [
                'Pekanbaru',
                'Dumai',
                'Kabupaten Bengkalis',
                'Kabupaten Kampar',
                'Kabupaten Rokan Hilir',
                'Kabupaten Rokan Hulu',
                'Kabupaten Siak',
            ],
            'Lampung': [
                'Bandar Lampung',
                'Metro',
                'Kabupaten Lampung Selatan',
                'Kabupaten Lampung Tengah',
                'Kabupaten Lampung Timur',
                'Kabupaten Lampung Utara',
                'Kabupaten Pesawaran',
            ],
            'Sulawesi Selatan': [
                'Makassar',
                'Parepare',
                'Palopo',
                'Kabupaten Gowa',
                'Kabupaten Maros',
                'Kabupaten Bone',
                'Kabupaten Bulukumba',
                'Kabupaten Wajo',
            ],
            'Kalimantan Timur': [
                'Balikpapan',
                'Samarinda',
                'Bontang',
                'Kabupaten Kutai Kartanegara',
                'Kabupaten Kutai Timur',
                'Kabupaten Berau',
                'Kabupaten Paser',
            ],
        };

        const selectedProvince = @json(old('province', $profile?->province));
        const selectedCity = @json(old('city', $profile?->city));

        const provinceSelect = document.getElementById('provinceSelect');
        const citySelect = document.getElementById('citySelect');

        function loadProvinces() {
            Object.keys(provinceCityData).forEach((province) => {
                const option = document.createElement('option');
                option.value = province;
                option.textContent = province;

                if (province === selectedProvince) {
                    option.selected = true;
                }

                provinceSelect.appendChild(option);
            });
        }

        function loadCities(province, selected = null) {
            citySelect.innerHTML = '<option value="">Pilih kota/kabupaten kamu</option>';

            if (!province || !provinceCityData[province]) {
                return;
            }

            provinceCityData[province].forEach((city) => {
                const option = document.createElement('option');
                option.value = city;
                option.textContent = city;

                if (city === selected) {
                    option.selected = true;
                }

                citySelect.appendChild(option);
            });
        }

        provinceSelect.addEventListener('change', function () {
            loadCities(this.value);
        });

        loadProvinces();
        loadCities(selectedProvince, selectedCity);
    </script>
</body>
</html>