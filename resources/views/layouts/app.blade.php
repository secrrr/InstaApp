<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>{{ config('app.name', 'InstaApp') }}</title>
    @vite('resources/css/app.css')
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="bg-white flex">
    <!-- Navbar kiri -->
    <x-navbar/>

    <!-- Konten utama -->
    <div class="ml-64 w-full min-h-screen">
        {{ $slot }}
    </div>
</body>
</html>
