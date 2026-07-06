<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $question->title }} - Forum BeasisMatch</title>
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
                   class="px-3 py-2 rounded-xl text-sm font-semibold text-blue-700 bg-blue-50 border border-blue-200 transition duration-200">
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
    <main class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-10 space-y-6 relative z-10">
        
        <a href="{{ route('user.forum.index') }}" class="inline-flex items-center gap-2 text-sm font-semibold text-blue-700 hover:text-blue-800 transition">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            Kembali ke Daftar Forum
        </a>

        @if (session('success'))
            <div class="rounded-2xl bg-emerald-50 border border-emerald-200 p-4 text-emerald-800 text-sm flex items-start gap-3 shadow-sm mt-4">
                <span class="text-lg">✅</span>
                <div>
                    <p class="font-bold">Berhasil</p>
                    <p class="text-xs text-emerald-700 leading-relaxed">{{ session('success') }}</p>
                </div>
            </div>
        @endif

        @if ($errors->any())
            <div class="rounded-2xl bg-red-50 border border-red-200 p-4 text-red-800 text-sm flex items-start gap-3 shadow-sm mt-4">
                <span class="text-lg">🚫</span>
                <div>
                    <p class="font-bold">Terjadi Kesalahan</p>
                    <ul class="list-disc pl-5 mt-1 text-xs text-red-700">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif

        <!-- ORIGINAL QUESTION -->
        <article class="glass-card rounded-3xl p-6 md:p-8 shadow-sm">
            <div class="flex items-start gap-4">
                <img src="{{ $question->user->getFilamentAvatarUrl() }}" class="w-12 h-12 rounded-full object-cover border border-slate-200 flex-shrink-0">
                <div class="w-full">
                    <div class="flex justify-between items-center w-full">
                        <div class="flex flex-col">
                            <span class="font-bold text-slate-800">{{ $question->user->name }}</span>
                            <span class="text-xs text-slate-500">{{ $question->created_at->format('d M Y, H:i') }}</span>
                        </div>
                        <span class="text-xs font-extrabold uppercase px-3 py-1 rounded-full bg-blue-50 text-blue-700 border border-blue-200">
                            {{ $question->category }}
                        </span>
                    </div>
                    <h1 class="font-extrabold text-2xl text-slate-900 mt-4 mb-3">{{ $question->title }}</h1>
                    <div class="text-slate-700 whitespace-pre-line leading-relaxed">
                        {{ $question->content }}
                    </div>
                </div>
            </div>
        </article>

        <!-- REPLIES LIST -->
        <div class="pt-4">
            <h3 class="text-lg font-bold text-slate-800 mb-4 flex items-center gap-2">
                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8h2a2 2 0 012 2v6a2 2 0 01-2 2h-2v4l-4-4H9a1.994 1.994 0 01-1.414-.586m0 0L11 14h4a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2v4l.586-.586z"></path></svg>
                {{ $question->replies->count() }} Balasan
            </h3>

            <div class="space-y-4">
                @forelse ($question->replies as $reply)
                    <div class="bg-white rounded-2xl p-5 border border-slate-200 shadow-sm ml-4 md:ml-12 relative before:absolute before:content-[''] before:-left-6 before:top-8 before:w-6 before:h-px before:bg-slate-300">
                        <div class="flex items-start gap-4">
                            <img src="{{ $reply->user->getFilamentAvatarUrl() }}" class="w-10 h-10 rounded-full object-cover border border-slate-200 flex-shrink-0">
                            <div class="w-full">
                                <div class="flex flex-col">
                                    <span class="font-bold text-slate-800 text-sm">{{ $reply->user->name }}</span>
                                    <span class="text-xs text-slate-400">{{ $reply->created_at->diffForHumans() }}</span>
                                </div>
                                <div class="text-sm text-slate-700 mt-2 whitespace-pre-line">
                                    {{ $reply->content }}
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="ml-4 md:ml-12 p-4 text-center rounded-2xl bg-slate-100 border border-dashed border-slate-300">
                        <p class="text-sm text-slate-500">Belum ada tanggapan. Berikan tanggapan Anda di bawah!</p>
                    </div>
                @endforelse
            </div>
        </div>

        <!-- REPLY FORM -->
        <div class="mt-8 ml-4 md:ml-12 glass-card rounded-3xl p-6 shadow-sm">
            <h4 class="font-bold text-slate-800 mb-3 text-sm">Tambahkan Balasan</h4>
            <form action="{{ route('user.forum.reply.store', $question) }}" method="POST">
                @csrf
                <textarea name="content" rows="3" required placeholder="Tuliskan balasan atau komentar Anda..." class="w-full rounded-xl border border-slate-300 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 text-sm py-2 px-3 text-slate-700 bg-white mb-3"></textarea>
                <div class="flex justify-end">
                    <button type="submit" class="bg-blue-700 hover:bg-blue-800 text-white font-bold py-2 px-5 rounded-lg transition duration-200 text-sm shadow-md flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path></svg>
                        Kirim Balasan
                    </button>
                </div>
            </form>
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
