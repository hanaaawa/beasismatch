<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - BeasisMatch</title>
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
        <div class="mb-8 text-center flex flex-col items-center">
            <a href="{{ route('landing') }}" class="flex items-center gap-2 group mb-3">
                <img src="{{ asset('images/logo.png') }}" alt="BeasisMatch Logo" class="h-12 w-auto object-contain">
            </a>
            <h2 class="text-xl font-bold text-slate-800 mt-2">Selamat Datang Kembali!</h2>
            <p class="text-xs text-slate-500 mt-1">Masuk untuk melihat rekomendasi beasiswa Anda.</p>
        </div>

        <!-- GLASS CARD FORM -->
        <div class="glass-card rounded-3xl p-8 shadow-xl glow-effect">
            
            <!-- ERROR BANNER -->
            @if ($errors->any())
                <div class="mb-6 p-4 rounded-xl bg-red-50 border border-red-200 text-red-600 text-xs">
                    <p class="font-bold mb-1">Gagal Masuk:</p>
                    <ul class="list-disc pl-4 space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('user.login.store') }}" class="space-y-5">
                @csrf

                <div class="space-y-1.5">
                    <label class="text-xs font-semibold text-slate-600">Alamat Email</label>
                    <input type="email" name="email" value="{{ old('email') }}" required placeholder="nama@email.com"
                        class="w-full rounded-xl bg-white border border-slate-300 focus:border-blue-500 focus:ring-1 focus:ring-blue-500/30 text-slate-800 placeholder-slate-400 px-4 py-2.5 text-sm focus:outline-none transition duration-200">
                </div>

                <div class="space-y-1.5">
                    <div class="flex justify-between items-center">
                        <label class="text-xs font-semibold text-slate-600">Password</label>
                    </div>
                    <input type="password" name="password" required placeholder="••••••••"
                        class="w-full rounded-xl bg-white border border-slate-300 focus:border-blue-500 focus:ring-1 focus:ring-blue-500/30 text-slate-800 placeholder-slate-400 px-4 py-2.5 text-sm focus:outline-none transition duration-200">
                </div>

                <div class="flex items-center justify-between pt-1">
                    <label class="flex items-center gap-2 text-xs text-slate-500 cursor-pointer select-none">
                        <input type="checkbox" name="remember" value="1" class="rounded bg-white border-slate-300 text-blue-600 focus:ring-0 focus:ring-offset-0">
                        Ingat saya
                    </label>
                </div>

                <button type="submit"
                    class="w-full rounded-xl bg-gradient-to-r from-blue-700 to-indigo-700 hover:from-blue-800 hover:to-indigo-800 text-white py-3 text-sm font-bold shadow-lg shadow-blue-500/10 hover:shadow-blue-500/20 hover:scale-[1.01] active:scale-[0.99] transition duration-150">
                    Masuk ke Akun
                </button>
            </form>

            <div class="mt-6 pt-6 border-t border-slate-200 text-center text-xs text-slate-500">
                Belum memiliki akun?
                <a href="{{ route('user.register') }}" class="font-bold text-blue-700 hover:text-blue-800 hover:underline">Daftar Sekarang</a>
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