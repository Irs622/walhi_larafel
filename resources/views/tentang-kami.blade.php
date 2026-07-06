<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        @include('partials.seo-meta', ['title' => 'Tentang Kami - WALHI Jawa Barat'])

        <!-- Google Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Anton&family=Bebas+Neue&family=Inter:wght@400;500;600;700;800&family=Oswald:wght@400;500;600;700&display=swap" rel="stylesheet">
        
        <!-- Lucide Icons -->
        <script src="https://unpkg.com/lucide@latest"></script>
        
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="bg-[#F4F1EA] text-[#1D1D1D] font-sans antialiased">
        @include('partials.site-header')

        <!-- Hero Section -->
        <section class="bg-[#1D1D1D] border-b-4 border-[#256D4A] py-16 px-4 md:px-8 lg:px-16">
            <div class="max-w-6xl mx-auto">
                <nav class="flex items-center gap-2 text-xs font-semibold uppercase tracking-wider text-[#F4F1EA] mb-6">
                    <a href="{{ route('home') }}" class="hover:text-[#5C8D59]">Beranda</a>
                    <span class="text-[#256D4A]">/</span>
                    <a href="{{ route('about') }}" class="hover:text-[#5C8D59]">Tentang Kami</a>
                    <span class="text-[#256D4A]">/</span>
                    <span class="text-[#5C8D59]">Visi dan Misi</span>
                </nav>
                
                <h1 class="text-5xl md:text-7xl lg:text-8xl font-heading text-[#F4F1EA] uppercase tracking-wider mb-4">
                    VISI & MISI
                </h1>
                <p class="text-[#5C8D59] text-lg md:text-xl font-medium max-w-2xl mb-6">
                    Landasan Perjuangan WALHI Jawa Barat
                </p>
                <div class="w-32 h-2 bg-[#D95C3F]"></div>
            </div>
        </section>

        <!-- Main Content Area -->
        <main class="max-w-6xl mx-auto py-16 px-4 md:px-8 lg:px-16 flex flex-col gap-16">
            
            <!-- Visi Section -->
            <section class="bg-[#256D4A] border-4 border-[#1D1D1D] shadow-[8px_8px_0px_0px_#1D1D1D] p-8 md:p-12 text-center text-[#F4F1EA] relative">
                <span class="absolute -top-4 left-1/2 -translate-x-1/2 bg-[#1D1D1D] text-[#5C8D59] font-bold text-xs uppercase tracking-widest px-4 py-2">
                    Visi Kami
                </span>
                <h2 class="text-3xl md:text-5xl lg:text-6xl font-heading uppercase tracking-wide leading-tight mb-6 mt-4">
                    @if(!empty($visiMisi))
                        {!! $visiMisi->title !!}
                    @else
                        TERWUJUDNYA KEADILAN EKOLOGIS<br> DAN KEDAULATAN RAKYAT<br> ATAS SUMBER DAYA ALAM
                    @endif
                </h2>
                <p class="text-base md:text-xl leading-relaxed max-w-4xl mx-auto text-[#F4F1EA]/90">
                    @if(!empty($visiMisi))
                        {!! $visiMisi->body !!}
                    @else
                        Kami membayangkan Jawa Barat di mana masyarakat memiliki kontrol penuh atas sumber daya alam di wilayah mereka, di mana lingkungan hidup dilindungi bukan untuk profit tetapi untuk kehidupan, dan di mana keputusan tentang alam dibuat oleh rakyat yang hidupnya bergantung padanya — bukan oleh korporasi atau elite politik.
                    @endif
                </p>
            </section>

            <!-- Misi Section -->
            <section class="bg-white border-4 border-[#1D1D1D] shadow-[8px_8px_0px_0px_#1D1D1D] p-8 md:p-12">
                <div class="text-center mb-10">
                    <span class="inline-block bg-[#D95C3F] text-[#F4F1EA] font-bold text-xs uppercase tracking-widest px-4 py-2 mb-4">
                        Misi Kami
                    </span>
                    <h3 class="text-3xl md:text-4xl font-heading text-[#1D1D1D] uppercase tracking-wide">
                        Langkah Konkret Perjuangan
                    </h3>
                </div>
                
                @php
                    $missionItems = [
                        'Mengorganisir masyarakat sipil, petani, nelayan, masyarakat adat, dan kelompok rentan lainnya dalam memperjuangkan hak atas lingkungan hidup yang sehat dan berkelanjutan.',
                        'Melakukan advokasi kebijakan, riset, pendidikan kritis, dan kampanye publik untuk menghentikan praktik perusakan lingkungan dan perampasan ruang hidup.',
                        'Memperkuat solidaritas lintas wilayah dan membangun gerakan bersama yang berakar pada pengalaman perjuangan rakyat di Jawa Barat.',
                        'Mendorong praktik hidup dan tata kelola sumber daya alam yang adil, demokratis, dan berpihak pada keberlanjutan ekologis.',
                    ];
                @endphp

                <div class="grid gap-6">
                    @foreach ($missionItems as $index => $mission)
                        <div class="flex flex-col md:flex-row gap-4 md:gap-6 p-6 bg-[#F4F1EA] border-l-8 border-[#256D4A] border-y border-r border-[#1D1D1D]/10">
                            <div class="flex-shrink-0 w-12 h-12 bg-[#1D1D1D] flex justify-center items-center text-[#256D4A] text-2xl font-heading">
                                {{ $index + 1 }}
                            </div>
                            <div class="flex-1 text-[#1D1D1D] text-base md:text-lg leading-relaxed">
                                {{ $mission }}
                            </div>
                        </div>
                    @endforeach
                </div>
            </section>

            <!-- Nilai-Nilai Section -->
            <section class="bg-[#1D1D1D] border-4 border-[#1D1D1D] shadow-[8px_8px_0px_0px_#256D4A] p-8 md:p-12 text-[#F4F1EA]">
                <div class="text-center mb-12">
                    <span class="inline-block bg-[#256D4A] text-[#F4F1EA] font-bold text-xs uppercase tracking-widest px-4 py-2 mb-4">
                        Nilai-Nilai Kami
                    </span>
                    <h3 class="text-3xl md:text-4xl font-heading text-[#F4F1EA] uppercase tracking-wide">
                        Prinsip yang Menuntun Perjuangan
                    </h3>
                </div>

                <div class="grid md:grid-cols-2 gap-8">
                    <!-- Keberanian -->
                    <div class="bg-white border-4 border-[#F4F1EA] p-6 md:p-8 flex flex-col gap-4 text-[#1D1D1D] hover:shadow-[4px_4px_0px_0px_#D95C3F] transition-all">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 bg-[#1D1D1D] flex items-center justify-center text-[#256D4A]">
                                <i data-lucide="shield" class="w-6 h-6"></i>
                            </div>
                            <h4 class="text-2xl md:text-3xl font-heading uppercase tracking-wide text-[#1D1D1D]">
                                Keberanian
                            </h4>
                        </div>
                        <p class="text-sm md:text-base leading-relaxed text-[#1D1D1D]/80">
                            Berani mengambil sikap tegas terhadap ketidakadilan ekologis dan menantang kekuasaan yang merusak lingkungan.
                        </p>
                    </div>

                    <!-- Kritis -->
                    <div class="bg-white border-4 border-[#F4F1EA] p-6 md:p-8 flex flex-col gap-4 text-[#1D1D1D] hover:shadow-[4px_4px_0px_0px_#D95C3F] transition-all">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 bg-[#1D1D1D] flex items-center justify-center text-[#256D4A]">
                                <i data-lucide="eye" class="w-6 h-6"></i>
                            </div>
                            <h4 class="text-2xl md:text-3xl font-heading uppercase tracking-wide text-[#1D1D1D]">
                                Kritis
                            </h4>
                        </div>
                        <p class="text-sm md:text-base leading-relaxed text-[#1D1D1D]/80">
                            Menganalisis akar masalah lingkungan secara mendalam dan tidak menerima solusi yang superfisial.
                        </p>
                    </div>

                    <!-- Komunitas -->
                    <div class="bg-white border-4 border-[#F4F1EA] p-6 md:p-8 flex flex-col gap-4 text-[#1D1D1D] hover:shadow-[4px_4px_0px_0px_#D95C3F] transition-all">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 bg-[#1D1D1D] flex items-center justify-center text-[#256D4A]">
                                <i data-lucide="users" class="w-6 h-6"></i>
                            </div>
                            <h4 class="text-2xl md:text-3xl font-heading uppercase tracking-wide text-[#1D1D1D]">
                                Komunitas
                            </h4>
                        </div>
                        <p class="text-sm md:text-base leading-relaxed text-[#1D1D1D]/80">
                            Menempatkan masyarakat sebagai subjek perubahan dan memperkuat organisasi rakyat di garis depan.
                        </p>
                    </div>

                    <!-- Ekologis -->
                    <div class="bg-white border-4 border-[#F4F1EA] p-6 md:p-8 flex flex-col gap-4 text-[#1D1D1D] hover:shadow-[4px_4px_0px_0px_#D95C3F] transition-all">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 bg-[#1D1D1D] flex items-center justify-center text-[#256D4A]">
                                <i data-lucide="leaf" class="w-6 h-6"></i>
                            </div>
                            <h4 class="text-2xl md:text-3xl font-heading uppercase tracking-wide text-[#1D1D1D]">
                                Ekologis
                            </h4>
                        </div>
                        <p class="text-sm md:text-base leading-relaxed text-[#1D1D1D]/80">
                            Memahami bahwa krisis lingkungan terkait erat dengan sistem ekonomi-politik yang eksploitatif.
                        </p>
                    </div>
                </div>
            </section>

            <!-- Kontak Section -->
            <section id="kontak" class="bg-white border-4 border-[#1D1D1D] shadow-[8px_8px_0px_0px_#256D4A] p-8 md:p-12 scroll-mt-24">
                <div class="text-center mb-10">
                    <span class="inline-block bg-[#D95C3F] text-[#F4F1EA] font-bold text-xs uppercase tracking-widest px-4 py-2 mb-4">
                        Hubungi Kami
                    </span>
                    <h3 class="text-3xl md:text-4xl font-heading text-[#1D1D1D] uppercase tracking-wide">
                        Kantor Eksekutif Daerah WALHI Jabar
                    </h3>
                </div>

                <div class="grid md:grid-cols-2 gap-8">
                    <!-- Info Kontak -->
                    <div class="flex flex-col gap-6">
                        <div class="flex gap-4 items-start">
                            <div class="w-10 h-10 bg-[#1D1D1D] text-[#5C8D59] flex items-center justify-center shrink-0">
                                <i data-lucide="map-pin" class="w-5 h-5"></i>
                            </div>
                            <div>
                                <h4 class="font-bold text-[#1D1D1D] text-sm uppercase tracking-wider mb-1">Alamat Kantor</h4>
                                <p class="text-base text-[#1D1D1D]/80 leading-relaxed">{{ $globalContact->address }}</p>
                            </div>
                        </div>

                        <div class="flex gap-4 items-start">
                            <div class="w-10 h-10 bg-[#1D1D1D] text-[#5C8D59] flex items-center justify-center shrink-0">
                                <i data-lucide="mail" class="w-5 h-5"></i>
                            </div>
                            <div>
                                <h4 class="font-bold text-[#1D1D1D] text-sm uppercase tracking-wider mb-1">E-mail Resmi</h4>
                                <p class="text-base text-[#1D1D1D]/80"><a href="mailto:{{ $globalContact->email }}" class="hover:text-[#256D4A] underline">{{ $globalContact->email }}</a></p>
                            </div>
                        </div>

                        <div class="flex gap-4 items-start">
                            <div class="w-10 h-10 bg-[#1D1D1D] text-[#5C8D59] flex items-center justify-center shrink-0">
                                <i data-lucide="phone" class="w-5 h-5"></i>
                            </div>
                            <div>
                                <h4 class="font-bold text-[#1D1D1D] text-sm uppercase tracking-wider mb-1">WhatsApp Admin</h4>
                                <p class="text-base text-[#1D1D1D]/80"><a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $globalContact->whatsapp) }}" class="hover:text-[#256D4A] underline">{{ $globalContact->whatsapp }}</a></p>
                            </div>
                        </div>
                    </div>

                    <!-- Peta / Social Media -->
                    <div class="bg-[#F4F1EA] border-4 border-[#1D1D1D] p-6 flex flex-col justify-between gap-6">
                        <div>
                            <h4 class="font-heading text-2xl text-[#1D1D1D] uppercase tracking-wide mb-4">Media Sosial Resmi</h4>
                            <div class="grid grid-cols-2 gap-4 text-sm font-semibold">
                                <a href="{{ $globalContact->instagram }}" target="_blank" class="flex items-center gap-2 text-[#1D1D1D] hover:text-[#256D4A] transition-colors">
                                    <i data-lucide="instagram" class="w-4 h-4"></i> Instagram
                                </a>
                                <a href="{{ $globalContact->youtube }}" target="_blank" class="flex items-center gap-2 text-[#1D1D1D] hover:text-[#256D4A] transition-colors">
                                    <i data-lucide="youtube" class="w-4 h-4"></i> YouTube
                                </a>
                                <a href="{{ $globalContact->facebook }}" target="_blank" class="flex items-center gap-2 text-[#1D1D1D] hover:text-[#256D4A] transition-colors">
                                    <i data-lucide="facebook" class="w-4 h-4"></i> Facebook
                                </a>
                            </div>
                        </div>

                        <div class="border-t border-[#1D1D1D]/20 pt-4">
                            <p class="text-xs text-[#666] leading-relaxed">
                                Silakan hubungi kami untuk informasi kerja sama advokasi, laporan pelanggaran lingkungan, atau dukungan gerakan lingkungan hidup di Jawa Barat.
                            </p>
                        </div>
                    </div>
                </div>
            </section>

        </main>

        @include('partials.site-footer')

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                lucide.createIcons();
            });
        </script>
    </body>
</html>
