<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'MobiLex Admin') }} - Login</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased text-mobilex-white bg-mobilex-bg selection:bg-mobilex-accent selection:text-black">
    <!-- Ambient glows matching MobileX Ad -->
    <div class="fixed inset-0 pointer-events-none z-0 overflow-hidden flex items-center justify-center">
        <div class="absolute top-[-10%] right-[-10%] w-[500px] h-[500px] bg-mobilex-accent/10 rounded-full blur-[150px]"></div>
        <div class="absolute bottom-[-10%] left-[-10%] w-[500px] h-[500px] bg-mobilex-primary/10 rounded-full blur-[120px]"></div>
    </div>

    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 relative z-10">
        <div>
            <a href="/" wire:navigate class="flex items-center gap-3 group">
                <!-- MobileX Glowing Logo Box -->
                <div class="w-16 h-16 rounded-2xl bg-mobilex-bg border-4 border-mobilex-accent flex items-center justify-center text-3xl font-black text-mobilex-accent shadow-[0_0_20px_rgba(57,255,20,0.5)] transform -rotate-3 group-hover:rotate-0 transition-transform duration-300">
                    X
                </div>
                <div class="flex flex-col drop-shadow-md">
                    <span class="text-3xl font-black uppercase tracking-widest text-mobilex-white leading-none">MOBILEX</span>
                    <span class="text-[10px] font-black uppercase tracking-[0.4em] text-mobilex-primary opacity-80 mt-1">Admin Portal</span>
                </div>
            </a>
        </div>

        <div class="w-full sm:max-w-md mt-10 px-8 py-8 bg-mobilex-panel border border-mobilex-border shadow-[0_0_50px_rgba(0,0,0,0.5)] overflow-hidden rounded-3xl relative">
            <!-- Inner subtle glow on card -->
            <div class="absolute -top-32 -left-32 w-64 h-64 bg-mobilex-primary/5 rounded-full blur-[80px] pointer-events-none"></div>

            <div class="relative z-10">
                {{ $slot }}
            </div>
        </div>
        
        <div class="mt-8 text-center text-[10px] font-black uppercase tracking-[0.3em] text-mobilex-textSoft opacity-40">
            &copy; {{ date('Y') }} MobiLex Secure Network
        </div>
    </div>
</body>
</html>
