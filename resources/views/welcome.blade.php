<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Laravel 13 - Skeleton Ready</title>

        <!-- Google Fonts (Plus Jakarta Sans & Outfit) -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">

        <!-- Styles / Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <style>
            body {
                font-family: 'Plus Jakarta Sans', sans-serif;
                background-color: #030303;
                background-image: 
                    radial-gradient(at 0% 0%, hsla(253,16%,7%,1) 0, transparent 50%), 
                    radial-gradient(at 50% 0%, hsla(225,39%,10%,1) 0, transparent 50%), 
                    radial-gradient(at 100% 0%, hsla(339,49%,9%,1) 0, transparent 50%);
                background-attachment: fixed;
            }
            .heading-font {
                font-family: 'Outfit', sans-serif;
            }
            .glass-card {
                background: rgba(18, 18, 24, 0.65);
                backdrop-filter: blur(12px);
                -webkit-backdrop-filter: blur(12px);
                border: 1px solid rgba(255, 255, 255, 0.06);
                box-shadow: 0 8px 32px 0 rgba(0, 0, 0, 0.37);
                transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1);
            }
            .glass-card:hover {
                transform: translateY(-5px);
                border-color: rgba(255, 255, 255, 0.12);
                box-shadow: 0 12px 40px 0 rgba(139, 92, 246, 0.15);
            }
            .glow-text {
                background: linear-gradient(135deg, #a78bfa 0%, #f472b6 100%);
                -webkit-background-clip: text;
                -webkit-text-fill-color: transparent;
            }
            .tech-pill {
                background: rgba(255, 255, 255, 0.03);
                border: 1px solid rgba(255, 255, 255, 0.05);
                transition: all 0.3s ease;
            }
            .tech-pill:hover {
                background: rgba(255, 255, 255, 0.07);
                border-color: rgba(255, 255, 255, 0.15);
            }
            /* Grid Background */
            .grid-overlay {
                background-size: 40px 40px;
                background-image: 
                    linear-gradient(to right, rgba(255, 255, 255, 0.015) 1px, transparent 1px),
                    linear-gradient(to bottom, rgba(255, 255, 255, 0.015) 1px, transparent 1px);
            }
            /* Pulsing light */
            @keyframes pulse-glow {
                0%, 100% { opacity: 0.2; transform: scale(1); }
                50% { opacity: 0.35; transform: scale(1.05); }
            }
            .glow-bg {
                animation: pulse-glow 8s infinite ease-in-out;
            }
        </style>
    </head>
    <body class="antialiased text-gray-200 min-h-screen flex flex-col relative overflow-x-hidden">
        <!-- Background decorative details -->
        <div class="absolute top-[-10%] left-[20%] w-[600px] h-[600px] rounded-full bg-violet-800/10 blur-[120px] pointer-events-none glow-bg"></div>
        <div class="absolute bottom-[10%] right-[10%] w-[400px] h-[400px] rounded-full bg-pink-700/5 blur-[100px] pointer-events-none glow-bg" style="animation-delay: -4s;"></div>
        <div class="absolute inset-0 grid-overlay pointer-events-none"></div>

        <!-- Navigation Bar -->
        <header class="w-full max-w-7xl mx-auto px-6 py-6 flex items-center justify-between z-10">
            <div class="flex items-center gap-3">
                <div class="h-10 w-10 rounded-xl bg-gradient-to-tr from-violet-600 to-pink-500 flex items-center justify-center shadow-lg shadow-violet-500/20">
                    <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z" />
                    </svg>
                </div>
                <span class="heading-font font-bold text-xl tracking-tight text-white">Laravel<span class="text-violet-400">13</span></span>
            </div>
            
            <nav class="flex items-center gap-4">
                @if (Route::has('login'))
                    @auth
                        <a href="{{ url('/dashboard') }}" class="px-5 py-2 rounded-lg bg-violet-600 hover:bg-violet-500 text-white font-medium text-sm transition-all duration-200 shadow-md shadow-violet-600/10">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="text-sm font-medium text-gray-400 hover:text-white transition-colors duration-200">Log in</a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="px-4 py-2 rounded-lg bg-gray-900 hover:bg-gray-800 text-white border border-gray-800 text-sm font-medium transition-colors duration-200">Register</a>
                        @endif
                    @endauth
                @endif
                <span class="px-3 py-1 rounded-full text-xs font-semibold bg-emerald-500/10 text-emerald-400 border border-emerald-500/20 flex items-center gap-1.5">
                    <span class="h-1.5 w-1.5 rounded-full bg-emerald-400 animate-pulse"></span>
                    Running
                </span>
            </nav>
        </header>

        <!-- Main Hero Section -->
        <main class="flex-1 w-full max-w-7xl mx-auto px-6 flex flex-col justify-center py-12 z-10">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
                
                <!-- Left Column: Copy & Badges -->
                <div class="lg:col-span-7 flex flex-col gap-6 text-left">
                    <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-violet-500/10 border border-violet-500/20 w-fit">
                        <span class="text-xs font-semibold text-violet-300 uppercase tracking-wider">Antigravity AI template</span>
                    </div>

                    <h1 class="heading-font font-extrabold text-4xl sm:text-5xl lg:text-6xl text-white leading-tight tracking-tight">
                        Kerangka Laravel <br>
                        <span class="glow-text">Siap untuk Dibuat</span>
                    </h1>

                    <p class="text-gray-400 text-lg max-w-xl leading-relaxed">
                        Proyek Laravel 13 Anda telah berhasil diinisialisasi dan dikonfigurasi dengan database SQLite secara instan. Mulai coding sekarang!
                    </p>

                    <!-- System Status Info Dashboard -->
                    <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 mt-4">
                        <div class="tech-pill p-4 rounded-xl flex flex-col gap-1">
                            <span class="text-xs text-gray-500 font-medium">LARAVEL</span>
                            <span class="font-bold text-white heading-font text-lg">v13.18.1</span>
                        </div>
                        <div class="tech-pill p-4 rounded-xl flex flex-col gap-1">
                            <span class="text-xs text-gray-500 font-medium">PHP</span>
                            <span class="font-bold text-white heading-font text-lg">v8.5.5</span>
                        </div>
                        <div class="tech-pill p-4 rounded-xl flex flex-col gap-1">
                            <span class="text-xs text-gray-500 font-medium">DATABASE</span>
                            <span class="font-bold text-white heading-font text-lg">SQLite</span>
                        </div>
                        <div class="tech-pill p-4 rounded-xl flex flex-col gap-1">
                            <span class="text-xs text-gray-500 font-medium">ENVIRONMENT</span>
                            <span class="font-bold text-emerald-400 heading-font text-lg">Local</span>
                        </div>
                    </div>

                    <!-- CTA Action Buttons -->
                    <div class="flex flex-wrap gap-4 mt-6">
                        <a href="https://laravel.com/docs" target="_blank" class="px-6 py-3.5 rounded-xl bg-gradient-to-r from-violet-600 to-pink-600 hover:from-violet-500 hover:to-pink-500 text-white font-semibold text-sm transition-all duration-300 shadow-lg shadow-violet-500/25 flex items-center gap-2 hover:scale-[1.02] transform">
                            <span>Baca Dokumentasi</span>
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                            </svg>
                        </a>
                        <a href="https://laracasts.com" target="_blank" class="px-6 py-3.5 rounded-xl bg-gray-900/60 hover:bg-gray-800/80 text-gray-300 hover:text-white font-semibold text-sm border border-gray-800 transition-colors duration-200 flex items-center gap-2">
                            <span>Tonton Laracasts</span>
                        </a>
                    </div>
                </div>

                <!-- Right Column: Interactive Project Quickstart Cards -->
                <div class="lg:col-span-5 flex flex-col gap-6">
                    <div class="glass-card p-6 rounded-2xl flex gap-4">
                        <div class="h-12 w-12 rounded-xl bg-violet-500/10 border border-violet-500/25 flex items-center justify-center shrink-0">
                            <svg class="h-6 w-6 text-violet-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z" />
                            </svg>
                        </div>
                        <div class="flex flex-col gap-1">
                            <h3 class="heading-font font-bold text-white text-base">Struktur Folder</h3>
                            <p class="text-sm text-gray-400">Routes didefinisikan di <code>routes/web.php</code>. Tampilan HTML/Blade berada di folder <code>resources/views</code>.</p>
                        </div>
                    </div>

                    <div class="glass-card p-6 rounded-2xl flex gap-4">
                        <div class="h-12 w-12 rounded-xl bg-pink-500/10 border border-pink-500/25 flex items-center justify-center shrink-0">
                            <svg class="h-6 w-6 text-pink-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4m0 5c0 2.21-3.582 4-8 4s-8-1.79-8-4" />
                            </svg>
                        </div>
                        <div class="flex flex-col gap-1">
                            <h3 class="heading-font font-bold text-white text-base">Database Migrasi</h3>
                            <p class="text-sm text-gray-400">Database SQLite otomatis terisi migrasi default. Tambahkan skema baru Anda di <code>database/migrations</code>.</p>
                        </div>
                    </div>

                    <div class="glass-card p-6 rounded-2xl flex gap-4">
                        <div class="h-12 w-12 rounded-xl bg-blue-500/10 border border-blue-500/25 flex items-center justify-center shrink-0">
                            <svg class="h-6 w-6 text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4" />
                            </svg>
                        </div>
                        <div class="flex flex-col gap-1">
                            <h3 class="heading-font font-bold text-white text-base">Vite & Tailwind CSS</h3>
                            <p class="text-sm text-gray-400">Assets dikompilasi secara real-time dengan Vite. Silakan edit file styles di <code>resources/css/app.css</code>.</p>
                        </div>
                    </div>
                </div>

            </div>
        </main>

        <!-- Footer -->
        <footer class="w-full max-w-7xl mx-auto px-6 py-8 border-t border-gray-900/60 flex flex-col sm:flex-row items-center justify-between text-gray-500 text-xs z-10 gap-4">
            <p>&copy; 2026 Laravel Skeleton. Dibuat otomatis oleh Antigravity AI.</p>
            <div class="flex gap-6">
                <a href="https://laravel.com" class="hover:text-gray-300 transition-colors">Laravel</a>
                <a href="https://vite.dev" class="hover:text-gray-300 transition-colors">Vite</a>
                <a href="https://tailwindcss.com" class="hover:text-gray-300 transition-colors">Tailwind CSS</a>
            </div>
        </footer>
    </body>
</html>
