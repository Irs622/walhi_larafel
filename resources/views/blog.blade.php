<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Blog - WALHI Jawa Barat</title>

        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Anton&family=Bebas+Neue&family=Inter:wght@400;500;600;700;800&family=Oswald:wght@400;500;600;700&display=swap" rel="stylesheet">

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body style="width: 100%; background: #F4F1EA; margin: 0; overflow-x: hidden; color: #1D1D1D; font-family: Inter, sans-serif;">
        @php
            $blogCategories = ['Semua', 'Investigasi', 'Advokasi', 'Laporan', 'Kampanye', 'Pendidikan', 'Opini'];

            $newsCards = [
                ['category' => 'Advokasi', 'image' => 'news-1-1.jpg', 'tag' => 'Advokasi', 'title' => 'Petani Garut Menang: Tanah Dikembalikan Setelah 3 Tahun Gugatan', 'copy' => 'Putusan pengadilan memenangkan gugatan 300 keluarga petani. Ini kemenangan hukum penting untuk kasus-kasus agraria serupa di seluruh Jawa Barat.', 'date' => '15 Mei 2026', 'read' => '8 menit'],
                ['category' => 'Laporan', 'image' => 'news-1-2.jpg', 'tag' => 'Laporan', 'title' => 'Data Baru: Tingkat Pencemaran Citarum Naik 23% dalam 6 Bulan', 'copy' => 'Monitoring terbaru menunjukkan peningkatan drastis polusi industri. Pemerintah diminta bertindak cepat sebelum kondisi semakin memburuk.', 'date' => '10 Mei 2026', 'read' => '6 menit'],
                ['category' => 'Kampanye', 'image' => 'news-1-3.jpg', 'tag' => 'Kampanye', 'title' => 'Ratusan Aktivis Turun ke Jalan Tolak Pembangunan Pabrik di DAS', 'copy' => 'Aksi bersama menolak izin pembangunan pabrik semen di kawasan penyangga Daerah Aliran Sungai. Massa menuntut pencabutan izin lingkungan.', 'date' => '5 Mei 2026', 'read' => '5 menit'],
                ['category' => 'Pendidikan', 'image' => 'news-4-2.jpg', 'tag' => 'Pendidikan', 'title' => 'Peluncuran Sekolah Lapang: Petani Belajar Pertanian Ekologis', 'copy' => 'Program pendampingan petani untuk transisi dari metode konvensional ke pertanian ramah lingkungan. Hasil panen meningkat tanpa merusak tanah.', 'date' => '1 Mei 2026', 'read' => '7 menit'],
                ['category' => 'Opini', 'image' => 'news-4-3.jpg', 'tag' => 'Opini', 'title' => "Mengapa Kita Harus Menolak 'Green Capitalism' dalam Krisis Iklim", 'copy' => 'Analisis kritis terhadap solusi pasar dalam menghadapi krisis ekologis. Apa yang dibutuhkan adalah transformasi sistem, bukan sekadar greenwashing.', 'date' => '28 Apr 2026', 'read' => '10 menit'],
                ['category' => 'Opini', 'image' => 'news-2-1.jpg', 'tag' => 'Opini', 'title' => "Mengapa Kita Harus Menolak 'Green Capitalism' dalam Krisis Iklim", 'copy' => 'Analisis kritis terhadap solusi pasar dalam menghadapi krisis ekologis. Apa yang dibutuhkan adalah transformasi sistem, bukan sekadar greenwashing.', 'date' => '28 Apr 2026', 'read' => '10 menit'],
            ];

            $featuredNews = [
                'category' => 'Investigasi',
                'image' => 'news-4-1.jpg',
                'tag' => 'Investigasi',
                'title' => 'Penelusuran Jejak Modal di Balik Tambang Ilegal Gunung Halimun',
                'copy' => 'Investigasi mendalam mengungkap jaringan korporasi dan pejabat yang memfasilitasi pertambangan ilegal. Dokumen internal bocor, saksi kunci berbicara.',
                'date' => '18 Mei 2026',
                'read' => '12 menit',
            ];
        @endphp

        <div style="position: relative; width: 100%; overflow: hidden; background: #F4F1EA;">
            @include('partials.site-header')

            <main style="display: flex; flex-direction: column; align-items: stretch;">
                <section style="background: #1D1D1D; border-bottom: 4px #256D4A solid; padding: 64px 95px 80px; color: #F4F1EA;">
                    <div style="width: 100%; max-width: 1280px; margin: 0 auto; padding: 0 32px; box-sizing: border-box;">
                        <div style="display: flex; flex-direction: column; gap: 24px; max-width: 860px; width: 100%;">
                            <div style="display: inline-flex; width: fit-content; padding: 4px 16px; background: #256D4A; color: #F4F1EA; font-size: 12px; font-weight: 700; line-height: 18px; letter-spacing: 0.7px; text-transform: uppercase;">
                                Blog
                            </div>
                            <h1 style="margin: 0; max-width: 760px; color: #F4F1EA; font-size: clamp(52px, 7vw, 80px); font-family: Anton, sans-serif; font-weight: 400; line-height: 0.95; letter-spacing: 1.6px; text-transform: uppercase;">
                                Liputan, Advokasi,<br>
                                dan Catatan Lapangan
                            </h1>
                            <div style="width: 128px; height: 8px; background: #E56A43;"></div>
                            <p style="margin: 0; max-width: 760px; color: #F4F1EA; font-size: 20px; line-height: 32px;">
                                Kumpulan laporan, investigasi, dan pembaruan gerakan WALHI Jawa Barat untuk mengikuti isu lingkungan, keadilan ekologis, dan kerja-kerja advokasi di lapangan.
                            </p>
                        </div>
                    </div>
                </section>

                <section style="padding: 80px 95px 96px; background: #F4F1EA; color: #1D1D1D; border-bottom: 4px #1D1D1D solid;">
                    <div style="width: 100%; max-width: 1280px; margin: 0 auto; padding: 0 32px; box-sizing: border-box; display: flex; flex-direction: column; gap: 48px;">
                        <div style="display: flex; flex-wrap: wrap; gap: 12px; align-items: center; justify-content: flex-start;">
                            @foreach ($blogCategories as $category)
                                <button type="button" data-blog-filter="{{ $category }}" style="padding: 12px 18px; border: 2px solid {{ $loop->first ? '#256D4A' : '#1D1D1D' }}; background: {{ $loop->first ? '#256D4A' : '#F4F1EA' }}; color: {{ $loop->first ? '#F4F1EA' : '#1D1D1D' }}; font-size: 12px; font-weight: 700; line-height: 18px; letter-spacing: 0.8px; text-transform: uppercase; cursor: pointer;">
                                    {{ $category }}
                                </button>
                            @endforeach
                        </div>

                        <article data-blog-card data-blog-category="{{ $featuredNews['category'] }}" style="display: flex; flex-wrap: wrap; overflow: hidden; border: 4px solid #1D1D1D; background: #FFFFFF; min-height: 348px;">
                            <div style="position: relative; flex: 1 1 420px; min-height: 320px; background-image: url('{{ asset('assets/images/blog/'.$featuredNews['image']) }}'); background-size: cover; background-position: center;">
                                <div style="position: absolute; left: 16px; top: 16px; padding: 8px 16px; background: #E56A43; color: #F4F1EA; font-size: 12px; font-weight: 700; line-height: 18px; letter-spacing: 0.6px; text-transform: uppercase;">
                                    {{ $featuredNews['tag'] }}
                                </div>
                            </div>
                            <div style="flex: 1 1 420px; padding: 32px; display: flex; flex-direction: column; justify-content: space-between; gap: 24px;">
                                <div style="display: flex; flex-direction: column; gap: 16px;">
                                    <h2 style="margin: 0; color: #1D1D1D; font-size: 32px; font-family: Bebas Neue, sans-serif; font-weight: 400; line-height: 35.2px; letter-spacing: 1.6px; text-transform: uppercase;">
                                        {{ $featuredNews['title'] }}
                                    </h2>
                                    <p style="margin: 0; color: #1D1D1D; font-size: 18px; line-height: 28.8px;">
                                        {{ $featuredNews['copy'] }}
                                    </p>
                                </div>
                                <div style="display: flex; align-items: center; justify-content: space-between; gap: 24px; padding-top: 24px; border-top: 2px solid #1D1D1D; color: #5C8D59; font-size: 14px; font-weight: 600; line-height: 20px;">
                                    <div style="display: flex; align-items: center; gap: 16px; flex-wrap: wrap;">
                                        <span>{{ $featuredNews['date'] }}</span>
                                        <span>▪ {{ $featuredNews['read'] }}</span>
                                    </div>
                                    <a href="#" style="display: inline-flex; align-items: center; gap: 8px; color: #1D1D1D; text-decoration: none;">
                                        <span>Baca Selengkapnya</span>
                                        <span style="font-size: 18px; line-height: 1;">›</span>
                                    </a>
                                </div>
                            </div>
                        </article>

                        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(260px, 1fr)); gap: 24px;">
                            @foreach ($newsCards as $news)
                                <article data-blog-card data-blog-category="{{ $news['category'] }}" style="display: flex; flex-direction: column; overflow: hidden; border: 4px solid #1D1D1D; background: #FFFFFF; min-height: 454px;">
                                    <div style="position: relative; height: 192px; background-image: url('{{ asset('assets/images/blog/'.$news['image']) }}'); background-size: cover; background-position: center;">
                                        <div style="position: absolute; left: 16px; top: 16px; padding: 4px 12px; background: {{ $loop->index % 3 === 2 ? '#8B6B4A' : ($loop->index % 3 === 1 ? '#5C8D59' : '#256D4A') }}; color: #F4F1EA; font-size: 12px; font-weight: 700; line-height: 18px; letter-spacing: 0.6px; text-transform: uppercase;">
                                            {{ $news['tag'] }}
                                        </div>
                                    </div>
                                    <div style="display: flex; flex: 1 1 0%; flex-direction: column; justify-content: space-between; padding: 24px; gap: 24px;">
                                        <div style="display: flex; flex-direction: column; gap: 16px;">
                                            <h3 style="margin: 0; color: #1D1D1D; font-size: 20px; font-family: Bebas Neue, sans-serif; font-weight: 400; line-height: 24px; letter-spacing: 1px; text-transform: uppercase;">
                                                {{ $news['title'] }}
                                            </h3>
                                            <p style="margin: 0; color: #1D1D1D; font-size: 15px; line-height: 24px;">
                                                {{ $news['copy'] }}
                                            </p>
                                        </div>
                                        <div style="display: flex; align-items: center; gap: 12px; padding-top: 16px; border-top: 2px solid #1D1D1D; color: #5C8D59; font-size: 12px; font-weight: 600; line-height: 16px; flex-wrap: wrap;">
                                            <span>{{ $news['date'] }}</span>
                                            <span>▪</span>
                                            <span>{{ $news['read'] }}</span>
                                        </div>
                                    </div>
                                </article>
                            @endforeach
                        </div>
                    </div>
                </section>
            </main>

            @include('partials.site-footer')
        </div>
    </body>
</html>