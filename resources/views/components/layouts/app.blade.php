<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'MobiLex WiFi') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body class="font-sans antialiased bg-mobilex-bg text-mobilex-white min-h-screen flex items-center justify-center p-4 selection:bg-mobilex-accent selection:text-black">
    
    <!-- Background aesthetics -->
    <div class="fixed inset-0 pointer-events-none z-0 overflow-hidden flex items-center justify-center">
        <!-- Glow effects -->
        <div class="absolute -top-40 -right-40 w-96 h-96 bg-mobilex-accent/10 rounded-full blur-[120px]"></div>
        <div class="absolute -bottom-40 -left-40 w-96 h-96 bg-mobilex-primary/10 rounded-full blur-[100px]"></div>
    </div>

    <!-- Main Content Slot -->
    <main class="w-full relative z-10">
        {{ $slot }}
    </main>

    @livewireScripts
</body>
</html>
