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
                <section style="background: #1D1D1D; border-bottom: 4px #256D4A solid; color: #F4F1EA;" class="py-12 md:py-16">
                    <div class="w-full max-w-5xl mx-auto px-4 sm:px-8">
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
                <section style="background: #F4F1EA;" class="py-12 md:py-16">
                    <div class="w-full max-w-4xl mx-auto px-4 sm:px-8 flex flex-col gap-10">
                        
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
                                $statusText = 'Berlaku';
                                $issuer = 'Pemerintah RI';
                                
                                if (count($tags) >= 3) {
                                    $catVal = strtolower($tags[0]);
                                    $issuer = $tags[1];
                                    $statusVal = strtolower($tags[2]);
                                    
                                    if ($catVal === 'undang-undang') $cardCategory = 'Undang-Undang';
                                    elseif ($catVal === 'peraturan pemerintah') $cardCategory = 'Peraturan Pemerintah';
                                    elseif ($catVal === 'peraturan daerah') $cardCategory = 'Peraturan Daerah';
                                    elseif ($catVal === 'peraturan menteri' || $catVal === 'keputusan menteri') $cardCategory = 'Peraturan Menteri';
                                    
                                    if ($statusVal === 'tidak berlaku') $statusText = 'Tidak Berlaku';
                                } else {
                                    if (in_array('undang-undang', $tags)) $cardCategory = 'Undang-Undang';
                                    elseif (in_array('peraturan pemerintah', $tags)) $cardCategory = 'Peraturan Pemerintah';
                                    elseif (in_array('peraturan daerah', $tags)) $cardCategory = 'Peraturan Daerah';
                                    elseif (in_array('keputusan menteri', $tags) || in_array('peraturan menteri', $tags)) $cardCategory = 'Peraturan Menteri';
                                    
                                    $statusText = in_array('tidak berlaku', $tags) ? 'Tidak Berlaku' : 'Berlaku';
                                    foreach ($tags as $t) {
                                        if (stripos($t, 'kementerian') !== false || stripos($t, 'kemen') !== false || stripos($t, 'pemprov') !== false || stripos($t, 'pemkab') !== false || stripos($t, 'pemerintah') !== false) {
                                            $issuer = $t;
                                            break;
                                        }
                                    }
                                }
                                $year = $item->publish_date ? \Carbon\Carbon::parse($item->publish_date)->format('Y') : '2025';
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
                                $isJson = (json_last_error() === JSON_ERROR_NONE && is_array($bodyData));
                                if ($isJson) {
                                    $subtitle = $bodyData['subtitle'] ?? '';
                                    $stats = $bodyData['stats'] ?? [];
                                    $pages = $bodyData['pages'] ?? 'Dokumen Laporan';
                                    $reportDesc = $bodyData['description'] ?? '';
                                } else {
                                    $subtitle = '';
                                    $stats = [];
                                    $pages = 'Dokumen Laporan';
                                    $reportDesc = $item->body;
                                }
                                $year = $item->publish_date ? \Carbon\Carbon::parse($item->publish_date)->format('Y') : '2025';
                                
                                $ext = pathinfo($item->image_url, PATHINFO_EXTENSION);
                                if (in_array(strtolower($ext), ['xls', 'xlsx'])) {
                                    $btnText = 'Unduh Berkas Excel';
                                } elseif (in_array(strtolower($ext), ['pdf'])) {
                                    $btnText = 'Unduh Berkas PDF';
                                } else {
                                    $btnText = 'Unduh Berkas';
                                }
                            @endphp

                            <div style="background: white; border: 4px solid #1D1D1D; outline: 4px #1D1D1D solid; outline-offset: -4px; padding: 40px; display: flex; flex-direction: column; gap: 32px;">
                                <div style="display: flex; gap: 24px; align-items: center; border-bottom: 2px solid #1D1D1D; padding-bottom: 20px;">
                                    <div style="width: 80px; height: 80px; background: #256D4A; display: flex; flex-direction: column; justify-content: center; align-items: center; color: white; font-family: Anton, sans-serif; font-size: 24px;">
                                        {{ $year }}
                                    </div>
                                    <div>
                                        <h2 style="font-family: Bebas Neue, sans-serif; font-size: 32px; margin: 0; text-transform: uppercase; letter-spacing: 0.5px;">{{ $item->title }}</h2>
                                        @if($subtitle)
                                            <p style="margin: 4px 0 0; color: #5C8D59; font-weight: 600; font-size: 16px;">{{ $subtitle }}</p>
                                        @endif
                                    </div>
                                </div>

                                <div>
                                    <h3 style="font-family: Bebas Neue, sans-serif; font-size: 24px; margin: 0 0 12px; text-transform: uppercase;">Deskripsi Laporan</h3>
                                    <div style="font-size: 16px; line-height: 1.8; color: #333; white-space: pre-line;">{{ $reportDesc }}</div>
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
                                        <i data-lucide="eye" style="width: 18px; height: 18px;"></i>
                                        <span>{{ $item->views }} Kali Dibaca</span>
                                    </div>
                                </div>

                                <div style="border-top: 2px solid #1D1D1D; padding-top: 24px; display: flex; gap: 12px;">
                                    @if($item->image_url)
                                        <a href="{{ $item->image_url }}" target="_blank" style="height: 52px; padding: 0 32px; background: #1D1D1D; color: #F4F1EA; border: none; font-weight: 700; font-size: 14px; text-transform: uppercase; display: inline-flex; align-items: center; gap: 8px; text-decoration: none;" class="btn-action">
                                            <i data-lucide="download" style="width: 18px; height: 18px;"></i>
                                            {{ $btnText }}
                                        </a>
                                    @else
                                        <button disabled style="height: 52px; padding: 0 32px; background: #ddd; color: #aaa; border: none; font-weight: 700; font-size: 14px; text-transform: uppercase; cursor: not-allowed; display: inline-flex; align-items: center; gap: 8px;">
                                            <i data-lucide="download" style="width: 18px; height: 18px; color: #aaa;"></i>
                                            Berkas Laporan Belum Tersedia
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

                            <!-- Comments Section -->
                            @if($item->category === 'blog' || $item->category === 'siaran-pers' || $item->category === 'infografis')
                                <div style="border-top: 4px solid #1D1D1D; margin-top: 48px; padding-top: 48px; display: flex; flex-direction: column; gap: 32px;">
                                    <h3 style="font-family: Bebas Neue, sans-serif; font-size: 36px; text-transform: uppercase; letter-spacing: 0.5px; margin: 0; color: #1D1D1D;">
                                        Komentar ({{ $item->comments()->where('status', 'approved')->count() }})
                                    </h3>

                                    <!-- Success Alert -->
                                    @if(session('comment_success'))
                                        <div style="background: #256D4A; border: 4px solid #1D1D1D; color: white; padding: 20px; font-weight: 600; font-size: 16px; margin: 0;" class="shadow-[4px_4px_0px_0px_#1D1D1D]">
                                            {{ session('comment_success') }}
                                        </div>
                                    @endif

                                    <!-- Comments List -->
                                    <div style="display: flex; flex-direction: column; gap: 24px;">
                                        @forelse($item->comments()->where('status', 'approved')->whereNull('parent_id')->orderBy('created_at', 'desc')->get() as $comment)
                                            <div style="background: white; border: 4px solid #1D1D1D; padding: 24px; display: flex; flex-direction: column; gap: 16px;" class="shadow-[4px_4px_0px_0px_#1D1D1D]">
                                                <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 12px;">
                                                    <div style="font-weight: 800; font-size: 18px; color: #1D1D1D; text-transform: uppercase; font-family: Bebas Neue, sans-serif; tracking: 0.5px;">{{ $comment->author_name }}</div>
                                                    <div style="font-size: 12px; color: #666; font-weight: 600;">{{ $comment->created_at->translatedFormat('d M Y - H:i') }}</div>
                                                </div>
                                                <p style="font-size: 16px; line-height: 1.6; color: #333; margin: 0; white-space: pre-wrap; font-family: Inter, sans-serif;">{{ $comment->body }}</p>
                                                
                                                <!-- Reply Button -->
                                                <div style="display: flex; justify-content: flex-end;">
                                                    <button onclick="document.getElementById('reply-form-{{ $comment->id }}').style.display = document.getElementById('reply-form-{{ $comment->id }}').style.display === 'none' ? 'block' : 'none'" style="background: transparent; border: none; font-size: 12px; font-weight: 700; color: #256D4A; cursor: pointer; text-transform: uppercase; padding: 0; font-family: Inter, sans-serif; letter-spacing: 0.5px;">Balas Komentar</button>
                                                </div>

                                                <!-- Replies nested list -->
                                                @if($comment->replies()->where('status', 'approved')->count() > 0)
                                                    <div style="margin-top: 12px; display: flex; flex-direction: column; gap: 16px; border-left: 4px solid #256D4A; padding-left: 20px;">
                                                        @foreach($comment->replies()->where('status', 'approved')->orderBy('created_at', 'asc')->get() as $reply)
                                                            <div style="background: #F4F1EA; border: 4px solid #1D1D1D; padding: 16px; display: flex; flex-direction: column; gap: 8px;" class="shadow-[4px_4px_0px_0px_#1D1D1D]">
                                                                <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 8px;">
                                                                    <div style="font-weight: 800; font-size: 15px; color: #1D1D1D; text-transform: uppercase; font-family: Bebas Neue, sans-serif;">
                                                                        {{ $reply->author_name }} 
                                                                        <span style="font-size: 10px; background: #256D4A; color: white; padding: 2px 6px; text-transform: uppercase; margin-left: 6px; font-family: Inter, sans-serif; font-weight: 700;">Moderator</span>
                                                                    </div>
                                                                    <div style="font-size: 11px; color: #666; font-weight: 600;">{{ $reply->created_at->translatedFormat('d M Y - H:i') }}</div>
                                                                </div>
                                                                <p style="font-size: 14px; line-height: 1.5; color: #333; margin: 0; white-space: pre-wrap; font-family: Inter, sans-serif;">{{ $reply->body }}</p>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                @endif

                                                <!-- Nested Reply Form -->
                                                <div id="reply-form-{{ $comment->id }}" style="display: none; margin-top: 16px; padding-top: 20px; border-top: 2px dashed #1D1D1D;">
                                                    <form action="{{ route('comments.store', $item->id) }}" method="POST" style="display: flex; flex-direction: column; gap: 12px;">
                                                        @csrf
                                                        <input type="hidden" name="parent_id" value="{{ $comment->id }}" />
                                                        
                                                        <!-- Honeypot -->
                                                        <input type="text" name="extra_phone" style="display: none !important;" tabindex="-1" autocomplete="off" />

                                                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px;">
                                                            <input type="text" name="author_name" placeholder="Nama Anda" required style="border: 2px solid #1D1D1D; padding: 10px; font-size: 14px; outline: none; background: white; font-family: Inter, sans-serif;" />
                                                            <input type="email" name="author_email" placeholder="Email Anda" required style="border: 2px solid #1D1D1D; padding: 10px; font-size: 14px; outline: none; background: white; font-family: Inter, sans-serif;" />
                                                        </div>
                                                        <textarea name="body" rows="3" placeholder="Tulis balasan komentar Anda..." required style="border: 2px solid #1D1D1D; padding: 10px; font-size: 14px; outline: none; background: white; font-family: Inter, sans-serif; resize: vertical;"></textarea>
                                                        <button type="submit" style="align-self: flex-start; height: 44px; padding: 0 20px; background: #256D4A; color: white; border: 2px solid #1D1D1D; font-weight: 700; font-size: 12px; text-transform: uppercase; cursor: pointer; font-family: Inter, sans-serif;">Kirim Balasan</button>
                                                    </form>
                                                </div>
                                            </div>
                                        @empty
                                            <div style="font-style: italic; color: #666; font-size: 16px; font-family: Inter, sans-serif;">Belum ada komentar. Jadilah yang pertama memberikan tanggapan!</div>
                                        @endforelse
                                    </div>

                                    <!-- Add Comment Form -->
                                    <div style="background: white; border: 4px solid #1D1D1D; outline: 4px #1D1D1D solid; outline-offset: -4px; padding: 32px;" class="shadow-[8px_8px_0px_0px_#1D1D1D]">
                                        <h4 style="font-family: Bebas Neue, sans-serif; font-size: 28px; text-transform: uppercase; margin: 0 0 20px; color: #1D1D1D; letter-spacing: 0.5px;">Tulis Komentar Anda</h4>
                                        <form action="{{ route('comments.store', $item->id) }}" method="POST" style="display: flex; flex-direction: column; gap: 16px;">
                                            @csrf
                                            
                                            <!-- Honeypot -->
                                            <input type="text" name="extra_phone" style="display: none !important;" tabindex="-1" autocomplete="off" />

                                            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 16px; width: 100%;">
                                                <div style="display: flex; flex-direction: column; gap: 6px;">
                                                    <label style="font-weight: 700; font-size: 12px; text-transform: uppercase; color: #1D1D1D; font-family: Inter, sans-serif;">Nama Lengkap *</label>
                                                    <input type="text" name="author_name" required style="border: 2px solid #1D1D1D; padding: 12px; font-size: 15px; outline: none; background: white; font-family: Inter, sans-serif;" />
                                                </div>
                                                <div style="display: flex; flex-direction: column; gap: 6px;">
                                                    <label style="font-weight: 700; font-size: 12px; text-transform: uppercase; color: #1D1D1D; font-family: Inter, sans-serif;">Email (tidak dipublikasikan) *</label>
                                                    <input type="email" name="author_email" required style="border: 2px solid #1D1D1D; padding: 12px; font-size: 15px; outline: none; background: white; font-family: Inter, sans-serif;" />
                                                </div>
                                            </div>

                                            <div style="display: flex; flex-direction: column; gap: 6px;">
                                                <label style="font-weight: 700; font-size: 12px; text-transform: uppercase; color: #1D1D1D; font-family: Inter, sans-serif;">Isi Komentar *</label>
                                                <textarea name="body" rows="5" required style="border: 2px solid #1D1D1D; padding: 12px; font-size: 15px; outline: none; background: white; font-family: Inter, sans-serif; resize: vertical;"></textarea>
                                            </div>

                                            <button type="submit" style="align-self: flex-start; height: 52px; padding: 0 32px; background: #256D4A; color: white; border: 2px solid #1D1D1D; font-weight: 700; font-size: 14px; text-transform: uppercase; cursor: pointer; font-family: Inter, sans-serif;" class="btn-action">Kirim Komentar</button>
                                        </form>
                                    </div>
                                </div>
                            @endif
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
