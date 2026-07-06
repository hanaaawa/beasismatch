<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BeasisMatch</title>

    @vite('resources/css/app.css')
</head>

<body class="bg-gray-50 text-gray-900">

    {{-- NAVBAR --}}
    <nav class="bg-white border-b">
        <div class="max-w-7xl mx-auto px-6 py-4 flex justify-between items-center">

            <div class="font-bold text-blue-600 text-xl">
                BeasisMatch
            </div>

            <div class="space-x-4 text-sm">
                <a href="/dashboard" class="text-gray-600 hover:text-black">Dashboard</a>
                <a href="/scholarships" class="text-gray-600 hover:text-black">Scholarships</a>
                <a href="/profile" class="text-gray-600 hover:text-black">Profile</a>
            </div>

        </div>
    </nav>

    {{-- CONTENT --}}
    <main class="max-w-7xl mx-auto px-6 py-8">
        @yield('content')
    </main>

</body>
</html>