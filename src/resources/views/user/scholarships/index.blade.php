<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kalender Beasiswa - BeasisMatch</title>
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
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 space-y-8">
        
        <!-- CALENDAR CONFIG SECTION -->
        <section class="glass-card rounded-3xl p-8 shadow-md glow-effect">
            <div class="flex flex-col gap-6 md:flex-row md:items-end md:justify-between">
                <div class="space-y-2">
                    <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-semibold bg-indigo-50 text-indigo-700 border border-indigo-200 uppercase">
                        📅 Kalender Beasiswa {{ $selectedYear }}
                    </span>
                    <h2 class="text-3xl font-extrabold text-slate-800">
                        Bulan {{ $selectedMonthName }}
                    </h2>
                    <p class="text-sm text-slate-500 max-w-xl">
                        Berikut beasiswa pendaftaran aktif yang sedang buka di bulan ini dan terintegrasi secara otomatis dengan parameter kriteria akademik profil Anda.
                    </p>
                </div>

                <form method="GET" action="{{ route('user.scholarships.index') }}" class="flex items-center gap-2">
                    <label class="text-xs font-semibold text-slate-600">Ganti Tahun</label>
                    <input
                        type="number"
                        name="year"
                        value="{{ $selectedYear }}"
                        class="w-24 rounded-xl bg-white border border-slate-300 focus:border-blue-500 focus:ring-1 focus:ring-blue-500/30 text-slate-800 px-3 py-2 text-sm focus:outline-none transition duration-200"
                    >
                    <input type="hidden" name="month" value="{{ $selectedMonth }}">
                    <button class="rounded-xl bg-blue-700 hover:bg-blue-800 px-4 py-2 text-xs font-bold text-white shadow transition duration-150">
                        Terapkan
                    </button>
                </form>
            </div>

            <!-- MONTH GRID SELECTOR -->
            <div class="mt-8 grid grid-cols-4 sm:grid-cols-6 lg:grid-cols-12 gap-2 border-t border-slate-200 pt-6">
                @foreach ($months as $monthNumber => $monthName)
                    <a
                        href="{{ route('user.scholarships.index', ['month' => $monthNumber, 'year' => $selectedYear]) }}"
                        class="rounded-xl border px-2 py-3 text-center text-xs font-bold transition duration-150
                            {{ $selectedMonth === $monthNumber
                                ? 'border-blue-600 bg-gradient-to-r from-blue-700 to-indigo-700 text-white shadow shadow-blue-500/10'
                                : 'border-slate-200 bg-slate-50 text-slate-500 hover:text-slate-800 hover:bg-slate-100' }}"
                    >
                        {{ $monthName }}
                    </a>
                @endforeach
            </div>
        </section>

        <!-- PROFILE INCOMPLETE WARNING -->
        @if (! $profile)
            <div class="p-6 rounded-3xl bg-amber-50 border border-amber-200 text-amber-800 text-sm flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <div class="flex items-start gap-3">
                    <span class="text-2xl leading-none">⚠</span>
                    <div>
                        <p class="font-bold">Profil Pencarian Akademik Belum Lengkap</p>
                        <p class="text-xs text-amber-700 leading-relaxed">
                            Beasiswa aktif tetap ditampilkan secara umum. Daftarkan dan lengkapi data profil agar sistem dapat melakukan filter validasi eligibilitas.
                        </p>
                    </div>
                </div>
                <a href="{{ route('user.profile.edit') }}" class="inline-flex shrink-0 items-center justify-center bg-amber-600 hover:bg-amber-700 text-white text-xs font-bold px-4 py-2.5 rounded-xl transition duration-150">
                    Lengkapi Profil
                </a>
            </div>
        @endif

        <!-- SCHOLARSHIP CONTAINER LIST -->
        @if ($scholarships->isEmpty())
            <section class="glass-card rounded-3xl p-16 text-center border-dashed border-slate-300 max-w-xl mx-auto space-y-4 shadow-sm">
                <div class="w-16 h-16 rounded-full bg-slate-100 flex items-center justify-center mx-auto text-2xl">
                    📅
                </div>
                <h3 class="text-lg font-bold text-slate-700">Tidak Ada Pendaftaran Beasiswa</h3>
                <p class="text-sm text-slate-500 leading-relaxed">
                    Belum ditemukan beasiswa yang membuka registrasi pendaftaran pada bulan {{ $selectedMonthName }} {{ $selectedYear }}. Coba pilih bulan registrasi lain atau sesuaikan parameter pencarian profil Anda.
                </p>
            </section>
        @else
            <section class="grid gap-6 md:grid-cols-2">
                @foreach ($scholarships as $scholarship)
                    <article class="glass-card rounded-3xl p-6 flex flex-col justify-between hover:shadow-xl transition duration-300 group glow-effect-hover shadow-sm">
                        
                        <div>
                            <!-- Header tag bar -->
                            <div class="flex flex-wrap gap-1.5">
                                @foreach (($scholarship->eligible_levels ?? []) as $level)
                                    <span class="rounded-lg bg-blue-50 border border-blue-200 px-2 py-0.5 text-[10px] font-bold text-blue-700 uppercase">
                                        {{ $level }}
                                    </span>
                                @endforeach

                                @if ($scholarship->requires_low_income)
                                    <span class="rounded-lg bg-emerald-50 border border-emerald-200 px-2 py-0.5 text-[10px] font-bold text-emerald-700 uppercase">
                                        Prasejahtera
                                    </span>
                                @endif

                                @if ($scholarship->minimum_gpa)
                                    <span class="rounded-lg bg-amber-50 border border-amber-200 px-2 py-0.5 text-[10px] font-bold text-amber-700 uppercase">
                                        Min. IPK {{ $scholarship->minimum_gpa }}
                                    </span>
                                @endif
                            </div>

                            <!-- Title -->
                            <h3 class="mt-4 text-xl font-bold text-slate-800 group-hover:text-blue-700 transition-colors line-clamp-2">
                                {{ $scholarship->name }}
                            </h3>

                            <!-- Subtitle provider -->
                            <p class="mt-1.5 text-xs text-slate-500 flex items-center gap-1.5">
                                <span class="font-semibold text-slate-700">{{ $scholarship->provider }}</span>
                                @if ($scholarship->country)
                                    <span class="text-slate-300">&bull;</span>
                                    <span>{{ $scholarship->country }}</span>
                                @endif
                            </p>

                            <!-- Description -->
                            @if ($scholarship->description)
                                <p class="mt-4 text-xs text-slate-500 leading-relaxed line-clamp-3">
                                    {{ $scholarship->description }}
                                </p>
                            @endif
                        </div>

                        <!-- Metadata Grid Table inside card -->
                        <div class="mt-5 space-y-4 pt-4 border-t border-slate-200">
                            <div class="grid grid-cols-2 gap-4 text-xs">
                                <div>
                                    <p class="text-slate-400 font-medium">Registrasi Mulai</p>
                                    <p class="font-bold text-slate-600 mt-0.5">
                                        {{ $scholarship->registration_start?->format('d M Y') ?? '-' }}
                                    </p>
                                </div>

                                <div>
                                    <p class="text-slate-400 font-medium">Batas Deadline</p>
                                    <p class="font-bold text-red-600 mt-0.5">
                                        {{ $scholarship->registration_deadline?->format('d M Y') ?? '-' }}
                                    </p>
                                </div>

                                <div>
                                    <p class="text-slate-400 font-medium">Kategori Kampus</p>
                                    <p class="font-bold text-slate-600 mt-0.5">
                                        {{ match ($scholarship->allowed_institution_type) {
                                            'PTN' => 'PTN Only',
                                            'PTS' => 'PTS Only',
                                            'school' => 'Khusus Sekolah',
                                            'all' => 'PTN & PTS',
                                            'not_applicable' => 'Umum',
                                            default => '-',
                                        } }}
                                    </p>
                                </div>

                                <div>
                                    <p class="text-slate-400 font-medium">Pendanaan</p>
                                    <p class="font-bold text-indigo-700 mt-0.5">
                                        {{ $scholarship->funding_label ?: '-' }}
                                    </p>
                                </div>
                            </div>

                            <div class="flex items-center justify-between pt-1">
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-lg text-[10px] font-bold bg-emerald-50 text-emerald-700 border border-emerald-200 uppercase tracking-wide">
                                    <span class="w-1 h-1 rounded-full bg-emerald-500 animate-pulse"></span>
                                    Pendaftaran Buka
                                </span>

                                <a
                                    href="{{ route('user.scholarships.show', $scholarship) }}"
                                    class="px-4 py-2.5 bg-gradient-to-r from-blue-700 to-indigo-700 hover:from-blue-800 hover:to-indigo-800 text-white rounded-xl text-xs font-bold transition duration-150 flex items-center gap-1 shadow-md shadow-blue-500/10"
                                >
                                    Lihat Detail
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                    </svg>
                                </a>
                            </div>
                        </div>

                    </article>
                @endforeach
            </section>
        @endif
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