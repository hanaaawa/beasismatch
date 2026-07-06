<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - BeasisMatch</title>
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
        .glow-effect-hover:hover {
            box-shadow: 0 0 30px rgba(30, 64, 175, 0.15);
            border-color: rgba(30, 64, 175, 0.3);
            transform: translateY(-2px);
        }
    </style>
    <!-- Alpine.js CDN -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>

<body class="bg-slate-50 text-slate-800 font-sans min-h-screen selection:bg-blue-200 selection:text-blue-900 overflow-x-hidden">

    <!-- DECORATIVE BACKGROUND GLOW -->
    <div class="absolute top-0 left-1/4 w-96 h-96 bg-blue-200/30 rounded-full blur-[100px] pointer-events-none"></div>
    <div class="absolute top-1/3 right-1/4 w-[400px] h-[400px] bg-indigo-200/30 rounded-full blur-[120px] pointer-events-none"></div>

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
                   class="px-3 py-2 rounded-xl text-sm font-semibold text-blue-700 bg-blue-50 border border-blue-200 transition duration-200">
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

    <!-- MAIN CONTENT -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 relative z-10 space-y-10">

        @if (session('error'))
            <div class="rounded-2xl bg-red-50 border border-red-200 p-4 text-red-800 text-sm flex items-start gap-3 shadow-sm">
                <span class="text-lg">🚫</span>
                <div>
                    <p class="font-bold">Akses Ditolak</p>
                    <p class="text-xs text-red-700 leading-relaxed">{{ session('error') }}</p>
                </div>
            </div>
        @endif

        @if (session('success'))
            <div class="rounded-2xl bg-emerald-50 border border-emerald-200 p-4 text-emerald-800 text-sm flex items-start gap-3 shadow-sm">
                <span class="text-lg">✅</span>
                <div>
                    <p class="font-bold">Berhasil</p>
                    <p class="text-xs text-emerald-700 leading-relaxed">{{ session('success') }}</p>
                </div>
            </div>
        @endif

        <!-- WELCOME BANNER -->
        <section class="relative overflow-hidden rounded-3xl bg-gradient-to-r from-blue-50 to-indigo-50 border border-blue-200 p-8 sm:p-10 shadow-md glow-effect">
            <div class="absolute right-0 top-0 w-1/3 h-full opacity-10 pointer-events-none">
                <svg class="w-full h-full text-blue-700" viewBox="0 0 100 100" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <circle cx="50" cy="50" r="40" stroke="currentColor" stroke-width="0.5" stroke-dasharray="2 2" />
                    <circle cx="50" cy="50" r="30" stroke="currentColor" stroke-width="0.5" />
                    <line x1="50" y1="10" x2="50" y2="90" stroke="currentColor" stroke-width="0.5" />
                    <line x1="10" y1="50" x2="90" y2="50" stroke="currentColor" stroke-width="0.5" />
                </svg>
            </div>

            <div class="max-w-2xl space-y-4">
                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-blue-100 text-blue-700 border border-blue-200">
                    <span class="w-1.5 h-1.5 rounded-full bg-blue-600 animate-pulse"></span>
                    Sistem Aktif
                </span>
                <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-800">
                    Halo, {{ auth()->user()->name }}! 👋
                </h2>
                <p class="text-sm sm:text-base text-slate-600 leading-relaxed">
                    Selamat datang kembali di BeasisMatch. Sistem kami mencocokkan profil akademik Anda secara real-time dengan puluhan database beasiswa aktif untuk menemukan opsi pendanaan terbaik.
                </p>
            </div>
        </section>

        <!-- PROFILE STATUS & OVERVIEW -->
        <section class="grid lg:grid-cols-3 gap-6">
            
            <!-- ACADEMIC PROFILE STATUS CARD -->
            <div class="glass-card rounded-3xl p-6 lg:col-span-2 flex flex-col justify-between space-y-6 shadow-sm">
                <div>
                    <div class="flex justify-between items-center">
                        <h3 class="text-lg font-bold text-slate-800 flex items-center gap-2">
                            <!-- Icon Academic -->
                            <svg class="w-5 h-5 text-blue-700" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14v7"></path>
                            </svg>
                            Kondisi Profil Akademik
                        </h3>
                        <a href="{{ route('user.profile.edit') }}" class="text-xs text-blue-700 hover:text-blue-800 hover:underline font-semibold">
                            Ubah Profil
                        </a>
                    </div>

                    @if (!$profile)
                        <div class="mt-6 p-5 rounded-2xl bg-amber-50 border border-amber-200 text-amber-800 text-sm flex items-start gap-3">
                            <span class="text-xl">⚠</span>
                            <div class="space-y-2">
                                <p class="font-bold">Profil Pencarian Belum Lengkap</p>
                                <p class="text-xs text-amber-700 leading-relaxed">
                                    Silakan lengkapi profil akademik Anda untuk mengaktifkan filter matching engine beasiswa. Tanpa profil lengkap, hasil rekomendasi mungkin kurang akurat.
                                </p>
                                <a href="{{ route('user.profile.edit') }}" class="inline-flex items-center gap-1 mt-2 text-xs font-bold text-white bg-amber-600 hover:bg-amber-700 px-3 py-1.5 rounded-lg transition duration-150">
                                    Lengkapi Sekarang
                                </a>
                            </div>
                        </div>
                    @else
                        <div class="grid sm:grid-cols-2 md:grid-cols-4 gap-4 mt-6">
                            
                            <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200">
                                <p class="text-xs text-slate-500 font-medium">Jenjang Saat Ini</p>
                                <p class="text-lg font-bold text-slate-800 mt-1">{{ $profile->education_level ?? '-' }}</p>
                            </div>

                            <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200">
                                <p class="text-xs text-slate-500 font-medium">Status Akademik</p>
                                <p class="text-lg font-bold text-slate-800 mt-1 capitalize">{{ $profile->education_status === 'active' ? 'Aktif' : ($profile->education_status === 'inactive_graduated' ? 'Lulus' : ($profile->education_status === 'gap_year' ? 'Gap Year' : ($profile->education_status ?? '-'))) }}</p>
                            </div>

                            <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200">
                                <p class="text-xs text-slate-500 font-medium">IPK Aktual</p>
                                <p class="text-lg font-bold text-blue-700 mt-1">{{ $profile->gpa ?? '-' }} <span class="text-[10px] text-slate-400">/ 4.0</span></p>
                            </div>

                            <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200">
                                <p class="text-xs text-slate-500 font-medium">Tipe Institusi</p>
                                <p class="text-lg font-bold text-slate-800 mt-1 uppercase">{{ $profile->institution_type ?? '-' }}</p>
                            </div>

                        </div>
                    @endif
                </div>

                @if ($profile)
                <div class="border-t border-slate-200 pt-4 flex flex-wrap gap-4 items-center justify-between text-xs text-slate-500">
                    <div>
                        Target Jenjang: <span class="text-slate-700 font-semibold">{{ $profile->target_education_level ?? '-' }}</span> 
                        &bull; Wilayah: <span class="text-slate-700 font-semibold uppercase">{{ $profile->scholarship_scope === 'domestic' ? 'Dalam Negeri' : ($profile->scholarship_scope === 'abroad' ? 'Luar Negeri' : 'Semua') }}</span>
                    </div>
                    <div class="flex items-center gap-2">
                        @if ($profile->is_low_income)
                            <span class="px-2 py-0.5 rounded bg-emerald-50 text-emerald-700 border border-emerald-200 font-bold uppercase tracking-wider text-[9px]">Keluarga Prasejahtera</span>
                        @endif
                        @if ($profile->has_active_scholarship)
                            <span class="px-2 py-0.5 rounded bg-yellow-50 text-yellow-700 border border-yellow-200 font-bold uppercase tracking-wider text-[9px]">Penerima Beasiswa Aktif</span>
                        @endif
                    </div>
                </div>
                @endif
            </div>

            <!-- QUICK SUMMARY STATS -->
            <div class="glass-card rounded-3xl p-6 flex flex-col justify-between space-y-6 shadow-sm">
                <div>
                    <h3 class="text-lg font-bold text-slate-800 flex items-center gap-2">
                        <!-- Icon Stat -->
                        <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                        Ringkasan Sistem
                    </h3>

                    <div class="mt-6 flex items-center gap-4">
                        <div class="w-14 h-14 rounded-2xl bg-blue-50 border border-blue-200 flex items-center justify-center font-bold text-2xl text-blue-700 shadow-sm">
                            {{ $recommendations->count() }}
                        </div>
                        <div>
                            <p class="text-sm font-semibold text-slate-700">Rekomendasi Ditemukan</p>
                            <p class="text-xs text-slate-500">Beasiswa aktif yang cocok dengan parameter profil Anda.</p>
                        </div>
                    </div>
                </div>

                <div class="space-y-2">
                    <p class="text-xs text-slate-500 font-semibold uppercase tracking-wider">Aksi Cepat</p>
                    <div class="grid grid-cols-1 gap-2">
                        <a href="{{ route('user.scholarships.index') }}" class="p-2 text-center text-xs font-semibold bg-blue-700 hover:bg-blue-800 text-white rounded-xl transition duration-150">
                            Lihat Semua Beasiswa
                        </a>
                    </div>
                </div>
            </div>

        </section>

        <!-- RECOMMENDATIONS SECTION -->
        <section class="space-y-6">
            <div class="flex justify-between items-center">
                <div>
                    <h3 class="text-xl font-bold text-slate-800">Rekomendasi Beasiswa Khusus Untukmu</h3>
                    <p class="text-xs text-slate-500 mt-1">Algoritma kami telah memilah pilihan beasiswa terbaik yang cocok untuk profil Anda.</p>
                </div>
                <div class="text-xs text-slate-500">
                    Total: <span class="text-blue-700 font-bold">{{ $recommendations->count() }} Pilihan</span>
                </div>
            </div>

            @if ($recommendations->isEmpty())
                <div class="glass-card rounded-3xl p-12 text-center border-dashed border-slate-300 max-w-xl mx-auto space-y-4 shadow-sm">
                    <div class="w-16 h-16 rounded-full bg-slate-100 flex items-center justify-center mx-auto text-2xl">
                        🔍
                    </div>
                    <h4 class="text-lg font-bold text-slate-700">Belum Ada Beasiswa yang Cocok</h4>
                    <p class="text-sm text-slate-500 leading-relaxed">
                        Kami tidak menemukan beasiswa yang sesuai dengan kriteria profil Anda saat ini. Coba sesuaikan data IPK atau target jenjang pendidikan Anda di halaman profil.
                    </p>
                    <a href="{{ route('user.profile.edit') }}" class="inline-flex items-center gap-2 bg-blue-700 hover:bg-blue-800 text-white px-5 py-2.5 rounded-xl text-sm font-semibold transition duration-200">
                        Sesuaikan Profil Pencarian
                    </a>
                </div>
            @else
                <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">

                    @foreach ($recommendations as $scholarship)
                        @php
                            // Dynamic Match Score simulation for aesthetics
                            $matchPercentage = 80;
                            if ($profile) {
                                if ($scholarship->minimum_gpa && $profile->gpa) {
                                    $diff = (float)$profile->gpa - (float)$scholarship->minimum_gpa;
                                    if ($diff >= 0.5) $matchPercentage = 98;
                                    elseif ($diff >= 0) $matchPercentage = 90;
                                    else $matchPercentage = 75;
                                }
                            }
                        @endphp
                        
                        <div class="glass-card rounded-3xl p-6 flex flex-col justify-between hover:shadow-xl transition duration-300 group glow-effect-hover shadow-sm">
                            
                            <div class="space-y-4">
                                <!-- CARD TOP: Provider & Match Badge -->
                                <div class="flex justify-between items-start gap-2">
                                    <div class="space-y-1">
                                        <p class="text-xs text-blue-700 font-semibold uppercase tracking-wider">{{ $scholarship->provider }}</p>
                                    </div>
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-extrabold bg-blue-50 text-blue-700 border border-blue-200 uppercase">
                                        {{ $matchPercentage }}% Match
                                    </span>
                                </div>

                                <!-- CARD TITLE -->
                                <h4 class="text-lg font-bold text-slate-800 group-hover:text-blue-700 transition-colors line-clamp-2">
                                    {{ $scholarship->name }}
                                </h4>

                                <!-- CARD METADATA BADGES -->
                                <div class="flex flex-wrap gap-2 pt-1">
                                    @if($scholarship->minimum_gpa)
                                        <span class="px-2 py-0.5 rounded-lg bg-slate-100 border border-slate-200 text-[10px] text-slate-600 font-medium">
                                            Min. IPK: {{ $scholarship->minimum_gpa }}
                                        </span>
                                    @endif
                                    @if($scholarship->scholarship_scope)
                                        <span class="px-2 py-0.5 rounded-lg bg-slate-100 border border-slate-200 text-[10px] text-slate-600 font-medium uppercase">
                                            {{ $scholarship->scholarship_scope === 'domestic' ? 'Dalam Negeri' : ($scholarship->scholarship_scope === 'abroad' ? 'Luar Negeri' : 'Nasional/Global') }}
                                        </span>
                                    @endif
                                    @if($scholarship->funding_label)
                                        <span class="px-2 py-0.5 rounded-lg bg-indigo-50 border border-indigo-200 text-[10px] text-indigo-700 font-semibold">
                                            {{ $scholarship->funding_label }}
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <!-- CARD BOTTOM: Deadline & Details Button -->
                            <div class="mt-6 pt-4 border-t border-slate-200 flex items-center justify-between">
                                <div class="text-xs">
                                    <p class="text-slate-400">Batas Pendaftaran</p>
                                    <p class="font-bold text-slate-600 mt-0.5 flex items-center gap-1">
                                        <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                        {{ $scholarship->registration_deadline ? $scholarship->registration_deadline->format('d M Y') : 'Tanpa Batas' }}
                                    </p>
                                </div>

                                <a href="{{ route('user.scholarships.show', $scholarship) }}"
                                   class="px-4 py-2 bg-gradient-to-r from-blue-700 to-indigo-700 hover:from-blue-800 hover:to-indigo-800 text-white rounded-xl text-xs font-bold transition duration-150 flex items-center gap-1 shadow-md shadow-blue-500/10">
                                    Lihat Detail
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                    </svg>
                                </a>
                            </div>

                        </div>
                    @endforeach

                </div>
            @endif
        </section>

    </main>

    <!-- FOOTER -->
    <footer class="border-t border-slate-200 bg-white py-8 text-center text-xs text-slate-500 mt-20 relative z-10">
        <div class="max-w-7xl mx-auto px-4 space-y-2">
            <p class="font-semibold text-slate-600">BeasisMatch &copy; {{ date('Y') }}</p>
            <p>Sistem Rekomendasi Beasiswa Cerdas berbasis Laravel, Filament, & Livewire.</p>
        </div>
    </footer>

</body>
</html>