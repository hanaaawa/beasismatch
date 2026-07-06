<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $scholarship->name }} - BeasisMatch</title>
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
    <main class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-10 space-y-6">
        
        <!-- TITLE BANNER -->
        <section class="glass-card rounded-3xl p-8 shadow-md glow-effect">
            <div class="flex flex-col gap-6 md:flex-row md:items-start md:justify-between">
                <div class="space-y-4">
                    <div class="flex flex-wrap gap-2">
                        @foreach (($scholarship->eligible_levels ?? []) as $level)
                            <span class="rounded-lg bg-blue-50 border border-blue-200 px-2.5 py-0.5 text-xs font-bold text-blue-700 uppercase">
                                {{ $level }}
                            </span>
                        @endforeach

                        <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-lg text-xs font-bold bg-emerald-50 text-emerald-700 border border-emerald-200 uppercase tracking-wide">
                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                            Pendaftaran Buka
                        </span>
                    </div>

                    <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-800 leading-tight">
                        {{ $scholarship->name }}
                    </h2>

                    <p class="text-sm text-slate-500 flex items-center gap-2">
                        <span class="font-semibold text-slate-700">{{ $scholarship->provider }}</span>
                        @if ($scholarship->country)
                            <span class="text-slate-300">&bull;</span>
                            <span>{{ $scholarship->country }}</span>
                        @endif
                    </p>
                </div>

                <div class="flex items-center gap-2 shrink-0 pt-2 md:pt-0">
                    <button type="button" class="px-4 py-2.5 rounded-xl border border-slate-300 hover:border-slate-400 text-xs font-semibold bg-white hover:bg-slate-100 transition duration-150 flex items-center gap-1.5 text-slate-600 hover:text-slate-900">
                        <span>♡</span> Bookmark
                    </button>

                    <button
                        type="button"
                        onclick="navigator.clipboard.writeText(window.location.href); alert('Link beasiswa berhasil disalin ke clipboard!');"
                        class="px-4 py-2.5 rounded-xl border border-slate-300 hover:border-slate-400 text-xs font-semibold bg-white hover:bg-slate-100 transition duration-150 flex items-center gap-1.5 text-slate-600 hover:text-slate-900"
                    >
                        <!-- Copy icon SVG -->
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-1M8 5a2 2 0 002 2h2a2 2 0 002-2M8 5a2 2 0 012-2h2a2 2 0 012 2m0 0h2a2 2 0 012 2v3m2 4H10m0 0l3-3m-3 3l3 3"></path>
                        </svg>
                        Salin Link
                    </button>
                </div>
            </div>
        </section>

        <!-- PARAMETERS GRID -->
        <section class="grid gap-4 sm:grid-cols-2 md:grid-cols-3">
            
            <div class="glass-card rounded-2xl p-5 shadow-sm">
                <p class="text-xs text-slate-400 font-medium uppercase tracking-wider">Jenjang Sasaran</p>
                <p class="mt-1 text-sm font-bold text-slate-800 leading-relaxed">
                    {{ implode(', ', $scholarship->eligible_levels ?? []) ?: '-' }}
                </p>
            </div>

            <div class="glass-card rounded-2xl p-5 shadow-sm">
                <p class="text-xs text-slate-400 font-medium uppercase tracking-wider">Penyelenggara</p>
                <p class="mt-1 text-sm font-bold text-slate-800 leading-relaxed line-clamp-2">
                    {{ $scholarship->provider }}
                </p>
            </div>

            <div class="glass-card rounded-2xl p-5 shadow-sm">
                <p class="text-xs text-slate-400 font-medium uppercase tracking-wider">Registrasi Buka</p>
                <p class="mt-1 text-sm font-bold text-slate-700">
                    {{ $scholarship->registration_start?->format('d M Y') ?? '-' }}
                </p>
            </div>

            <div class="glass-card rounded-2xl p-5 shadow-sm">
                <p class="text-xs text-slate-400 font-medium uppercase tracking-wider">Registrasi Tutup</p>
                <p class="mt-1 text-sm font-bold text-red-600">
                    {{ $scholarship->registration_deadline?->format('d M Y') ?? '-' }}
                </p>
            </div>

            <div class="glass-card rounded-2xl p-5 shadow-sm">
                <p class="text-xs text-slate-400 font-medium uppercase tracking-wider">Tipe Kampus</p>
                <p class="mt-1 text-sm font-bold text-slate-800 uppercase">
                    {{ match ($scholarship->allowed_institution_type) {
                        'PTN' => 'Khusus PTN',
                        'PTS' => 'Khusus PTS',
                        'school' => 'Khusus Sekolah',
                        'all' => 'PTN & PTS',
                        'not_applicable' => 'Umum',
                        default => '-',
                    } }}
                </p>
            </div>

            <div class="glass-card rounded-2xl p-5 shadow-sm">
                <p class="text-xs text-slate-400 font-medium uppercase tracking-wider">Jenis Pendanaan</p>
                <p class="mt-1 text-sm font-bold text-indigo-700">
                    {{ $scholarship->funding_label ?: '-' }}
                </p>
            </div>

        </section>

        <!-- DETAILS TAB SECTIONS -->
        <div class="space-y-6">

            <!-- DESCRIPTION -->
            @if ($scholarship->description)
                <section class="glass-card rounded-3xl p-6 sm:p-8 space-y-4 shadow-sm">
                    <h3 class="text-lg font-bold text-slate-800 border-l-4 border-blue-600 pl-3">Deskripsi Beasiswa</h3>
                    <p class="text-sm text-slate-600 leading-relaxed whitespace-pre-line">{{ $scholarship->description }}</p>
                </section>
            @endif

            <!-- BENEFIT -->
            <section class="glass-card rounded-3xl p-6 sm:p-8 space-y-4 shadow-sm">
                <h3 class="text-lg font-bold text-slate-800 border-l-4 border-indigo-600 pl-3">Fasilitas & Benefit</h3>
                <p class="text-sm text-slate-600 leading-relaxed whitespace-pre-line">{{ $scholarship->benefit ?: 'Belum ada rincian data benefit khusus.' }}</p>
            </section>

            <!-- REQUIREMENTS -->
            <section class="glass-card rounded-3xl p-6 sm:p-8 space-y-4 shadow-sm">
                <h3 class="text-lg font-bold text-slate-800 border-l-4 border-blue-600 pl-3">Persyaratan Calon Penerima</h3>
                <p class="text-sm text-slate-600 leading-relaxed whitespace-pre-line">{{ $scholarship->requirements ?: 'Belum ada rincian data kualifikasi/persyaratan.' }}</p>
            </section>

            <!-- DOCUMENTS -->
            <section class="glass-card rounded-3xl p-6 sm:p-8 space-y-4 shadow-sm">
                <h3 class="text-lg font-bold text-slate-800 border-l-4 border-indigo-600 pl-3">Dokumen yang Dibutuhkan</h3>
                <p class="text-sm text-slate-600 leading-relaxed whitespace-pre-line">{{ $scholarship->documents ?: 'Belum ada rincian data berkas administrasi.' }}</p>
            </section>

            <!-- ELIGIBLE INSTITUTIONS -->
            @if ($scholarship->eligible_institutions)
                <section class="glass-card rounded-3xl p-6 sm:p-8 space-y-4 shadow-sm">
                    <h3 class="text-lg font-bold text-slate-800 border-l-4 border-blue-600 pl-3">Daftar Kampus/Sekolah Mitra</h3>
                    <p class="text-sm text-slate-600 leading-relaxed whitespace-pre-line">{{ $scholarship->eligible_institutions }}</p>
                </section>
            @endif

            <!-- REGISTRATION ACTION BUTTONS -->
            <section class="glass-card rounded-3xl p-8 bg-gradient-to-r from-blue-50 to-indigo-50 border border-blue-200 shadow-sm">
                <div class="flex flex-col gap-6 md:flex-row md:items-center md:justify-between">
                    <div class="space-y-1">
                        <h3 class="text-lg font-bold text-slate-800">Ajukan Pendaftaran Sekarang</h3>
                        <p class="text-xs text-slate-500">
                            Pastikan Anda mempersiapkan seluruh berkas yang disyaratkan sebelum menuju portal registrasi resmi.
                        </p>
                    </div>

                    <div class="flex flex-wrap gap-3 shrink-0">
                        @if ($scholarship->booklet_link)
                            <a
                                href="{{ $scholarship->booklet_link }}"
                                target="_blank"
                                rel="noopener"
                                class="px-5 py-3 rounded-xl border border-blue-300 text-blue-700 hover:text-blue-800 hover:bg-blue-100/50 text-xs font-bold transition duration-150 flex items-center gap-1.5"
                            >
                                <!-- Booklet icon SVG -->
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                </svg>
                                Unduh Panduan / Booklet
                            </a>
                        @endif

                        @if ($scholarship->apply_link || $scholarship->official_link)
                            <a
                                href="{{ $scholarship->apply_link ?: $scholarship->official_link }}"
                                target="_blank"
                                rel="noopener"
                                class="px-6 py-3 bg-gradient-to-r from-blue-700 to-indigo-700 hover:from-blue-800 hover:to-indigo-800 text-white rounded-xl text-xs font-bold transition duration-150 flex items-center gap-1.5 shadow-lg shadow-blue-500/20 hover:scale-[1.02]"
                            >
                                <span>Daftar Sekarang</span>
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                                </svg>
                            </a>
                        @endif
                    </div>
                </div>
            </section>

        </div>

        <!-- BACK ACTION BUTTON -->
        <div class="pt-4 flex justify-start">
            <a href="{{ route('user.scholarships.index') }}" class="px-4 py-2.5 rounded-xl border border-slate-300 hover:border-slate-400 text-xs font-semibold bg-white hover:bg-slate-100 transition duration-150 flex items-center gap-1.5 text-slate-500 hover:text-slate-800">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Kembali ke Daftar Beasiswa
            </a>
        </div>

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