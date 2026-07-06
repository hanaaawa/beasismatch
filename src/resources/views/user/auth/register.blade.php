<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - BeasisMatch</title>
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
</head>
<body class="bg-slate-50 text-slate-800 font-sans min-h-screen selection:bg-blue-200 selection:text-blue-900 flex items-center justify-center p-6 relative overflow-x-hidden">

    <!-- DECORATIVE BACKGROUND GLOW -->
    <div class="absolute top-1/4 left-1/4 w-96 h-96 bg-blue-200/30 rounded-full blur-[120px] pointer-events-none"></div>
    <div class="absolute bottom-1/4 right-1/4 w-96 h-96 bg-indigo-200/30 rounded-full blur-[120px] pointer-events-none"></div>

    <div class="w-full max-w-md relative z-10">
        
        <!-- LOGO HEADER -->
        <div class="mb-6 text-center flex flex-col items-center">
            <a href="{{ route('landing') }}" class="flex items-center gap-2 group mb-3">
                <img src="{{ asset('images/logo.png') }}" alt="BeasisMatch Logo" class="h-12 w-auto object-contain">
            </a>
            <h2 class="text-xl font-bold text-slate-800 mt-1">Buat Akun Baru</h2>
            <p class="text-xs text-slate-500 mt-1">Dapatkan pencocokan dan rekomendasi beasiswa gratis.</p>
        </div>

        <!-- GLASS CARD FORM -->
        <div class="glass-card rounded-3xl p-8 shadow-xl glow-effect">
            
            <!-- ERROR BANNER -->
            @if ($errors->any())
                <div class="mb-5 p-4 rounded-xl bg-red-50 border border-red-200 text-red-600 text-xs">
                    <p class="font-bold mb-1">Gagal Registrasi:</p>
                    <ul class="list-disc pl-4 space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- GOOGLE SIGN UP -->
            <a href="{{ route('google.redirect') }}"
                class="mb-5 flex w-full items-center justify-center gap-2 rounded-xl border border-slate-300 bg-white px-4 py-2.5 text-sm font-semibold text-slate-700 hover:bg-slate-50 hover:text-slate-900 transition duration-150">
                <svg class="w-4 h-4 mr-1.5" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" fill="#4285F4"/>
                    <path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" fill="#34A853"/>
                    <path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.06H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.94l2.85-2.22.81-.63z" fill="#FBBC05"/>
                    <path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.06l3.66 2.84c.87-2.6 3.3-4.52 6.16-4.52z" fill="#EA4335"/>
                </svg>
                <span>Daftar dengan Google</span>
            </a>

            <!-- DIVIDER -->
            <div class="mb-5 flex items-center gap-3">
                <div class="h-px flex-1 bg-slate-200"></div>
                <span class="text-[10px] text-slate-400 font-semibold uppercase tracking-wider">Atau dengan Email</span>
                <div class="h-px flex-1 bg-slate-200"></div>
            </div>

            <form method="POST" action="{{ route('user.register.store') }}" class="space-y-4">
                @csrf

                <div class="space-y-1.5">
                    <label class="text-xs font-semibold text-slate-600">Nama Lengkap</label>
                    <input type="text" name="name" value="{{ old('name') }}" required placeholder="Nama Anda"
                        class="w-full rounded-xl bg-white border border-slate-300 focus:border-blue-500 focus:ring-1 focus:ring-blue-500/30 text-slate-800 placeholder-slate-400 px-4 py-2.5 text-sm focus:outline-none transition duration-200">
                </div>

                <div class="space-y-1.5">
                    <label class="text-xs font-semibold text-slate-600">Alamat Email</label>
                    <input type="email" name="email" value="{{ old('email') }}" required placeholder="nama@email.com"
                        class="w-full rounded-xl bg-white border border-slate-300 focus:border-blue-500 focus:ring-1 focus:ring-blue-500/30 text-slate-800 placeholder-slate-400 px-4 py-2.5 text-sm focus:outline-none transition duration-200">
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div class="space-y-1.5">
                        <label class="text-xs font-semibold text-slate-600">Password</label>
                        <input type="password" name="password" required placeholder="Min. 8 karakter"
                            class="w-full rounded-xl bg-white border border-slate-300 focus:border-blue-500 focus:ring-1 focus:ring-blue-500/30 text-slate-800 placeholder-slate-400 px-4 py-2.5 text-sm focus:outline-none transition duration-200">
                    </div>

                    <div class="space-y-1.5">
                        <label class="text-xs font-semibold text-slate-600">Konfirmasi Password</label>
                        <input type="password" name="password_confirmation" required placeholder="Ulangi password"
                            class="w-full rounded-xl bg-white border border-slate-300 focus:border-blue-500 focus:ring-1 focus:ring-blue-500/30 text-slate-800 placeholder-slate-400 px-4 py-2.5 text-sm focus:outline-none transition duration-200">
                    </div>
                </div>

                <button type="submit"
                    class="w-full rounded-xl bg-gradient-to-r from-blue-700 to-indigo-700 hover:from-blue-800 hover:to-indigo-800 text-white py-3 text-sm font-bold shadow-lg shadow-blue-500/10 hover:shadow-blue-500/20 hover:scale-[1.01] active:scale-[0.99] transition duration-150 pt-2.5">
                    Daftar Akun Baru
                </button>
            </form>

            <div class="mt-6 pt-6 border-t border-slate-200 text-center text-xs text-slate-500">
                Sudah memiliki akun?
                <a href="{{ route('login') }}" class="font-bold text-blue-700 hover:text-blue-800 hover:underline">Masuk</a>
            </div>

        </div>

        <!-- BOTTOM NAV -->
        <p class="mt-6 text-center text-xs">
            <a href="{{ route('landing') }}" class="text-slate-500 hover:text-slate-700 transition duration-150 flex items-center justify-center gap-1">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Kembali ke Beranda
            </a>
        </p>

    </div>

</body>
</html>