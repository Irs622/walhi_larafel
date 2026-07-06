<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        @include('partials.seo-meta')

        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Anton&family=Bebas+Neue&family=Inter:wght@400;500;600;700;800&family=Oswald:wght@400;500;600;700&display=swap" rel="stylesheet">

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="bg-brand-cream antialiased text-brand-dark overflow-x-hidden">
        @php
            $iqon = function (string $name): string {
                return asset('iqon/'.$name);
            };

            $socialLinks = [
                ['label' => 'Facebook', 'icon' => 'Icon-1.svg'],
                ['label' => 'Twitter', 'icon' => 'Icon-2.svg'],
                ['label' => 'Instagram', 'icon' => 'Icon-3.svg'],
            ];

            $mainNav = [
                ['label' => 'Beranda', 'href' => route('home'), 'active' => true],
                ['label' => 'Blog', 'href' => route('home').'#kabar'],
                ['label' => 'Regulasi', 'href' => route('home').'#isu'],
                ['label' => 'Publikasi', 'href' => route('home').'#kabar', 'dropdown' => true],
                ['label' => 'Dukung Kami', 'href' => route('home').'#donasi', 'dropdown' => true],
                ['label' => 'Tentang Kami', 'href' => route('about'), 'dropdown' => true],
            ];

            $issues = [
                ['title' => 'Pertambangan Ilegal', 'image' => 'causes-1-1.jpg', 'icon' => 'Icon-4.svg', 'badge' => '200+ Titik', 'badgeColor' => '#D95C3F', 'copy' => 'Ratusan titik tambang ilegal di Jawa Barat merusak hutan, air, dan ruang hidup masyarakat.'],
                ['title' => 'Deforestasi', 'image' => 'causes-1-2.jpg', 'icon' => 'Icon-5.svg', 'badge' => '15.000 Ha/Tahun', 'badgeColor' => '#8B6B4A', 'copy' => 'Alih fungsi hutan untuk perkebunan dan properti menggerus tutupan hijau dan memicu bencana ekologis.'],
                ['title' => 'Pencemaran Sungai', 'image' => 'causes-1-3.jpg', 'icon' => 'Icon-6.svg', 'badge' => '75% Tercemar', 'badgeColor' => '#256D4A', 'copy' => 'Limbah industri dan rumah tangga mencemari sungai-sungai utama serta mengancam kesehatan warga.'],
                ['title' => 'Konflik Agraria', 'image' => 'causes-1-4.jpg', 'icon' => 'Icon-7.svg', 'badge' => '2.500+ Kasus', 'badgeColor' => '#5C8D59', 'copy' => 'Ribuan keluarga petani kehilangan tanah akibat perampasan lahan dan proyek skala besar.'],
                ['title' => 'Krisis Iklim', 'image' => 'causes-1-5.jpg', 'icon' => 'Icon-8.svg', 'badge' => '+2.5°C Target', 'badgeColor' => '#D95C3F', 'copy' => 'Banjir bandang, kekeringan ekstrem, dan cuaca tak menentu semakin sering melanda Jawa Barat.'],
                ['title' => 'Krisis Iklim', 'image' => 'causes-1-6.jpg', 'icon' => 'Icon-9.svg', 'badge' => '+2.5°C Target', 'badgeColor' => '#D95C3F', 'copy' => 'Banjir bandang, kekeringan ekstrem, dan cuaca tak menentu semakin sering melanda Jawa Barat.'],
            ];

            $stats = [
                ['value' => '2,847', 'label' => 'Kasus Ditangani', 'icon' => 'Icon-10.svg', 'color' => '#256D4A'],
                ['value' => '15,000+', 'label' => 'Keluarga Terdampak', 'icon' => 'Icon-11.svg', 'color' => '#D95C3F'],
                ['value' => '85%', 'label' => 'Tingkat Keberhasilan', 'icon' => 'Icon-12.svg', 'color' => '#5C8D59'],
                ['value' => '150+', 'label' => 'Laporan Investigasi', 'icon' => 'Icon-13.svg', 'color' => '#8B6B4A'],
            ];

            $reports = [
                ['year' => '2025', 'title' => 'Laporan Tahunan: Krisis Lingkungan Jawa Barat', 'copy' => 'Analisis komprehensif kondisi lingkungan, kasus-kasus yang ditangani, dan rekomendasi kebijakan untuk tahun 2025.', 'meta' => ['124 Halaman', '2.4K Downloads'], 'button' => 'Download PDF', 'icon' => 'Icon-16.svg'],
                ['year' => '2025', 'title' => 'Investigasi: Jejak Tambang Ilegal di Kawasan Konservasi', 'copy' => 'Dokumentasi investigasi mendalam terhadap jaringan pertambangan ilegal yang merusak kawasan hutan lindung.', 'meta' => ['68 Halaman', '1.8K Downloads'], 'button' => 'Download PDF', 'icon' => 'Icon-16.svg'],
                ['year' => '2024', 'title' => 'Monitoring Kualitas Air Sungai Citarum', 'copy' => 'Data hasil monitoring bulanan kualitas air Sungai Citarum sepanjang 2024 dengan analisis dampak kesehatan.', 'meta' => ['42 Halaman', '3.1K Downloads'], 'button' => 'Download PDF', 'icon' => 'Icon-16.svg'],
            ];

            $featuredNews = ['image' => 'news-4-1.jpg', 'tag' => 'Investigasi', 'title' => 'Penelusuran Jejak Modal di Balik Tambang Ilegal Gunung Halimun', 'copy' => 'Investigasi mendalam mengungkap jaringan korporasi dan pejabat yang memfasilitasi pertambangan ilegal. Dokumen internal bocor, saksi kunci berbicara.', 'date' => '18 Mei 2026', 'read' => '12 menit'];

            $newsCards = [
                ['image' => 'news-1-1.jpg', 'tag' => 'Advokasi', 'title' => 'Petani Garut Menang: Tanah Dikembalikan Setelah 3 Tahun Gugatan', 'copy' => 'Putusan pengadilan memenangkan gugatan 300 keluarga petani. Ini kemenangan hukum penting untuk kasus-kasus agraria serupa di seluruh Jawa Barat.', 'date' => '15 Mei 2026', 'read' => '8 menit'],
                ['image' => 'news-1-2.jpg', 'tag' => 'Laporan', 'title' => 'Data Baru: Tingkat Pencemaran Citarum Naik 23% dalam 6 Bulan', 'copy' => 'Monitoring terbaru menunjukkan peningkatan drastis polusi industri. Pemerintah diminta bertindak cepat sebelum kondisi semakin memburuk.', 'date' => '10 Mei 2026', 'read' => '6 menit'],
                ['image' => 'news-1-3.jpg', 'tag' => 'Kampanye', 'title' => 'Ratusan Aktivis Turun ke Jalan Tolak Pembangunan Pabrik di DAS', 'copy' => 'Aksi bersama menolak izin pembangunan pabrik semen di kawasan penyangga Daerah Aliran Sungai. Massa menuntut pencabutan izin lingkungan.', 'date' => '5 Mei 2026', 'read' => '5 menit'],
                ['image' => 'news-4-2.jpg', 'tag' => 'Pendidikan', 'title' => 'Peluncuran Sekolah Lapang: Petani Belajar Pertanian Ekologis', 'copy' => 'Program pendampingan petani untuk transisi dari metode konvensional ke pertanian ramah lingkungan. Hasil panen meningkat tanpa merusak tanah.', 'date' => '1 Mei 2026', 'read' => '7 menit'],
                ['image' => 'news-4-3.jpg', 'tag' => 'Opini', 'title' => "Mengapa Kita Harus Menolak 'Green Capitalism' dalam Krisis Iklim", 'copy' => 'Analisis kritis terhadap solusi pasar dalam menghadapi krisis ekologis. Apa yang dibutuhkan adalah transformasi sistem, bukan sekadar greenwashing.', 'date' => '28 Apr 2026', 'read' => '10 menit'],
                ['image' => 'news-2-1.jpg', 'tag' => 'Opini', 'title' => "Mengapa Kita Harus Menolak 'Green Capitalism' dalam Krisis Iklim", 'copy' => 'Analisis kritis terhadap solusi pasar dalam menghadapi krisis ekologis. Apa yang dibutuhkan adalah transformasi sistem, bukan sekadar greenwashing.', 'date' => '28 Apr 2026', 'read' => '10 menit'],
            ];
        @endphp

        @include('partials.site-header')

        <main class="w-full">
            <!-- Hero Section -->
            <section class="relative min-h-[600px] md:h-[836px] w-full overflow-hidden bg-brand-dark text-brand-cream flex items-center py-20 px-6 sm:px-12 md:px-24">
                <div class="absolute inset-0 bg-cover bg-center" style="background-image: url('{{ asset('iqon/Container.png') }}');"></div>
                <div class="absolute inset-0 bg-[linear-gradient(180deg,rgba(29,29,29,0.70)_0%,rgba(29,29,29,0.50)_50%,rgba(29,29,29,0.80)_100%)]"></div>
                <div class="relative w-full max-w-6xl mx-auto z-10 flex flex-col gap-6 md:gap-8 items-start">
                    <!-- Main Heading -->
                    <h1 class="text-4xl sm:text-6xl md:text-7xl lg:text-8xl font-heading uppercase leading-none tracking-wide text-brand-cream">
                        PULIHKAN JAWA BARAT<br>
                        BERSAMA WALHI JABAR
                    </h1>
                    <!-- Divider Orange -->
                    <div class="w-32 sm:w-64 md:w-[578px] h-2 bg-brand-orange"></div>
                    <!-- Subheading -->
                    <h2 class="text-2xl sm:text-3xl md:text-4xl lg:text-5xl font-label uppercase leading-tight tracking-wider text-brand-green-light">
                        SUARA MASYARAKAT<br>
                        HARUS DIDENGAR
                    </h2>
                    <!-- Buttons -->
                    <div class="flex flex-col sm:flex-row gap-4 w-full sm:w-auto">
                        <a href="{{ route('blog') }}" class="flex h-[60px] sm:w-[208px] px-6 items-center justify-center border-2 border-brand-cream bg-brand-dark text-[16px] font-bold uppercase tracking-[0.40px] text-brand-cream hover:bg-brand-cream hover:text-brand-dark transition-colors">
                            lihat blog
                        </a>
                        <a href="{{ route('siaran-pers') }}" class="flex h-[60px] sm:w-[227px] px-6 items-center justify-center border-2 border-brand-orange bg-brand-orange text-[16px] font-bold uppercase tracking-[0.40px] text-brand-cream hover:bg-transparent hover:text-brand-orange transition-colors">
                            lihat publikasi
                        </a>
                    </div>
                </div>
                <div class="absolute bottom-8 left-1/2 -translate-x-1/2 hidden md:flex flex-col items-center gap-2 text-[12px] font-semibold uppercase tracking-[0.1em] text-brand-cream">
                    <span>Scroll</span>
                    <span class="h-10 w-px bg-brand-cream"></span>
                </div>
            </section>

            <!-- Tentang Kami Section -->
            <section id="tentang" class="w-full border-b-4 border-brand-dark bg-brand-cream py-16 md:py-24 px-6 sm:px-12 md:px-24">
                <div class="max-w-6xl mx-auto grid grid-cols-1 lg:grid-cols-12 gap-12 items-start">
                    <!-- Left Side: Deskripsi -->
                    <div class="lg:col-span-6 flex flex-col items-start gap-6">
                        <div class="flex h-[26px] items-center bg-brand-green px-4 text-[12px] font-bold uppercase tracking-[0.06em] text-brand-cream">Tentang Kami</div>
                        <h2 class="text-4xl sm:text-5xl lg:text-6xl font-heading uppercase leading-none tracking-wide text-brand-dark">
                            Melawan untuk<br>
                            Keadilan Ekologis
                        </h2>
                        <div class="h-1 w-24 bg-brand-orange"></div>
                        <div class="flex flex-col gap-4 text-base md:text-lg leading-relaxed text-brand-dark font-sans">
                             @if(!empty($sejarah))
                                 <div style="white-space: pre-line;">{!! $sejarah->body !!}</div>
                             @else
                                 <p><strong>WALHI Jawa Barat</strong> adalah organisasi lingkungan hidup independen yang berjuang untuk keadilan ekologis dan kedaulatan rakyat atas sumber daya alam.</p>
                                 <p>Kami mendampingi masyarakat yang terdampak oleh kerusakan lingkungan, mengadvokasi kebijakan yang berpihak pada keberlanjutan, dan mengkampanyekan penghentian eksploitasi alam yang merusak.</p>
                                 <p>Sejak berdiri, WALHI Jawa Barat telah menangani ratusan kasus konflik agraria dan kerusakan lingkungan seperti pertambangan ilegal, deforestasi, pencemaran sungai, hingga dampak krisis iklim.</p>
                             @endif
                        </div>
                    </div>

                    <!-- Right Side: Misi & Struktur Cards -->
                    <div class="lg:col-span-6 flex flex-col gap-6 w-full">
                        <!-- Card 1 -->
                        <div class="flex flex-col gap-3 border-2 border-brand-dark bg-brand-dark p-6 md:p-8 text-brand-cream shadow-[4px_4px_0px_0px_#256D4A]">
                            <div class="text-[24px] font-label uppercase leading-tight tracking-[0.06em] text-brand-green-light">Misi Kami</div>
                            <p class="text-sm md:text-base leading-relaxed text-brand-cream/90">Mengorganisir masyarakat, melakukan riset & advokasi kebijakan, membangun gerakan solidaritas rakyat, serta mendorong tata kelola alam yang adil dan demokratis.</p>
                            <a href="{{ route('about') }}" class="mt-2 inline-flex items-center gap-2 text-[14px] font-bold uppercase tracking-[0.04em] text-brand-orange hover:text-brand-cream transition-colors">
                                <span>Selengkapnya visi & misi</span>
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
                            </a>
                        </div>
                        <!-- Card 2 -->
                        <div class="flex flex-col gap-3 border-2 border-brand-dark bg-brand-green p-6 md:p-8 text-brand-cream shadow-[4px_4px_0px_0px_#1D1D1D]">
                            <div class="text-[24px] font-label uppercase leading-tight tracking-[0.06em] text-brand-cream">Struktur Organisasi</div>
                            <p class="text-sm md:text-base leading-relaxed text-brand-cream/90">WALHI Jawa Barat dijalankan secara demokratis oleh Eksekutif Daerah yang diawasi oleh Dewan Daerah, serta didukung oleh lembaga anggota dan simpatisan di seluruh Jawa Barat.</p>
                            <a href="{{ route('about') }}" class="mt-2 inline-flex items-center gap-2 text-[14px] font-bold uppercase tracking-[0.04em] text-brand-orange hover:text-brand-cream transition-colors">
                                <span>Lihat struktur kami</span>
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
                            </a>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Isu Kritis Section -->
            <section id="isu" class="w-full bg-brand-dark py-16 md:py-24 px-6 sm:px-12 md:px-24 text-brand-cream">
                <div class="max-w-6xl mx-auto flex flex-col gap-16">
                    <div class="flex flex-col items-center text-center gap-4 w-full">
                        <div class="bg-brand-orange px-4 py-1.5 text-[12px] font-bold uppercase tracking-[0.06em] text-brand-cream">Isu Kritis</div>
                        <h2 class="text-4xl sm:text-5xl lg:text-6xl font-heading font-normal uppercase leading-tight tracking-[0.02em] text-brand-cream text-center">
                            Krisis Lingkungan<br>
                            Jawa Barat
                        </h2>
                        <div class="h-1 w-24 bg-brand-green-light"></div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 w-full">
                        @foreach ($issues as $issue)
                            <article class="flex flex-col overflow-hidden border-4 border-brand-cream bg-white text-brand-dark shadow-[4px_4px_0px_0px_#D95C3F]">
                                <div class="relative h-[192px] overflow-hidden bg-cover bg-center" style="background-image: url('{{ asset('assets/images/resources/'.$issue['image']) }}');">
                                    <div class="absolute left-4 top-4 flex h-[50px] items-center border-2 border-brand-cream bg-brand-dark px-4 text-[20px] font-label uppercase leading-tight tracking-[0.05em]" style="color: {{ $issue['badgeColor'] }};">
                                        {{ $issue['badge'] }}
                                    </div>
                                </div>
                                <div class="flex flex-grow flex-col gap-4 px-6 py-6 justify-between">
                                    <div class="flex flex-col gap-3">
                                        <div class="flex items-center gap-3">
                                            <div class="flex h-10 w-10 items-center justify-center bg-brand-dark p-2 flex-shrink-0">
                                                <img src="{{ $iqon($issue['icon']) }}" alt="{{ $issue['title'] }}" class="h-6 w-6 object-contain">
                                            </div>
                                            <h3 class="text-[24px] font-label uppercase leading-none tracking-[0.06em] text-brand-dark">{{ $issue['title'] }}</h3>
                                        </div>
                                        <p class="text-sm md:text-base leading-relaxed text-brand-dark/95 font-sans">{{ $issue['copy'] }}</p>
                                    </div>
                                </div>
                            </article>
                        @endforeach
                    </div>
                </div>
            </section>

            <!-- Data & Laporan Section -->
            <section class="w-full bg-brand-dark py-16 md:py-24 px-6 sm:px-12 md:px-24 text-brand-cream border-t border-brand-cream/10">
                <div class="max-w-6xl mx-auto flex flex-col gap-16">
                    <div class="flex flex-col items-center text-center gap-4 w-full">
                        <div class="bg-brand-green px-4 py-1.5 text-[12px] font-bold uppercase tracking-[0.06em] text-brand-cream">Data & Laporan</div>
                        <h2 class="text-4xl sm:text-5xl lg:text-6xl font-heading font-normal uppercase leading-tight tracking-[0.02em] text-brand-cream text-center">
                            Fakta dan Bukti<br>
                            Kerusakan Lingkungan
                        </h2>
                        <div class="h-1 w-24 bg-brand-orange"></div>
                    </div>

                    <!-- Stats Grid -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 w-full">
                        @foreach ($stats as $stat)
                            <div class="bg-white border-4 border-brand-cream p-6 flex flex-col items-center justify-center gap-4 text-center shadow-[4px_4px_0px_0px_#256D4A]">
                                <div class="flex h-14 w-14 items-center justify-center bg-brand-dark p-3">
                                    <img src="{{ $iqon($stat['icon']) }}" alt="{{ $stat['label'] }}" class="h-8 w-8 object-contain">
                                </div>
                                <div class="text-4xl sm:text-5xl font-heading leading-none" style="color: {{ $stat['color'] }};">{{ $stat['value'] }}</div>
                                <div class="text-sm font-semibold uppercase tracking-wider text-brand-dark font-sans">{{ $stat['label'] }}</div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Reports list -->
                    <div class="flex w-full flex-col gap-6">
                        @foreach ($reports as $report)
                            @php
                                if ($report instanceof \App\Models\Content) {
                                    $bodyData = json_decode($report->body, true);
                                    $reportYear = $report->publish_date ? \Carbon\Carbon::parse($report->publish_date)->format('Y') : '2025';
                                    $reportTitle = $report->title;
                                    $reportCopy = $bodyData['subtitle'] ?? $report->body;
                                    $reportPages = $bodyData['pages'] ?? '156 Halaman';
                                    $reportDownloads = $bodyData['downloads'] ?? '3.2K Downloads';
                                    $reportUrl = route('content.show', $report->slug);
                                } else {
                                    $reportYear = $report['year'];
                                    $reportTitle = $report['title'];
                                    $reportCopy = $report['copy'];
                                    $reportPages = $report['meta'][0];
                                    $reportDownloads = $report['meta'][1];
                                    $reportUrl = '#';
                                }
                            @endphp
                            <article class="flex flex-col md:flex-row overflow-hidden border-4 border-brand-cream bg-brand-cream text-brand-dark shadow-[4px_4px_0px_0px_#1D1D1D]">
                                <!-- Year Block -->
                                <div class="flex w-full md:w-32 md:flex-col justify-between md:justify-start items-center md:items-start bg-brand-green p-4 md:p-6 text-brand-cream">
                                    <div class="text-[12px] font-bold uppercase tracking-[0.06em]">Tahun</div>
                                    <div class="text-2xl md:text-4xl font-label leading-none tracking-widest md:pt-1">{{ $reportYear }}</div>
                                </div>
                                <!-- Content Block -->
                                <div class="flex flex-col md:flex-row flex-1 items-start md:items-center justify-between gap-6 p-6">
                                    <div class="flex flex-col gap-3 max-w-2xl">
                                        <div class="text-xl md:text-2xl font-label uppercase tracking-[0.06em] text-brand-dark leading-tight">{{ $reportTitle }}</div>
                                        <p class="text-sm md:text-base leading-relaxed text-brand-dark font-sans">{{ $reportCopy }}</p>
                                        <div class="flex items-center gap-4 text-xs md:text-sm font-semibold text-brand-green-light">
                                            <span>▪ {{ $reportPages }}</span>
                                            <span>▪ {{ $reportDownloads }}</span>
                                        </div>
                                    </div>
                                    <a href="{{ $reportUrl }}" class="flex h-[49px] items-center justify-center gap-2 border-2 border-brand-dark bg-brand-dark px-6 text-sm font-bold uppercase tracking-wider text-brand-cream w-full md:w-auto hover:bg-brand-cream hover:text-brand-dark transition-colors whitespace-nowrap">
                                        <img src="{{ $iqon('Icon-16.svg') }}" alt="Download" class="h-[18px] w-[18px] object-contain">
                                        <span>Lihat Laporan</span>
                                    </a>
                                </div>
                            </article>
                        @endforeach
                    </div>
                </div>
            </section>

            <!-- Kabar (Liputan & Investigasi) Section -->
            <section id="kabar" class="w-full border-b-4 border-brand-dark bg-brand-cream py-16 md:py-24 px-6 sm:px-12 md:px-24 text-brand-dark">
                <div class="max-w-6xl mx-auto flex flex-col gap-12">
                    <!-- Header Block -->
                    <div class="w-full flex flex-col md:flex-row md:items-end justify-between gap-6 pb-8 border-b-2 border-brand-green">
                        <div class="flex flex-col items-start gap-4">
                            <div class="bg-brand-orange px-4 py-1.5 text-[12px] font-bold uppercase tracking-[0.06em] text-brand-cream">Berita & Artikel</div>
                            <h2 class="text-4xl sm:text-5xl lg:text-6xl font-heading font-normal uppercase leading-tight tracking-[0.02em] text-brand-dark">Liputan dan<br>Investigasi</h2>
                        </div>
                        <a href="{{ route('blog') }}" class="flex h-[49px] items-center justify-center gap-2 border-2 border-brand-dark bg-brand-dark px-6 text-sm font-bold uppercase tracking-wider text-brand-cream hover:bg-transparent hover:text-brand-dark transition-colors whitespace-nowrap">
                            <span>Lihat Semua Artikel</span>
                            <img src="{{ $iqon('Icon-17.svg') }}" alt="Arrow" class="h-[18px] w-[18px] object-contain">
                        </a>
                    </div>

                    <!-- Featured Article -->
                    @if($featuredNews)
                        @php
                            if ($featuredNews instanceof \App\Models\Content) {
                                $featImage = $featuredNews->image_url ?: asset('assets/images/blog/news-4-1.jpg');
                                $featTag = array_map('trim', explode(',', $featuredNews->tags ?? ''))[0] ?? 'Liputan';
                                $featTitle = $featuredNews->title;
                                $featCopy = Str::limit(strip_tags($featuredNews->body), 200);
                                $featDate = $featuredNews->publish_date ? \Carbon\Carbon::parse($featuredNews->publish_date)->translatedFormat('d M Y') : $featuredNews->created_at->translatedFormat('d M Y');
                                $wordCount = str_word_count(strip_tags($featuredNews->body));
                                $featRead = ceil($wordCount / 200) . ' menit';
                                $featUrl = route('content.show', $featuredNews->slug);
                            } else {
                                $featImage = asset('assets/images/blog/' . $featuredNews['image']);
                                $featTag = $featuredNews['tag'];
                                $featTitle = $featuredNews['title'];
                                $featCopy = $featuredNews['copy'];
                                $featDate = $featuredNews['date'];
                                $featRead = $featuredNews['read'];
                                $featUrl = '#';
                            }
                        @endphp
                        <article class="flex flex-col lg:flex-row w-full overflow-hidden border-4 border-brand-dark bg-white shadow-[8px_8px_0px_0px_#256D4A]">
                            <!-- Featured Image -->
                            <div class="relative min-h-[280px] lg:w-1/2 overflow-hidden bg-cover bg-center" style="background-image: url('{{ $featImage }}');">
                                <div class="absolute left-4 top-4 bg-brand-orange px-4 py-2 text-[12px] font-bold uppercase tracking-[0.06em] text-brand-cream">{{ $featTag }}</div>
                            </div>
                            <!-- Featured Content -->
                            <div class="flex lg:w-1/2 flex-col justify-between p-6 md:p-8 text-brand-dark gap-6">
                                <div class="flex flex-col gap-4">
                                    <h3 class="text-2xl md:text-3xl lg:text-4xl font-label uppercase leading-tight tracking-[0.05em] text-brand-dark">{{ $featTitle }}</h3>
                                    <p class="text-sm md:text-base leading-relaxed text-brand-dark/80 font-sans">{{ $featCopy }}</p>
                                </div>
                                <div class="flex flex-wrap items-center justify-between border-t-2 border-brand-dark pt-6 text-[14px] font-semibold leading-[20px] text-brand-green-light gap-4">
                                    <div class="flex items-center gap-4">
                                        <span>{{ $featDate }}</span>
                                        <span>▪ {{ $featRead }}</span>
                                    </div>
                                    <a href="{{ $featUrl }}" class="flex items-center gap-2 text-brand-dark font-bold hover:text-brand-green transition-colors">
                                        <span>Baca Selengkapnya</span>
                                        <img src="{{ $iqon('Icon-18.svg') }}" alt="Detail" class="h-[18px] w-[18px] object-contain">
                                    </a>
                                </div>
                            </div>
                        </article>
                    @endif

                    <!-- News Cards Grid -->
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 w-full mt-6">
                        @foreach ($newsCards as $news)
                            @php
                                if ($news instanceof \App\Models\Content) {
                                    $newsImage = $news->image_url ?: asset('assets/images/blog/news-1-1.jpg');
                                    $newsTag = array_map('trim', explode(',', $news->tags ?? ''))[0] ?? 'Advokasi';
                                    $newsTitle = $news->title;
                                    $newsCopy = Str::limit(strip_tags($news->body), 120);
                                    $newsDate = $news->publish_date ? \Carbon\Carbon::parse($news->publish_date)->translatedFormat('d M Y') : $news->created_at->translatedFormat('d M Y');
                                    $wordCount = str_word_count(strip_tags($news->body));
                                    $newsRead = ceil($wordCount / 200) . ' menit';
                                    $newsUrl = route('content.show', $news->slug);
                                } else {
                                    $newsImage = asset('assets/images/blog/' . $news['image']);
                                    $newsTag = $news['tag'];
                                    $newsTitle = $news['title'];
                                    $newsCopy = $news['copy'];
                                    $newsDate = $news['date'];
                                    $newsRead = $news['read'];
                                    $newsUrl = '#';
                                }
                            @endphp
                            <article class="flex flex-col overflow-hidden border-4 border-brand-dark bg-white shadow-[4px_4px_0px_0px_#1D1D1D]">
                                <div class="relative h-[192px] overflow-hidden bg-cover bg-center" style="background-image: url('{{ $newsImage }}');">
                                    <div class="absolute left-4 top-4 px-3 py-1 text-[12px] font-bold uppercase tracking-[0.06em] text-brand-cream" style="background-color: {{ $loop->index % 3 === 2 ? '#8B6B4A' : ($loop->index % 3 === 1 ? '#5C8D59' : '#256D4A') }};">{{ $newsTag }}</div>
                                </div>
                                <div class="flex flex-1 flex-col justify-between px-6 py-6 text-brand-dark gap-6">
                                    <div class="flex flex-col gap-4">
                                        <a href="{{ $newsUrl }}" class="hover:text-brand-green transition-colors">
                                            <h4 class="text-[20px] font-label uppercase leading-tight tracking-[0.05em] text-brand-dark hover:underline">{{ $newsTitle }}</h4>
                                        </a>
                                        <p class="text-sm leading-relaxed text-brand-dark/90 font-sans">{{ $newsCopy }}</p>
                                    </div>
                                    <div class="flex items-center gap-3 border-t border-brand-dark/20 pt-4 text-[12px] font-semibold leading-[16px] text-brand-green-light font-sans">
                                        <span>{{ $newsDate }}</span>
                                        <span>▪</span>
                                        <span>{{ $newsRead }}</span>
                                    </div>
                                </div>
                            </article>
                        @endforeach
                    </div>
                </div>
            </section>

            <!-- Donasi Section -->
            <section id="donasi" class="relative w-full overflow-hidden bg-brand-green py-16 md:py-24 px-6 sm:px-12 md:px-24">
                <div class="absolute inset-0 bg-cover bg-center opacity-10" style="background-image: url('{{ asset('assets/images/backgrounds/call-to-action-bg.jpg') }}');"></div>
                <div class="relative max-w-6xl mx-auto flex flex-col gap-16 z-10">
                    <div class="flex flex-col items-center text-center gap-4 w-full">
                        <h2 class="text-4xl sm:text-6xl md:text-7xl font-heading font-normal uppercase leading-tight tracking-[0.02em] text-brand-cream">
                            Gerakan Ini<br>
                            Butuh Kamu
                        </h2>
                        <div class="mx-auto h-2 w-32 bg-brand-orange"></div>
                        <p class="mx-auto max-w-[768px] text-base md:text-xl leading-relaxed text-brand-cream font-sans">Perubahan tidak terjadi dengan sendirinya. Setiap gerakan dimulai dari keberanian untuk bertindak. Bergabunglah dengan ribuan aktivis lain yang memperjuangkan keadilan ekologis.</p>
                        <div class="text-xs md:text-sm font-bold uppercase tracking-[0.07em] text-brand-green-light">Keadilan untuk bumi, keadilan untuk rakyat</div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 w-full">
                        <!-- Card Relawan -->
                        <section class="flex flex-col justify-between border-4 border-brand-cream bg-brand-dark p-6 md:p-8 text-brand-cream shadow-[8px_8px_0px_0px_#1D1D1D]">
                            <div class="flex flex-col gap-6">
                                <div class="flex items-center gap-4">
                                    <div class="flex h-14 w-14 items-center justify-center bg-brand-green p-3 flex-shrink-0">
                                        <img src="{{ $iqon('Icon-19.svg') }}" alt="Relawan" class="h-8 w-8 object-contain">
                                    </div>
                                    <h3 class="text-2xl md:text-3xl font-label uppercase leading-none tracking-[0.05em]">Jadi Relawan</h3>
                                </div>
                                <p class="text-sm md:text-base leading-relaxed font-sans">Terlibat langsung dalam pendampingan masyarakat, investigasi lapangan, kampanye, dan aksi-aksi lingkungan. Tidak perlu pengalaman, yang penting ada komitmen.</p>
                                <ul class="flex flex-col gap-2 text-sm md:text-base font-semibold font-sans">
                                    <li>▪ Pelatihan advokasi lingkungan</li>
                                    <li>▪ Jaringan aktivis se-Jawa Barat</li>
                                    <li>▪ Pengalaman kerja lapangan</li>
                                </ul>
                            </div>
                            <a href="https://wa.me/6281234567890" target="_blank" class="mt-8 flex h-[60px] items-center justify-center gap-2 bg-brand-green hover:bg-brand-green-light transition-colors px-6 text-[16px] font-bold uppercase tracking-[0.04em] text-brand-cream">
                                <img src="{{ $iqon('Icon-20.svg') }}" alt="Relawan" class="h-5 w-5 object-contain">
                                <span>Daftar Jadi Relawan</span>
                            </a>
                        </section>

                        <!-- Card Dukung Gerakan -->
                        <section class="flex flex-col justify-between border-4 border-brand-cream bg-brand-cream p-6 md:p-8 text-brand-dark shadow-[8px_8px_0px_0px_#256D4A]">
                            <div class="flex flex-col gap-6">
                                <div class="flex items-center gap-4">
                                    <div class="flex h-14 w-14 items-center justify-center bg-brand-orange p-3 flex-shrink-0">
                                        <img src="{{ $iqon('Icon-21.svg') }}" alt="Dukungan" class="h-8 w-8 object-contain">
                                    </div>
                                    <h3 class="text-2xl md:text-3xl font-label uppercase leading-none tracking-[0.05em] text-brand-dark">Dukung Gerakan</h3>
                                </div>
                                <p class="text-sm md:text-base leading-relaxed font-sans">Setiap kontribusi membantu mendanai investigasi, pendampingan hukum, kampanye, dan operasional organisasi. Kami 100% independen dari korporasi dan pemerintah.</p>
                                <div class="flex flex-col gap-2 border-2 border-brand-dark bg-brand-cream p-4">
                                    <div class="text-[12px] font-bold uppercase tracking-[0.06em] text-brand-green-light">Donasi digunakan untuk:</div>
                                    <ul class="flex flex-col gap-1 text-xs md:text-sm font-semibold font-sans">
                                        <li>▪ Pendampingan hukum masyarakat</li>
                                        <li>▪ Investigasi dan riset</li>
                                        <li>▪ Kampanye dan edukasi publik</li>
                                    </ul>
                                </div>
                            </div>
                            <a href="{{ route('donasi') }}" class="mt-8 flex h-[60px] items-center justify-center gap-2 bg-brand-orange hover:bg-brand-orange/80 transition-colors px-6 text-[16px] font-bold uppercase tracking-[0.04em] text-brand-cream">
                                <img src="{{ $iqon('Icon-22.svg') }}" alt="Donasi" class="h-5 w-5 object-contain">
                                <span>Donasi Sekarang</span>
                            </a>
                        </section>
                    </div>

                    <!-- Kontak & Hubungi Kami -->
                    <div class="w-full flex flex-col gap-8 border-4 border-brand-cream bg-brand-dark p-6 md:p-8 text-brand-cream shadow-[8px_8px_0px_0px_#1D1D1D] mt-8">
                        <div class="flex flex-col gap-4 text-center max-w-3xl mx-auto">
                            <h3 class="text-2xl md:text-3xl font-label uppercase tracking-[0.05em]">Hubungi Kami</h3>
                            <p class="text-sm md:text-base leading-relaxed font-sans">Punya pertanyaan? Ingin melaporkan kasus? Atau sekadar ingin berdiskusi tentang isu lingkungan? Kontak kami.</p>
                        </div>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 w-full max-w-4xl mx-auto">
                            <div class="flex flex-col sm:flex-row items-center gap-4 border-2 border-brand-green bg-brand-green p-6 shadow-[4px_4px_0px_0px_#1D1D1D]">
                                <div class="flex h-10 w-10 items-center justify-center bg-brand-dark p-2 flex-shrink-0">
                                    <img src="{{ $iqon('Icon-23.svg') }}" alt="Email" class="h-6 w-6 object-contain">
                                </div>
                                <div class="text-center sm:text-left">
                                    <div class="text-[12px] font-bold uppercase tracking-[0.06em] text-brand-green-light">Email</div>
                                    <div class="text-sm md:text-base font-semibold text-brand-cream font-sans break-all">walhijabar@gmail.com</div>
                                </div>
                            </div>
                            <div class="flex flex-col sm:flex-row items-center gap-4 border-2 border-brand-green bg-brand-green p-6 shadow-[4px_4px_0px_0px_#1D1D1D]">
                                <div class="flex h-10 w-10 items-center justify-center bg-brand-dark p-2 flex-shrink-0">
                                    <img src="{{ $iqon('Icon-24.svg') }}" alt="WhatsApp" class="h-6 w-6 object-contain">
                                </div>
                                <div class="text-center sm:text-left">
                                    <div class="text-[12px] font-bold uppercase tracking-[0.06em] text-brand-green-light">WhatsApp</div>
                                    <div class="text-sm md:text-base font-semibold text-brand-cream font-sans">+62 821-1982-1159</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            @include('partials.site-footer')
        </main>
    </body>
</html>