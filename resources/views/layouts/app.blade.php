<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Rombo Village WiFi') }} - Dashboard</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        
        <script src="https://cdn.tailwindcss.com"></script>
        <script>
            // Tailwind runtime config fallback if strictly required in the adhoc scripts, but app.css is driving v4 natively.
            tailwind.config = {
                darkMode: 'class',
                theme: {
                    extend: {
                        fontFamily: {
                            sans: ['Inter', 'sans-serif'],
                        },
                        colors: {
                            mobilex: {
                                bg: '#0a1711',
                                panel: '#10261a',
                                panelHover: '#163625',
                                primary: '#86efac',
                                accent: '#39FF14',
                                accentHover: '#66ff4d',
                                border: '#1b3d29',
                                textSoft: '#bbf7d0',
                                white: '#ffffff'
                            }
                        }
                    }
                }
            }
        </script>
        @livewireStyles
    </head>
    <body class="font-sans antialiased bg-mobilex-bg text-mobilex-white flex h-screen overflow-hidden text-sm">
        
        <!-- Sidebar Navigation -->
        <livewire:layout.navigation />

        <!-- Main Wrapper -->
        <div class="flex-1 flex flex-col h-screen overflow-hidden ml-0 md:ml-64 transition-all duration-300 relative">
            
            <!-- MobileX Glow Effect in Background (Top Right & Bottom Left) -->
            <div class="absolute inset-0 pointer-events-none z-0 overflow-hidden">
                <div class="absolute -top-32 -right-32 w-96 h-96 bg-mobilex-accent/10 rounded-full blur-[120px]"></div>
                <div class="absolute -bottom-32 -left-32 w-96 h-96 bg-mobilex-primary/5 rounded-full blur-[100px]"></div>
            </div>

            <!-- Top Navbar (Mobile Hamburger & Quick Stats) -->
            <header class="h-16 flex items-center justify-between px-6 border-b border-mobilex-border bg-mobilex-panel/80 backdrop-blur-md sticky top-0 z-20">
                <div class="flex items-center lg:hidden">
                    <button class="text-mobilex-textSoft hover:text-mobilex-white focus:outline-none">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                    </button>
                </div>
                
                @if (isset($header))
                    <h2 class="font-extrabold text-lg text-mobilex-white hidden md:block uppercase tracking-wider">
                        {{ $header }}
                    </h2>
                @endif

                <div class="flex items-center space-x-4">
                    <span class="flex h-3 w-3 relative">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-mobilex-accent opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-3 w-3 bg-mobilex-accent"></span>
                    </span>
                    <span class="text-xs font-bold text-mobilex-primary uppercase tracking-widest">System Online</span>
                    
                    @auth
                        <div class="pl-4 border-l border-mobilex-border">
                            <span class="text-sm font-bold text-mobilex-white">{{ auth()->user()->name }}</span>
                        </div>
                    @endauth
                </div>
            </header>

            <!-- Page Content -->
            <main class="flex-1 overflow-y-auto w-full p-4 lg:p-8 scroll-smooth pb-20 relative z-10">
                <div class="max-w-7xl mx-auto w-full">
                    {{ $slot }}
                </div>
            </main>
        </div>

        @livewireScripts
    </body>
</html>
