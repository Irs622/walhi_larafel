<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        @include('partials.seo-meta', [
            'title' => $item->title . ' - WALHI Jawa Barat',
            'description' => Str::limit(strip_tags($item->body), 155),
            'image' => $item->image_url
        ])
 
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Anton&family=Bebas+Neue&family=Inter:wght@400;500;600;700;800&family=Oswald:wght@400;500;600;700&display=swap" rel="stylesheet">
 
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        
        <!-- Lucide Script for Icons -->
        <script src="https://unpkg.com/lucide@0.460.0/dist/umd/lucide.min.js" crossorigin="anonymous"></script>
 
        <style>
            .btn-action {
                transition: all 0.2s ease;
            }
            .btn-action:hover {
                background: #256D4A !important;
                border-color: #256D4A !important;
                color: #F4F1EA !important;
            }
            .btn-back:hover {
                background: #e9e5d9 !important;
            }
        </style>
    </head>
    <body style="width: 100%; background: #F4F1EA; margin: 0; overflow-x: clip; color: #1D1D1D; font-family: Inter, sans-serif;">
        <div style="position: relative; width: 100%; overflow-x: clip; background: #F4F1EA;">
            @include('partials.site-header')
 
            <main style="display: flex; flex-direction: column; align-items: stretch;">
                
                <!-- Hero Header -->
                <section style="background: #1D1D1D; border-bottom: 4px #256D4A solid; padding: 64px 95px 64px; color: #F4F1EA;">
                    <div style="width: 100%; max-width: 1280px; margin: 0 auto; padding: 0 32px; box-sizing: border-box;">
                        <div style="display: flex; flex-direction: column; gap: 24px; width: 100%;">
                            <!-- Breadcrumbs -->
                            <div style="display: flex; align-items: center; gap: 8px; font-size: 12px; font-family: Inter, sans-serif; font-weight: 600; text-transform: uppercase; letter-spacing: 0.3px;">
                                <a href="{{ route('home') }}" style="color: #F4F1EA; text-decoration: none; opacity: 0.8;">Beranda</a>
                                <span style="color: #256D4A; font-weight: 400; font-size: 16px;">/</span>
                                <span style="color: #F4F1EA; opacity: 0.8; text-transform: uppercase;">{{ str_replace('-', ' ', $item->category) }}</span>
                                <span style="color: #256D4A; font-weight: 400; font-size: 16px;">/</span>
                                <span style="color: #5C8D59;">Detail</span>
                            </div>
                            
                            <h1 style="margin: 0; color: #F4F1EA; font-size: clamp(36px, 5vw, 64px); font-family: Anton, sans-serif; font-weight: 400; line-height: 1.05; letter-spacing: 1px; text-transform: uppercase;">
                                {{ $item->title }}
                            </h1>
                            <div style="width: 128px; height: 8px; background: #D95C3F;"></div>
                            
                            @if($item->category === 'blog' || $item->category === 'siaran-pers')
                                <div style="display: flex; align-items: center; gap: 16px; color: #5C8D59; font-size: 14px; font-weight: 600; flex-wrap: wrap;">
                                    <div style="display: flex; align-items: center; gap: 6px;">
                                        <i data-lucide="calendar" style="width: 16px; height: 16px;"></i>
                                        <span>{{ $item->publish_date ? \Carbon\Carbon::parse($item->publish_date)->translatedFormat('d F Y') : $item->created_at->translatedFormat('d F Y') }}</span>
                                    </div>
                                    <span>▪</span>
                                    <div style="display: flex; align-items: center; gap: 6px;">
                                        <i data-lucide="clock" style="width: 16px; height: 16px;"></i>
                                        <span>{{ $readTime }} Menit Baca</span>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </section>
 
                <!-- Content Section -->
                <section style="padding: 64px 95px 96px; background: #F4F1EA;">
                    <div style="width: 100%; max-width: 900px; margin: 0 auto; padding: 0 32px; box-sizing: border-box; display: flex; flex-direction: column; gap: 40px;">
                        
                        <!-- Back Button -->
                        <div>
                            @php
                                $backUrl = route('home');
                                if($item->category === 'blog') $backUrl = route('blog');
                                elseif($item->category === 'regulasi') $backUrl = route('regulasi');
                                elseif($item->category === 'siaran-pers') $backUrl = route('siaran-pers');
                                elseif($item->category === 'laporan-tahunan') $backUrl = route('laporan-tahunan');
                            @endphp
                            <a href="{{ $backUrl }}" style="display: inline-flex; align-items: center; gap: 8px; height: 44px; padding: 0 20px; background: white; color: #1D1D1D; border: 2px solid #1D1D1D; text-decoration: none; font-size: 14px; font-weight: 700; text-transform: uppercase;" class="btn-back">
                                <i data-lucide="arrow-left" style="width: 16px; height: 16px;"></i>
                                Kembali
                            </a>
                        </div>
 
                        <!-- Rendering based on Category -->
                        @if($item->category === 'regulasi')
                            <!-- REGULASI LAYOUT -->
                            @php
                                $tags = array_map('trim', explode(',', $item->tags ?? ''));
                                $cardCategory = 'Undang-Undang';
                                if (in_array('undang-undang', $tags)) $cardCategory = 'Undang-Undang';
                                elseif (in_array('peraturan pemerintah', $tags)) $cardCategory = 'Peraturan Pemerintah';
                                elseif (in_array('peraturan daerah', $tags)) $cardCategory = 'Peraturan Daerah';
                                elseif (in_array('keputusan menteri', $tags) || in_array('peraturan menteri', $tags)) $cardCategory = 'Peraturan Menteri';
                                
                                $statusText = in_array('tidak berlaku', $tags) ? 'Tidak Berlaku' : 'Berlaku';
                                $year = $item->publish_date ? \Carbon\Carbon::parse($item->publish_date)->format('Y') : '2025';
                                $issuer = 'Pemerintah RI';
                                foreach ($tags as $t) {
                                    if (stripos($t, 'kementerian') !== false || stripos($t, 'kemen') !== false || stripos($t, 'pemprov') !== false || stripos($t, 'pemkab') !== false || stripos($t, 'pemerintah') !== false) {
                                        $issuer = $t;
                                        break;
                                    }
                                }
                            @endphp
 
                            <div style="background: white; border: 4px solid #1D1D1D; outline: 4px #1D1D1D solid; outline-offset: -4px; padding: 40px; display: flex; flex-direction: column; gap: 32px;">
                                <div style="display: flex; justify-content: space-between; align-items: center; border-bottom: 2px solid #1D1D1D; padding-bottom: 20px; flex-wrap: wrap; gap: 16px;">
                                    <div style="display: flex; align-items: center; gap: 12px;">
                                        <span style="background: #256D4A; color: white; padding: 4px 12px; font-size: 12px; font-weight: 700; text-transform: uppercase;">{{ $cardCategory }}</span>
                                        <span style="font-family: Bebas Neue, sans-serif; font-size: 24px; color: #1D1D1D;">Tahun {{ $year }}</span>
                                    </div>
                                    <span style="background: {{ $statusText === 'Berlaku' ? '#256D4A' : '#888' }}; color: white; padding: 4px 12px; font-size: 12px; font-weight: 700; text-transform: uppercase;">{{ $statusText }}</span>
                                </div>
 
                                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 24px; background: #F4F1EA; padding: 24px; border-left: 4px solid #256D4A;">
                                    <div>
                                        <div style="font-size: 12px; color: #888; font-weight: 700; text-transform: uppercase;">Instansi Penerbit</div>
                                        <div style="font-size: 16px; font-weight: 600; color: #1D1D1D; margin-top: 4px;">{{ $issuer }}</div>
                                    </div>
                                    <div>
                                        <div style="font-size: 12px; color: #888; font-weight: 700; text-transform: uppercase;">Tanggal Penetapan</div>
                                        <div style="font-size: 16px; font-weight: 600; color: #1D1D1D; margin-top: 4px;">{{ $item->publish_date ? \Carbon\Carbon::parse($item->publish_date)->translatedFormat('d F Y') : '-' }}</div>
                                    </div>
                                </div>
 
                                <div>
                                    <h3 style="font-family: Bebas Neue, sans-serif; font-size: 28px; margin: 0 0 12px;">Ringkasan / Isi Regulasi</h3>
                                    <div style="font-size: 16px; line-height: 1.8; color: #333; white-space: pre-line;">{{ $item->body }}</div>
                                </div>
 
                                <div style="border-top: 2px solid #1D1D1D; padding-top: 24px;">
                                    @if($item->image_url)
                                        <a href="{{ $item->image_url }}" target="_blank" style="height: 52px; padding: 0 32px; background: #1D1D1D; color: #F4F1EA; border: none; font-weight: 700; font-size: 14px; text-transform: uppercase; display: inline-flex; align-items: center; gap: 8px; text-decoration: none;" class="btn-action">
                                            <i data-lucide="download" style="width: 18px; height: 18px;"></i>
                                            Unduh Dokumen PDF
                                        </a>
                                    @else
                                        <button disabled style="height: 52px; padding: 0 32px; background: #ddd; color: #aaa; border: none; font-weight: 700; font-size: 14px; text-transform: uppercase; cursor: not-allowed; display: inline-flex; align-items: center; gap: 8px;">
                                            <i data-lucide="download" style="width: 18px; height: 18px; color: #aaa;"></i>
                                            Dokumen PDF Belum Tersedia
                                        </button>
                                    @endif
                                </div>
                            </div>
 
                        @elseif($item->category === 'laporan-tahunan')
                            <!-- LAPORAN TAHUNAN LAYOUT -->
                            @php
                                $bodyData = json_decode($item->body, true);
                                $subtitle = $bodyData['subtitle'] ?? $item->body;
                                $stats = $bodyData['stats'] ?? [];
                                $pages = $bodyData['pages'] ?? '100 Halaman';
                                $downloads = $bodyData['downloads'] ?? '0 Downloads';
                                $year = $item->publish_date ? \Carbon\Carbon::parse($item->publish_date)->format('Y') : '2025';
                            @endphp
 
                            <div style="background: white; border: 4px solid #1D1D1D; outline: 4px #1D1D1D solid; outline-offset: -4px; padding: 40px; display: flex; flex-direction: column; gap: 32px;">
                                <div style="display: flex; gap: 24px; align-items: center; border-bottom: 2px solid #1D1D1D; padding-bottom: 20px;">
                                    <div style="width: 80px; height: 80px; background: #256D4A; display: flex; flex-direction: column; justify-content: center; align-items: center; color: white; font-family: Anton, sans-serif; font-size: 24px;">
                                        {{ $year }}
                                    </div>
                                    <div>
                                        <h2 style="font-family: Bebas Neue, sans-serif; font-size: 32px; margin: 0; text-transform: uppercase; letter-spacing: 0.5px;">{{ $item->title }}</h2>
                                        <p style="margin: 4px 0 0; color: #5C8D59; font-weight: 600; font-size: 16px;">{{ $subtitle }}</p>
                                    </div>
                                </div>
 
                                @if(count($stats) > 0)
                                    <div>
                                        <h3 style="font-family: Bebas Neue, sans-serif; font-size: 24px; margin: 0 0 16px; text-transform: uppercase;">Poin Utama Laporan</h3>
                                        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 16px;">
                                            @foreach($stats as $stat)
                                                <div style="background: #F4F1EA; border-left: 4px solid #256D4A; padding: 16px; display: flex; align-items: flex-start; gap: 12px;">
                                                    <i data-lucide="check-square" style="width: 20px; height: 20px; color: #256D4A; flex-shrink: 0; margin-top: 2px;"></i>
                                                    <span style="font-weight: 600; font-size: 14px; line-height: 1.4;">{{ $stat }}</span>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif
 
                                <div style="display: flex; gap: 24px; color: #5C8D59; font-weight: 600; font-size: 14px;">
                                    <div style="display: flex; align-items: center; gap: 6px;">
                                        <i data-lucide="file-text" style="width: 18px; height: 18px;"></i>
                                        <span>{{ $pages }}</span>
                                    </div>
                                    <div style="display: flex; align-items: center; gap: 6px;">
                                        <i data-lucide="download-cloud" style="width: 18px; height: 18px;"></i>
                                        <span>{{ $downloads }}</span>
                                    </div>
                                </div>
 
                                <div style="border-top: 2px solid #1D1D1D; padding-top: 24px; display: flex; gap: 12px;">
                                    @if($item->image_url)
                                        <a href="{{ $item->image_url }}" target="_blank" style="height: 52px; padding: 0 32px; background: #1D1D1D; color: #F4F1EA; border: none; font-weight: 700; font-size: 14px; text-transform: uppercase; display: inline-flex; align-items: center; gap: 8px; text-decoration: none;" class="btn-action">
                                            <i data-lucide="download" style="width: 18px; height: 18px;"></i>
                                            Download Laporan PDF
                                        </a>
                                    @else
                                        <button disabled style="height: 52px; padding: 0 32px; background: #ddd; color: #aaa; border: none; font-weight: 700; font-size: 14px; text-transform: uppercase; cursor: not-allowed; display: inline-flex; align-items: center; gap: 8px;">
                                            <i data-lucide="download" style="width: 18px; height: 18px; color: #aaa;"></i>
                                            Laporan PDF Belum Tersedia
                                        </button>
                                    @endif
                                </div>
                            </div>
 
                        @else
                            <!-- DEFAULT BLOG & SIARAN PERS LAYOUT -->
                            <article style="background: white; border: 4px solid #1D1D1D; outline: 4px #1D1D1D solid; outline-offset: -4px; padding: 48px; display: flex; flex-direction: column; gap: 32px;">
                                
                                <!-- Cover Image -->
                                @if($item->image_url)
                                    <div style="width: 100%; border: 4px solid #1D1D1D; background: #1D1D1D; overflow: hidden; max-height: 480px;">
                                        <img style="width: 100%; height: auto; object-fit: cover; display: block;" src="{{ $item->image_url }}" alt="{{ $item->title }}" />
                                    </div>
                                @endif
                                
                                <!-- Article Body -->
                                <div style="font-size: 17px; line-height: 1.85; color: #1D1D1D; font-family: Inter, sans-serif; white-space: pre-line;">
                                    {!! $item->body !!}
                                </div>
                                
                                <!-- Tags / Chips -->
                                @if($item->tags)
                                    <div style="display: flex; flex-wrap: wrap; gap: 8px; border-top: 2px solid #1D1D1D; padding-top: 24px;">
                                        @foreach(array_map('trim', explode(',', $item->tags)) as $tag)
                                            <span style="padding: 6px 12px; background: #F4F1EA; border: 2px solid #1D1D1D; font-size: 12px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; color: #1D1D1D;">
                                                #{{ $tag }}
                                            </span>
                                        @endforeach
                                    </div>
                                @endif
                            </article>
                        @endif
 
                    </div>
                </section>
 
            </main>
 
            @include('partials.site-footer')
        </div>
        
        <script>
            // Initialize Lucide icons on page load
            document.addEventListener('DOMContentLoaded', function() {
                lucide.createIcons();
            });
        </script>
    </body>
</html>
