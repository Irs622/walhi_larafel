<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        @include('partials.seo-meta')
 
        <script>
            function updateScale() {
                const viewportWidth = window.innerWidth;
                const targetWidth = 1470;
                if (viewportWidth < targetWidth) {
                    const scale = viewportWidth / targetWidth;
                    document.documentElement.style.setProperty('--canvas-scale', scale);
                } else {
                    document.documentElement.style.setProperty('--canvas-scale', 1);
                }
            }
            window.addEventListener('resize', updateScale);
            updateScale();
        </script>
 
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Anton&family=Bebas+Neue&family=Inter:wght@400;500;600;700;800&family=Oswald:wght@400;500;600;700&display=swap" rel="stylesheet">
 
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="overflow-x-clip bg-brand-cream antialiased text-brand-dark">
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

        <div style="position: relative; width: 100%; height: calc(8079px * var(--canvas-scale, 1)); overflow-x: clip; background: #F4F1EA;">
            <div style="position: absolute; left: 0; top: 0; width: 1470px; height: 8079px; transform: scale(var(--canvas-scale, 1)); transform-origin: top left;">
                @include('partials.site-header')

                <main class="w-full">
                <section class="relative h-[836px] w-full overflow-hidden bg-brand-dark text-brand-cream">
                    <div class="absolute inset-0 bg-cover bg-center" style="background-image: url('{{ asset('iqon/Container.png') }}');"></div>
                    <div class="absolute inset-0 bg-[linear-gradient(180deg,rgba(29,29,29,0.70)_0%,rgba(29,29,29,0.50)_50%,rgba(29,29,29,0.80)_100%)]"></div>
                    <div class="relative mx-auto flex h-full w-[1470px] items-center px-[95px]">
                        <div class="flex h-[450.39px] w-full flex-col items-start pl-8 pr-[352px]">
                            <div class="relative w-full h-[450.39px]">
                                <!-- Main Heading -->
                                <div class="absolute left-0 top-[0.20px] w-[1100px] h-[173px]">
                                    <h1 class="absolute left-0 top-[-0.50px] text-[96px] font-heading font-normal uppercase leading-[86.40px] tracking-[0.02em] text-brand-cream">
                                        PULIHKAN JAWA BARAT<br>
                                        BERSAMA WALHI JABAR
                                    </h1>
                                </div>
                                <!-- Divider Orange -->
                                <div class="absolute left-0 top-[197.20px] w-[578px] h-2 bg-brand-orange"></div>
                                <!-- Subheading -->
                                <div class="absolute left-0 top-[236.80px] w-[896px] h-[105.59px]">
                                    <h2 class="absolute left-0 top-[-0.50px] text-[48px] font-label font-normal uppercase leading-[52.80px] tracking-[0.05em] text-brand-green-light">
                                        SUARA MASYARAKAT<br>
                                        HARUS DIDENGAR
                                    </h2>
                                </div>
                                <!-- Buttons -->
                                <div class="absolute left-0 top-[390.20px] flex w-[455px] h-[60px] gap-4">
                                    <a href="{{ route('blog') }}" class="relative flex w-[208.76px] h-[60px] items-center justify-center border-2 border-brand-cream bg-brand-dark text-[16px] font-bold uppercase tracking-[0.40px] text-brand-cream">
                                        lihat blog
                                    </a>
                                    <a href="{{ route('siaran-pers') }}" class="relative flex w-[227.18px] h-[60px] items-center justify-center border-2 border-brand-orange bg-brand-orange text-[16px] font-bold uppercase tracking-[0.40px] text-brand-cream">
                                        lihat publikasi
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="absolute left-1/2 top-[730px] flex -translate-x-1/2 flex-col items-center gap-2 text-[12px] font-semibold uppercase tracking-[0.1em] text-brand-cream">
                        <span>Scroll</span>
                        <span class="h-10 w-px bg-brand-cream"></span>
                    </div>
                </section>

                <section id="tentang" class="flex h-[718.83px] w-full flex-col items-start border-b-4 border-brand-dark bg-brand-cream px-[95px] pb-1 pt-20">
                    <div class="mx-auto flex h-[554.83px] w-[1280px] flex-col items-start px-8">
                        <div class="relative h-full w-full">
                            <div class="absolute left-0 top-0.5 flex h-[26px] items-center bg-brand-green px-4 text-[12px] font-bold uppercase tracking-[0.06em] text-brand-cream">Tentang Kami</div>
                            <h2 class="absolute left-0 top-[50px] text-[56px] font-heading font-normal uppercase leading-[53.2px] tracking-[0.02em] text-brand-dark">
                                Melawan untuk<br>
                                Keadilan Ekologis
                            </h2>
                            <div class="absolute left-0 top-[180.89px] h-1 w-24 bg-brand-orange"></div>
                            <div class="absolute left-0 top-[216.89px] flex w-[584px] flex-col gap-4 text-[18px] leading-[30.6px] text-brand-dark">
                                <p><strong>WALHI Jawa Barat</strong> adalah organisasi lingkungan hidup independen yang berjuang untuk keadilan ekologis dan kedaulatan rakyat atas sumber daya alam.</p>
                                <p>Kami mendampingi masyarakat yang terdampak oleh kerusakan lingkungan, mengadvokasi kebijakan yang berpihak pada keberlanjutan, dan mengkampanyekan penghentian eksploitasi alam yang merusak.</p>
                                <p>Sejak berdiri, WALHI Jawa Barat telah menangani ratusan kasus konflik agraria dan kerusakan lingkungan seperti pertambangan ilegal, deforestasi, pencemaran sungai, hingga dampak krisis iklim.</p>
                            </div>

                            <div class="absolute left-[632px] top-[30px] flex w-[584px] flex-col gap-6">
                                <div class="flex min-h-[254px] flex-col gap-3 border-2 border-brand-dark bg-brand-dark p-[26px] text-brand-cream">
                                    <div class="text-[24px] font-label uppercase leading-[36px] tracking-[0.06em] text-brand-green-light">Misi Kami</div>
                                    <ul class="flex flex-col gap-3 text-[16px] leading-[25.6px]">
                                        <li><span class="mr-3 text-brand-orange">▪</span>Mendampingi masyarakat korban kerusakan lingkungan</li>
                                        <li><span class="mr-3 text-brand-orange">▪</span>Mengadvokasi kebijakan lingkungan yang adil</li>
                                        <li><span class="mr-3 text-brand-orange">▪</span>Menghentikan eksploitasi sumber daya alam yang destruktif</li>
                                        <li><span class="mr-3 text-brand-orange">▪</span>Membangun kesadaran kritis terhadap krisis ekologis</li>
                                    </ul>
                                </div>
                                <div class="flex min-h-[216px] flex-col gap-3 border-2 border-brand-dark bg-brand-cream p-[26px]">
                                    <div class="text-[24px] font-label uppercase leading-[36px] tracking-[0.06em] text-brand-green">Nilai-Nilai</div>
                                    <div class="grid grid-cols-2 gap-x-8 gap-y-5 text-[14px] font-semibold uppercase tracking-[0.025em]">
                                        <div><div class="text-brand-orange">01</div><div class="text-brand-dark">Keberanian</div></div>
                                        <div><div class="text-brand-orange">02</div><div class="text-brand-dark">Kritis</div></div>
                                        <div><div class="text-brand-orange">03</div><div class="text-brand-dark">Komunitas</div></div>
                                        <div><div class="text-brand-orange">04</div><div class="text-brand-dark">Ekologis</div></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

                <section id="isu" class="flex h-[1248.09px] w-full flex-col items-start bg-brand-dark px-[95px] pt-20 text-brand-cream">
                    <div class="mx-auto flex h-[1088.09px] w-[1280px] flex-col items-start gap-16 px-8">
                        <div class="relative h-[200.09px] w-full text-center">
                            <div class="absolute left-1/2 top-0.5 -translate-x-1/2 bg-brand-orange px-4 py-[4.5px] text-[12px] font-bold uppercase tracking-[0.06em] text-brand-cream">Isu Kritis</div>
                            <h2 class="absolute left-1/2 top-[50px] -translate-x-1/2 text-[64px] font-heading font-normal uppercase leading-[60.8px] tracking-[0.02em] text-brand-cream">
                                Krisis Lingkungan<br>
                                Jawa Barat
                            </h2>
                            <div class="absolute left-1/2 top-[196.09px] h-1 w-24 -translate-x-1/2 bg-brand-green-light"></div>
                        </div>

                        <div class="grid w-full grid-cols-3 gap-4">
                            @foreach ($issues as $issue)
                                <article class="flex h-[400px] flex-col overflow-hidden border-4 border-brand-cream bg-white text-brand-dark">
                                    <div class="relative h-[192px] overflow-hidden bg-cover bg-center" style="background-image: url('{{ asset('assets/images/resources/'.$issue['image']) }}');">
                                        <div class="absolute left-4 top-4 flex h-[50px] items-center border-2 border-brand-cream bg-brand-dark px-4 text-[20px] font-label uppercase leading-[30px] tracking-[0.05em]" style="color: {{ $issue['badgeColor'] }};">
                                            {{ $issue['badge'] }}
                                        </div>
                                    </div>
                                    <div class="flex flex-1 flex-col gap-4 px-6 py-6">
                                        <div class="flex items-center gap-3">
                                            <div class="flex h-10 w-10 items-center justify-center bg-brand-dark p-2">
                                                <img src="{{ $iqon($issue['icon']) }}" alt="{{ $issue['title'] }}" class="h-6 w-6 object-contain">
                                            </div>
                                            <h3 class="text-[24px] font-label uppercase leading-[36px] tracking-[0.06em] text-brand-dark">{{ $issue['title'] }}</h3>
                                        </div>
                                        <p class="text-[15px] leading-[24px] text-brand-dark">{{ $issue['copy'] }}</p>
                                    </div>
                                </article>
                            @endforeach
                        </div>
                    </div>
                </section>

                <section class="flex h-[1294.66px] w-full flex-col items-start bg-brand-dark px-[95px] pt-20 text-brand-cream">
                    <div class="mx-auto flex h-[1134.66px] w-[1280px] flex-col items-start gap-16 px-8">
                        <div class="relative h-[200.09px] w-full text-center">
                            <div class="absolute left-1/2 top-0.5 -translate-x-1/2 bg-brand-green px-4 py-[4.5px] text-[12px] font-bold uppercase tracking-[0.06em] text-brand-cream">Data & Laporan</div>
                            <h2 class="absolute left-1/2 top-[50px] -translate-x-1/2 text-[64px] font-heading font-normal uppercase leading-[60.8px] tracking-[0.02em] text-brand-cream">
                                Fakta dan Bukti<br>
                                Kerusakan Lingkungan
                            </h2>
                            <div class="absolute left-1/2 top-[196.09px] h-1 w-24 -translate-x-1/2 bg-brand-orange"></div>
                        </div>

                        <div class="grid w-full grid-cols-4 gap-0">
                            @foreach ($stats as $stat)
                                <div class="relative h-[197px] bg-white outline outline-4 outline-brand-cream">
                                    <div class="absolute left-[28px] top-[28px] flex h-[56px] w-[230px] items-start justify-center px-[87px]">
                                        <div class="flex h-[56px] w-[56px] items-start justify-center bg-brand-dark p-3">
                                            <img src="{{ $iqon($stat['icon']) }}" alt="{{ $stat['label'] }}" class="h-8 w-8 object-contain">
                                        </div>
                                    </div>
                                    <div class="absolute left-[28px] top-[100px] w-[230px] text-center text-[40px] font-heading leading-[40px]" style="color: {{ $stat['color'] }};">{{ $stat['value'] }}</div>
                                    <div class="absolute left-[28px] top-[148px] w-[230px] text-center text-[14px] font-semibold uppercase leading-[21px] tracking-[0.035em] text-brand-dark">{{ $stat['label'] }}</div>
                                </div>
                            @endforeach
                        </div>

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
                                <article class="flex h-[187.19px] overflow-hidden border-4 border-brand-cream bg-brand-cream text-brand-dark">
                                    <div class="flex w-[128px] flex-col items-start justify-start bg-brand-green p-6 text-brand-cream">
                                        <div class="text-[12px] font-bold uppercase tracking-[0.06em]">Tahun</div>
                                        <div class="pt-1 text-[32px] font-label leading-[48px] tracking-[0.1em]">{{ $reportYear }}</div>
                                    </div>
                                    <div class="flex flex-1 items-center justify-between gap-6 p-6">
                                        <div class="flex w-[820px] flex-col gap-3">
                                            <div class="text-[24px] font-label uppercase leading-[36px] tracking-[0.06em] text-brand-dark">{{ $reportTitle }}</div>
                                            <p class="text-[16px] leading-[25.6px] text-brand-dark">{{ $reportCopy }}</p>
                                            <div class="flex items-center gap-4 text-[14px] font-semibold leading-[20px] text-brand-green-light">
                                                <span>▪ {{ $reportPages }}</span>
                                                <span>▪ {{ $reportDownloads }}</span>
                                            </div>
                                        </div>
                                        <a href="{{ $reportUrl }}" class="flex h-[49px] items-center gap-2 border-2 border-brand-dark bg-brand-dark px-6 text-[14px] font-bold uppercase tracking-[0.035em] text-brand-cream">
                                            <img src="{{ $iqon('Icon-16.svg') }}" alt="Download" class="h-[18px] w-[18px] object-contain">
                                            <span>Lihat Laporan</span>
                                        </a>
                                    </div>
                                </article>
                            @endforeach
                        </div>
                    </div>
                </section>

                <section id="kabar" class="flex h-[1756.12px] w-full flex-col items-start border-b-4 border-brand-dark bg-brand-cream px-[95px] pb-1 pt-20 text-brand-dark">
                    <div class="relative mx-auto h-[1592.12px] w-[1280px] px-8">
                        <div class="absolute left-8 top-0 h-[200.09px] w-[1216px] text-center">
                            <div class="absolute left-0 top-0.5 bg-brand-orange px-4 py-[4.5px] text-[12px] font-bold uppercase tracking-[0.06em] text-brand-cream">Berita & Artikel</div>
                            <div class="absolute left-0 top-[50.5px] flex w-full items-end justify-between">
                                <div class="relative h-[149.59px] w-[311.49px] text-left">
                                    <h2 class="text-[64px] font-heading font-normal uppercase leading-[60.8px] tracking-[0.02em] text-brand-dark">Liputan dan<br>Investigasi</h2>
                                    <div class="absolute left-0 top-[145.59px] h-1 w-24 bg-brand-green"></div>
                                </div>
                                <a href="{{ route('blog') }}" class="flex h-[49px] items-center gap-2 border-2 border-brand-dark bg-brand-dark px-6 text-[14px] font-bold uppercase tracking-[0.035em] text-brand-cream">
                                    <span>Lihat Semua Artikel</span>
                                    <img src="{{ $iqon('Icon-17.svg') }}" alt="Arrow" class="h-[18px] w-[18px] object-contain">
                                </a>
                            </div>
                        </div>

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
                        <article class="absolute left-8 top-[264.09px] flex h-[348.02px] w-[1216px] overflow-hidden border-4 border-brand-dark bg-white">
                            <div class="relative h-full w-[604px] overflow-hidden bg-cover bg-center" style="background-image: url('{{ $featImage }}');">
                                <div class="absolute left-4 top-4 bg-brand-orange px-4 py-2 text-[12px] font-bold uppercase tracking-[0.06em] text-brand-cream">{{ $featTag }}</div>
                            </div>
                            <div class="flex w-[604px] flex-col justify-between p-8 text-brand-dark">
                                <div class="flex flex-col gap-4">
                                    <h3 class="text-[32px] font-label uppercase leading-[35.2px] tracking-[0.05em] text-brand-dark">{{ $featTitle }}</h3>
                                    <p class="text-[18px] leading-[28.8px] text-brand-dark">{{ $featCopy }}</p>
                                </div>
                                <div class="flex items-center justify-between border-t-2 border-brand-dark pt-6 text-[14px] font-semibold leading-[20px] text-brand-green-light">
                                    <div class="flex items-center gap-4">
                                        <span>{{ $featDate }}</span>
                                        <span>▪ {{ $featRead }}</span>
                                    </div>
                                    <a href="{{ $featUrl }}" class="flex items-center gap-2 text-brand-dark">
                                        <span>Baca Selengkapnya</span>
                                        <img src="{{ $iqon('Icon-18.svg') }}" alt="Detail" class="h-[18px] w-[18px] object-contain">
                                    </a>
                                </div>
                            </div>
                        </article>
                        @endif

                        <div class="absolute left-8 top-[660.12px] grid h-[932px] w-[1216px] grid-cols-3 gap-x-6 gap-y-6">
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
                                <article class="flex h-[454px] flex-col overflow-hidden border-4 border-brand-dark bg-white">
                                    <div class="relative h-[192px] overflow-hidden bg-cover bg-center" style="background-image: url('{{ $newsImage }}');">
                                        <div class="absolute left-4 top-4 px-3 py-1 text-[12px] font-bold uppercase tracking-[0.06em] text-brand-cream" style="background-color: {{ $loop->index % 3 === 2 ? '#8B6B4A' : ($loop->index % 3 === 1 ? '#5C8D59' : '#256D4A') }};">{{ $newsTag }}</div>
                                    </div>
                                    <div class="flex flex-1 flex-col justify-between px-6 py-6 text-brand-dark">
                                        <div class="flex flex-col gap-4">
                                            <a href="{{ $newsUrl }}" class="hover:text-brand-green transition-colors"><h4 class="text-[20px] font-label uppercase leading-[24px] tracking-[0.05em] text-brand-dark">{{ $newsTitle }}</h4></a>
                                            <p class="text-[15px] leading-[24px] text-brand-dark">{{ $newsCopy }}</p>
                                        </div>
                                        <div class="flex items-center gap-3 border-t-2 border-brand-dark pt-4 text-[12px] font-semibold leading-[16px] text-brand-green-light">
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

                <section id="donasi" class="relative flex h-[1415.38px] w-full overflow-hidden bg-brand-green">
                    <div class="absolute inset-0 bg-cover bg-center opacity-10" style="background-image: url('{{ asset('assets/images/backgrounds/call-to-action-bg.jpg') }}');"></div>
                    <div class="relative mx-auto flex h-full w-[1280px] flex-col gap-12 px-8 pb-1 pt-20">
                        <div class="relative h-[349px] w-full text-center">
                            <h2 class="text-[80px] font-heading font-normal uppercase leading-[76px] tracking-[0.02em] text-brand-cream">
                                Gerakan Ini<br>
                                Butuh Kamu
                            </h2>
                            <div class="mx-auto mt-6 h-2 w-32 bg-brand-orange"></div>
                            <p class="mx-auto mt-8 max-w-[768px] text-[20px] leading-[32px] text-brand-cream">Perubahan tidak terjadi dengan sendirinya. Setiap gerakan dimulai dari keberanian untuk bertindak. Bergabunglah dengan ribuan aktivis lain yang memperjuangkan keadilan ekologis.</p>
                            <div class="absolute bottom-0 left-1/2 -translate-x-1/2 text-[14px] font-bold uppercase tracking-[0.07em] text-brand-green-light">Keadilan untuk bumi, keadilan untuk rakyat</div>
                        </div>

                        <div class="grid grid-cols-2 gap-0">
                            <section class="flex h-[518.78px] flex-col border-4 border-brand-cream bg-brand-dark p-9 text-brand-cream">
                                <div class="flex items-center gap-4">
                                    <div class="flex h-14 w-14 items-center justify-center bg-brand-green p-3">
                                        <img src="{{ $iqon('Icon-19.svg') }}" alt="Relawan" class="h-8 w-8 object-contain">
                                    </div>
                                    <h3 class="text-[32px] font-label uppercase leading-[48px] tracking-[0.05em]">Jadi Relawan</h3>
                                </div>
                                <p class="mt-6 text-[16px] leading-[25.6px]">Terlibat langsung dalam pendampingan masyarakat, investigasi lapangan, kampanye, dan aksi-aksi lingkungan. Tidak perlu pengalaman, yang penting ada komitmen.</p>
                                <ul class="mt-8 flex flex-col gap-3 text-[15px] leading-[24px]">
                                    <li>▪ Pelatihan advokasi lingkungan</li>
                                    <li>▪ Jaringan aktivis se-Jawa Barat</li>
                                    <li>▪ Pengalaman kerja lapangan</li>
                                </ul>
                                <a href="https://wa.me/6281234567890" target="_blank" class="mt-8 flex h-[60px] items-center justify-center gap-2 bg-brand-green px-6 text-[16px] font-bold uppercase tracking-[0.04em] text-brand-cream">
                                    <img src="{{ $iqon('Icon-20.svg') }}" alt="Relawan" class="h-5 w-5 object-contain">
                                    <span>Daftar Jadi Relawan</span>
                                </a>
                            </section>

                            <section class="flex h-[518.78px] flex-col gap-6 border-4 border-brand-cream bg-brand-cream p-9 text-brand-dark">
                                <div class="flex items-center gap-4">
                                    <div class="flex h-14 w-14 items-center justify-center bg-brand-orange p-3">
                                        <img src="{{ $iqon('Icon-21.svg') }}" alt="Dukungan" class="h-8 w-8 object-contain">
                                    </div>
                                    <h3 class="text-[32px] font-label uppercase leading-[48px] tracking-[0.05em] text-brand-dark">Dukung Gerakan</h3>
                                </div>
                                <p class="text-[16px] leading-[25.6px]">Setiap kontribusi membantu mendanai investigasi, pendampingan hukum, kampanye, dan operasional organisasi. Kami 100% independen dari korporasi dan pemerintah.</p>
                                <div class="flex flex-1 flex-col gap-3 border-2 border-brand-dark bg-brand-cream p-[26px]">
                                    <div class="text-[12px] font-bold uppercase tracking-[0.06em] text-brand-green-light">Donasi digunakan untuk:</div>
                                    <ul class="flex flex-col gap-2 text-[15px] leading-[24px] text-brand-dark">
                                        <li>▪ Pendampingan hukum masyarakat</li>
                                        <li>▪ Investigasi dan riset</li>
                                        <li>▪ Kampanye dan edukasi publik</li>
                                    </ul>
                                </div>
                                <a href="{{ route('donasi') }}" class="flex h-[60px] items-center justify-center gap-2 bg-brand-orange px-6 text-[16px] font-bold uppercase tracking-[0.04em] text-brand-cream">
                                    <img src="{{ $iqon('Icon-22.svg') }}" alt="Donasi" class="h-5 w-5 object-contain">
                                    <span>Donasi Sekarang</span>
                                </a>
                            </section>
                        </div>

                        <div class="flex h-[291.59px] flex-col gap-8 border-4 border-brand-cream bg-brand-dark p-9 text-brand-cream">
                            <div class="flex flex-col gap-4 text-center">
                                <h3 class="text-[32px] font-label uppercase leading-[48px] tracking-[0.05em]">Hubungi Kami</h3>
                                <p class="text-[16px] leading-[25.6px]">Punya pertanyaan? Ingin melaporkan kasus? Atau sekadar ingin berdiskusi tentang isu lingkungan? Kontak kami.</p>
                            </div>
                            <div class="grid grid-cols-2 gap-6">
                                <div class="flex h-[98px] items-center gap-4 border-2 border-brand-green bg-brand-green p-6">
                                    <div class="flex h-10 w-10 items-center justify-center bg-brand-dark p-2">
                                        <img src="{{ $iqon('Icon-23.svg') }}" alt="Email" class="h-6 w-6 object-contain">
                                    </div>
                                    <div>
                                        <div class="text-[12px] font-bold uppercase tracking-[0.06em] text-brand-green-light">Email</div>
                                        <div class="text-[16px] font-semibold leading-[24px] text-brand-cream">kontak@walhi-jabar.org</div>
                                    </div>
                                </div>
                                <div class="flex h-[98px] items-center gap-4 border-2 border-brand-green bg-brand-green p-6">
                                    <div class="flex h-10 w-10 items-center justify-center bg-brand-dark p-2">
                                        <img src="{{ $iqon('Icon-24.svg') }}" alt="WhatsApp" class="h-6 w-6 object-contain">
                                    </div>
                                    <div>
                                        <div class="text-[12px] font-bold uppercase tracking-[0.06em] text-brand-green-light">WhatsApp</div>
                                        <div class="text-[16px] font-semibold leading-[24px] text-brand-cream">+62 812-3456-7890</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

                    @include('partials.site-footer')
                </main>
            </div>
        </div>
    </body>
</html>