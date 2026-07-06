<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BeasisMatch - Rekomendasi Beasiswa Cerdas</title>
    <!-- Modern Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400..900;1,400..900&family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Plus Jakarta Sans', 'sans-serif'],
                        playfair: ['Playfair Display', 'serif'],
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
            box-shadow: 0 0 20px rgba(30, 64, 175, 0.05);
        }
        #quote-text, #quote-author {
            transition: opacity 0.35s ease-in-out;
        }
    </style>
</head>
<body class="bg-slate-50 text-slate-800 font-sans min-h-screen overflow-x-hidden selection:bg-blue-100 selection:text-blue-900">

    <!-- DECORATIVE BACKGROUND GLOW -->
    <div class="absolute top-0 left-1/4 w-96 h-96 bg-blue-200/10 rounded-full blur-[120px] pointer-events-none"></div>
    <div class="absolute top-1/3 right-1/4 w-[400px] h-[400px] bg-indigo-200/10 rounded-full blur-[140px] pointer-events-none"></div>

    <header class="sticky top-0 z-40 bg-white/85 backdrop-blur-md border-b border-slate-200">
        <div class="mx-auto flex max-w-7xl items-center justify-between px-6 py-4">
            <a href="{{ route('landing') }}" class="flex items-center gap-2 group">
                <img src="{{ asset('images/logo.png') }}" alt="BeasisMatch Logo" class="h-10 md:h-12 w-auto object-contain transition-transform group-hover:scale-[1.02]">
            </a>

            <nav class="flex items-center gap-3">
                @auth
                    <a href="{{ route('user.dashboard') }}" class="rounded-xl bg-blue-700 px-5 py-2.5 text-sm font-semibold text-white shadow-md shadow-blue-500/10 hover:bg-blue-800 transition duration-150">
                        Dashboard
                    </a>
                    <form action="{{ route('user.logout') }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="rounded-xl border border-slate-300 bg-white px-4 py-2.5 text-sm font-semibold text-slate-700 hover:bg-slate-50 transition duration-150">
                            Keluar
                        </button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="rounded-xl bg-blue-700 px-6 py-2.5 text-sm font-bold text-white shadow-md shadow-blue-500/10 hover:bg-blue-800 hover:scale-[1.02] transition duration-150">
                        Masuk
                    </a>
                @endauth
            </nav>
        </div>
    </header>

    <main class="relative z-10">
        <!-- HERO SECTION -->
        <section class="mx-auto grid max-w-7xl grid-cols-1 gap-12 px-6 py-20 lg:grid-cols-12 lg:items-center">
            <div class="space-y-6 lg:col-span-7">
                <span class="inline-flex items-center gap-1.5 px-4 py-1.5 rounded-full text-xs font-semibold bg-blue-50 text-blue-700 border border-blue-200">
                    <span class="w-1.5 h-1.5 rounded-full bg-blue-600 animate-pulse"></span>
                    Gratis untuk Pelajar & Mahasiswa
                </span>

                <h2 class="text-3xl font-extrabold leading-tight text-slate-900 md:text-5xl lg:text-6xl">
                    Raih Masa Depan Gemilang dengan Beasiswa Terbaik.
                </h2>

                <p class="text-base md:text-lg leading-relaxed text-slate-600">
                    BeasisMatch membantu mencocokkan jenjang pendidikan, semester aktif, IPK,
                    target jenjang, intake semester, dan deadline beasiswa menggunakan hard filtering
                    dan weighted scoring secara akurat dan real-time.
                </p>

                <div class="flex flex-wrap gap-4 pt-2">
                    @auth
                        <a href="{{ route('user.dashboard') }}" class="rounded-xl bg-blue-700 px-6 py-3.5 text-sm font-bold text-white shadow-lg shadow-blue-500/10 hover:bg-blue-800 hover:scale-[1.02] transition duration-150">
                            Buka Dashboard Rekomendasi
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="rounded-xl bg-blue-700 px-6 py-3.5 text-sm font-bold text-white shadow-lg shadow-blue-500/10 hover:bg-blue-800 hover:scale-[1.02] transition duration-150">
                            Mulai Cari Beasiswa
                        </a>
                        <a href="{{ route('user.register') }}" class="rounded-xl border border-slate-300 bg-white px-6 py-3.5 text-sm font-bold text-slate-700 hover:bg-slate-50 hover:scale-[1.02] transition duration-150">
                            Daftar Akun Baru
                        </a>
                    @endauth
                </div>
            </div>

            <div class="rounded-3xl border bg-white p-8 shadow-sm glow-effect lg:col-span-5">
                <h3 class="text-xl font-bold text-slate-800 flex items-center gap-2">
                    <svg class="w-5 h-5 text-blue-700" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path>
                    </svg>
                    Alur Rekomendasi Beasiswa
                </h3>

                <div class="mt-6 space-y-4">
                    <div class="rounded-2xl bg-slate-50 p-4 border border-slate-100 hover:border-blue-200 transition duration-200">
                        <p class="font-bold text-slate-800 text-sm">1. Isi Profil Akademik</p>
                        <p class="text-xs text-slate-600 mt-1">Lengkapi jenjang, semester, IPK, jurusan, universitas, dan target beasiswa Anda.</p>
                    </div>

                    <div class="rounded-2xl bg-slate-50 p-4 border border-slate-100 hover:border-blue-200 transition duration-200">
                        <p class="font-bold text-slate-800 text-sm">2. Hard Filtering</p>
                        <p class="text-xs text-slate-600 mt-1">Sistem menyaring dan mengeliminasi beasiswa yang tidak memenuhi kriteria minimum Anda.</p>
                    </div>

                    <div class="rounded-2xl bg-slate-50 p-4 border border-slate-100 hover:border-blue-200 transition duration-200">
                        <p class="font-bold text-slate-800 text-sm">3. Weighted Scoring</p>
                        <p class="text-xs text-slate-600 mt-1">Beasiswa diurutkan berdasarkan tingkat kecocokan jurusan, IPK, negara tujuan, dan pendanaan.</p>
                    </div>

                    <div class="rounded-2xl bg-blue-50 p-4 border border-blue-100 hover:border-blue-300 transition duration-200">
                        <p class="font-bold text-blue-900 text-sm">4. Rekomendasi Instan</p>
                        <p class="text-xs text-blue-700 mt-1">Lihat dan daftar ke beasiswa terbaik yang paling relevan dengan profil akademik Anda.</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- INSPIRATIONAL QUOTES SECTION -->
        <section class="bg-white border-y border-slate-200 py-16 relative overflow-hidden">
            <div class="absolute inset-0 bg-[radial-gradient(#e2e8f0_1px,transparent_1px)] [background-size:16px_16px] opacity-40"></div>
            <div class="max-w-4xl mx-auto px-6 relative z-10 text-center space-y-6">
                <div class="inline-flex items-center justify-center w-12 h-12 rounded-full bg-blue-50 text-blue-600 mb-2">
                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path d="M14.017 21v-7.391c0-5.704 3.748-9.762 9-10.361l.512 1.02c-4.174 1.253-6.686 4.79-6.911 8.341H23v8.391h-8.983zm-14 0v-7.391c0-5.704 3.748-9.762 9-10.361l.512 1.02c-4.174 1.253-6.686 4.79-6.911 8.341H9v8.391H0z"/>
                    </svg>
                </div>
                
                <div class="min-h-[100px] flex flex-col justify-center items-center">
                    <p id="quote-text" class="text-xl md:text-2xl font-serif italic text-slate-800 leading-relaxed font-playfair">
                        Loading quote...
                    </p>
                    <p id="quote-author" class="text-xs md:text-sm font-bold tracking-wider text-slate-500 uppercase mt-4 font-sans">
                        — Loading
                    </p>
                </div>

                <!-- Slide Indicators / Dots -->
                <div class="flex justify-center gap-2 pt-4">
                    <span class="quote-dot w-2.5 h-2.5 rounded-full bg-slate-200 cursor-pointer transition-all duration-300" onclick="setQuote(0)"></span>
                    <span class="quote-dot w-2.5 h-2.5 rounded-full bg-slate-200 cursor-pointer transition-all duration-300" onclick="setQuote(1)"></span>
                    <span class="quote-dot w-2.5 h-2.5 rounded-full bg-slate-200 cursor-pointer transition-all duration-300" onclick="setQuote(2)"></span>
                    <span class="quote-dot w-2.5 h-2.5 rounded-full bg-slate-200 cursor-pointer transition-all duration-300" onclick="setQuote(3)"></span>
                </div>
            </div>
        </section>

        <!-- FEATURES SECTION -->
        <section id="fitur" class="bg-slate-50 py-20">
            <div class="mx-auto max-w-7xl px-6">
                <div class="text-center max-w-xl mx-auto space-y-3">
                    <h3 class="text-3xl font-extrabold text-slate-900">Mengapa Menggunakan BeasisMatch?</h3>
                    <p class="text-slate-500 text-sm">Fitur unggulan kami dirancang khusus untuk memudahkan perjalanan akademis Anda.</p>
                </div>

                <div class="mt-12 grid gap-8 md:grid-cols-3">
                    <div class="rounded-2xl border border-slate-200 bg-white p-6 space-y-3 hover:border-blue-300 hover:shadow-lg hover:shadow-blue-500/[0.02] transition duration-300">
                        <div class="w-10 h-10 rounded-xl bg-blue-50 flex items-center justify-center text-blue-700 font-bold">
                            ⚡
                        </div>
                        <h4 class="font-bold text-slate-950">Matching Engine Cerdas</h4>
                        <p class="text-sm leading-relaxed text-slate-600">
                            Menghasilkan rekomendasi beasiswa yang terpersonalisasi berdasarkan IPK, kualifikasi, dan preferensi negara Anda secara instan.
                        </p>
                    </div>

                    <div class="rounded-2xl border border-slate-200 bg-white p-6 space-y-3 hover:border-blue-300 hover:shadow-lg hover:shadow-blue-500/[0.02] transition duration-300">
                        <div class="w-10 h-10 rounded-xl bg-indigo-50 flex items-center justify-center text-indigo-700 font-bold">
                            🛡
                        </div>
                        <h4 class="font-bold text-slate-950">Manajemen Data Terpusat</h4>
                        <p class="text-sm leading-relaxed text-slate-600">
                            Admin dapat memperbarui basis data beasiswa, tanggal penting, serta kuota penerimaan secara dinamis melalui panel admin.
                        </p>
                    </div>

                    <div class="rounded-2xl border border-slate-200 bg-white p-6 space-y-3 hover:border-blue-300 hover:shadow-lg hover:shadow-blue-500/[0.02] transition duration-300">
                        <div class="w-10 h-10 rounded-xl bg-violet-50 flex items-center justify-center text-violet-700 font-bold">
                            💡
                        </div>
                        <h4 class="font-bold text-slate-950">Kurasi Akurat</h4>
                        <p class="text-sm leading-relaxed text-slate-600">
                            Dapatkan ulasan dan bantuan kurasi manual untuk berkas pendaftaran Anda demi memperbesar peluang lolos beasiswa.
                        </p>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <footer class="border-t bg-slate-900 py-8 text-center text-xs text-slate-400 relative z-10">
        <div class="max-w-7xl mx-auto px-4 space-y-2">
            <p class="font-bold text-white">BeasisMatch &copy; {{ date('Y') }}</p>
            <p>Sistem Rekomendasi Beasiswa Cerdas berbasis Laravel, TailwindCSS, & Livewire.</p>
        </div>
    </footer>

    <script>
        const quotes = [
            {
                text: "Pendidikan adalah senjata paling mematikan di dunia, karena dengan pendidikan Anda dapat mengubah dunia.",
                author: "Nelson Mandela"
            },
            {
                text: "Raih masa depan gemilang tanpa batas finansial. Beasiswa adalah jembatan emas menuju impianmu.",
                author: "BeasisMatch Campaign"
            },
            {
                text: "Investasi dalam pengetahuan selalu membayar bunga terbaik.",
                author: "Benjamin Franklin"
            },
            {
                text: "Pendidikan bukan cuma pergi ke sekolah dan mendapatkan gelar. Tapi juga soal memperluas pengetahuan dan menyerap ilmu kehidupan.",
                author: "Shakuntala Devi"
            }
        ];

        let currentQuoteIndex = 0;
        const quoteTextEl = document.getElementById('quote-text');
        const quoteAuthorEl = document.getElementById('quote-author');
        const dots = document.querySelectorAll('.quote-dot');

        function setQuote(index) {
            currentQuoteIndex = index;
            // Fade out
            quoteTextEl.style.opacity = 0;
            quoteAuthorEl.style.opacity = 0;
            
            setTimeout(() => {
                quoteTextEl.textContent = quotes[index].text;
                quoteAuthorEl.textContent = "— " + quotes[index].author;
                
                // Fade in
                quoteTextEl.style.opacity = 1;
                quoteAuthorEl.style.opacity = 1;
                
                // Update dots
                dots.forEach((dot, idx) => {
                    if (idx === index) {
                        dot.classList.remove('bg-slate-200');
                        dot.classList.add('bg-blue-600', 'w-4');
                    } else {
                        dot.classList.remove('bg-blue-600', 'w-4');
                        dot.classList.add('bg-slate-200');
                    }
                });
            }, 200);
        }

        // Initialize first quote
        setQuote(0);

        // Auto cycle quotes
        setInterval(() => {
            let nextIndex = (currentQuoteIndex + 1) % quotes.length;
            setQuote(nextIndex);
        }, 6000);
    </script>
</body>
</html>