<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title') — WALHI Jawa Barat</title>
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Anton&family=Bebas+Neue&family=Inter:wght@400;600;700;800&family=Oswald:wght@500;700&display=swap" rel="stylesheet">
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#F4F1EA] text-[#1D1D1D] font-sans antialiased min-h-screen flex flex-col justify-between selection:bg-[#256D4A] selection:text-white">
    <!-- Mini Header -->
    <header class="bg-[#1D1D1D] border-b-4 border-[#256D4A] py-4 px-6">
        <div class="max-w-6xl mx-auto flex items-center justify-between">
            <a href="/" class="flex items-center gap-3">
                <img src="{{ asset('assets/images/resources/logo-2-walhi.png') }}" alt="WALHI Jawa Barat" class="h-10 object-contain" />
            </a>
            <a href="/" class="text-[#F4F1EA] hover:text-[#5C8D59] font-heading uppercase text-sm tracking-wider transition-colors">
                ← Kembali ke Beranda
            </a>
        </div>
    </header>

    <!-- Error Content Container -->
    <main class="flex-1 flex items-center justify-center p-6 md:p-12">
        <div class="max-w-xl w-full bg-white border-4 border-[#1D1D1D] shadow-[8px_8px_0px_0px_#1D1D1D] p-8 md:p-12 text-center relative">
            <div class="inline-block bg-[#256D4A] text-white px-4 py-1.5 text-xs font-bold uppercase tracking-widest mb-6">
                @yield('badge', 'PEMBERITAHUAN SISTEM')
            </div>

            <h1 class="text-7xl md:text-8xl font-heading text-[#D95C3F] tracking-wider mb-2">
                @yield('code')
            </h1>

            <h2 class="text-2xl md:text-3xl font-heading uppercase text-[#1D1D1D] tracking-wide mb-4">
                @yield('heading')
            </h2>

            <p class="text-sm md:text-base text-[#1D1D1D]/80 leading-relaxed mb-8">
                @yield('message')
            </p>

            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="/" class="px-6 py-3 bg-[#256D4A] text-[#F4F1EA] border-2 border-[#1D1D1D] font-heading uppercase text-sm tracking-wider shadow-[4px_4px_0px_0px_#1D1D1D] hover:bg-[#1e5a3d] transition-all">
                    Beranda WALHI
                </a>
                <a href="/blog" class="px-6 py-3 bg-white text-[#1D1D1D] border-2 border-[#1D1D1D] font-heading uppercase text-sm tracking-wider shadow-[4px_4px_0px_0px_#1D1D1D] hover:bg-[#F4F1EA] transition-all">
                    Baca Berita
                </a>
            </div>
        </div>
    </main>

    <!-- Mini Footer -->
    <footer class="bg-[#1D1D1D] text-[#F4F1EA]/70 text-center py-4 text-xs border-t-2 border-[#1D1D1D]">
        <p>&copy; {{ date('Y') }} Wahana Lingkungan Hidup Indonesia — Jawa Barat. Pulihkan Ekologi Jawa Barat!</p>
    </footer>
</body>
</html>
