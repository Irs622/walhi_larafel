<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        @include('partials.seo-meta', ['title' => 'Laporan Tahunan & Publikasi - WALHI Jawa Barat'])

        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Anton&family=Bebas+Neue&family=Inter:wght@400;500;600;700;800&family=Oswald:wght@400;500;600;700&display=swap" rel="stylesheet">

        @vite(['resources/css/app.css', 'resources/js/app.js'])
        
        <!-- Lucide Script for Icons -->
        <script src="https://unpkg.com/lucide@0.460.0/dist/umd/lucide.min.js" crossorigin="anonymous"></script>
        
        <style>
            .hover-action-dark-btn:hover {
                background: #256D4A !important;
                border-color: #256D4A !important;
            }
            .hover-action-light-btn:hover {
                background: #e9e5d9 !important;
            }
            .report-card {
                transition: transform 0.2s ease, box-shadow 0.2s ease;
            }
            .report-card:hover {
                transform: translateY(-6px);
                box-shadow: 0 16px 36px rgba(29, 29, 29, 0.12);
            }
            
            /* Responsive Layout Media Queries */
            @media (max-width: 900px) {
                .report-card {
                    flex-direction: column !important;
                }
                .report-left-panel {
                    width: 100% !important;
                    height: 160px !important;
                    border-right: none !important;
                    border-bottom: 4px solid #1D1D1D !important;
                }
                .report-right-panel {
                    width: 100% !important;
                }
            }
            
            @media (max-width: 640px) {
                .report-stats-grid {
                    grid-template-columns: 1fr !important;
                }
                .report-meta-row {
                    flex-direction: column !important;
                    align-items: flex-start !important;
                    gap: 12px !important;
                }
                .report-actions-row {
                    flex-direction: column !important;
                    align-items: stretch !important;
                    gap: 12px !important;
                }
                .report-actions-row > * {
                    width: 100% !important;
                    text-align: center !important;
                    justify-content: center !important;
                }
            }
        </style>
    </head>
    <body style="width: 100%; background: #F4F1EA; margin: 0; overflow-x: clip; color: #1D1D1D; font-family: Inter, sans-serif;">
        <div style="position: relative; width: 100%; overflow-x: clip; background: #F4F1EA;">
            @include('partials.site-header')

            <main style="display: flex; flex-direction: column; align-items: stretch;">
                
                <!-- Hero Section -->
                <section style="background: #1D1D1D; border-bottom: 4px #256D4A solid; color: #F4F1EA;" class="py-12 md:py-16">
                    <div class="w-full max-w-5xl mx-auto px-4 sm:px-8">
                        <div style="display: flex; flex-direction: column; gap: 24px; max-width: 860px; width: 100%;">
                            <!-- Breadcrumbs -->
                            <div style="display: flex; align-items: center; gap: 8px; font-size: 12px; font-family: Inter, sans-serif; font-weight: 600; text-transform: uppercase; letter-spacing: 0.3px;">
                                <a href="{{ route('home') }}" style="color: #F4F1EA; text-decoration: none; opacity: 0.8;">Beranda</a>
                                <span style="color: #256D4A; font-weight: 400; font-size: 16px;">/</span>
                                <span style="color: #F4F1EA; opacity: 0.8;">Publikasi</span>
                                <span style="color: #256D4A; font-weight: 400; font-size: 16px;">/</span>
                                <span style="color: #5C8D59;">Laporan Tahunan</span>
                            </div>
                            
                            <h1 style="margin: 0; color: #F4F1EA; font-size: clamp(52px, 7vw, 80px); font-family: Anton, sans-serif; font-weight: 400; line-height: 0.95; letter-spacing: 1.6px; text-transform: uppercase;">
                                LAPORAN TAHUNAN
                            </h1>
                            <div style="width: 128px; height: 8px; background: #D95C3F;"></div>
                            <p style="margin: 0; color: #5C8D59; font-size: 20px; line-height: 32px; font-family: Inter, sans-serif;">
                                Dokumentasi Perjuangan dan Capaian Tahunan
                            </p>
                        </div>
                    </div>
                </section>

                <!-- List Content Section -->
                <section style="background: #F4F1EA; color: #1D1D1D; border-bottom: 4px #1D1D1D solid;" class="py-16 md:py-20">
                    <div class="w-full max-w-5xl mx-auto px-4 sm:px-8 flex flex-col gap-10">
                        
                        @forelse($items as $item)
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
                                $downloadsText = $item->views . ' Kali Dibaca';
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

                            <!-- Card container -->
                            <article style="background: white; border: 4px solid #1D1D1D; outline: 4px #1D1D1D solid; outline-offset: -4px; overflow: hidden; display: flex; flex-direction: row; width: 100%; min-height: 440px;" class="report-card">
                                
                                <!-- Left side Year Panel -->
                                <div style="width: 270px; background: #256D4A; padding: 32px; display: flex; flex-direction: column; justify-content: center; align-items: center; border-right: 4px solid #1D1D1D; flex-shrink: 0; box-sizing: border-box;" class="report-left-panel">
                                    <div style="color: rgba(244, 241, 234, 0.6); font-family: Inter, sans-serif; font-size: 14px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.7px; margin-bottom: 8px;">
                                        Laporan Tahun
                                    </div>
                                    <div style="color: #F4F1EA; font-family: Anton, sans-serif; font-size: 80px; font-weight: 400; line-height: 1; letter-spacing: 4px;">
                                        {{ $year }}
                                    </div>
                                </div>
                                
                                <!-- Right side Content Panel -->
                                <div style="flex: 1; padding: 32px; display: flex; flex-direction: column; gap: 24px; box-sizing: border-box;" class="report-right-panel">
                                    <div>
                                        <h2 style="margin: 0; color: #1D1D1D; font-size: 32px; font-family: 'Bebas Neue', sans-serif; font-weight: 400; text-transform: uppercase; letter-spacing: 1.5px; line-height: 1.2;">
                                            {{ $item->title }}
                                        </h2>
                                        <p style="margin: 6px 0 0; color: #5C8D59; font-family: Inter, sans-serif; font-size: 18px; font-weight: 600; line-height: 1.4;">
                                            {{ $subtitle ?: Str::limit(strip_tags($reportDesc), 100) }}
                                        </p>
                                    </div>
                                    
                                    <!-- Stats checklist grid -->
                                    @if(count($stats) > 0)
                                        <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 16px; width: 100%;" class="report-stats-grid">
                                            @foreach($stats as $stat)
                                                <div style="background: #F4F1EA; border-left: 4px solid #256D4A; padding: 16px; display: flex; align-items: flex-start; gap: 12px; box-sizing: border-box;">
                                                    <i data-lucide="check-square" style="width: 20px; height: 20px; color: #256D4A; flex-shrink: 0; margin-top: 2px;"></i>
                                                    <span style="color: #1D1D1D; font-family: Inter, sans-serif; font-size: 14px; font-weight: 600; line-height: 1.4;">
                                                        {{ $stat }}
                                                    </span>
                                                </div>
                                            @endforeach
                                        </div>
                                    @endif
                                    
                                    <!-- Meta page/downloads line -->
                                    <div style="display: flex; align-items: center; gap: 24px; color: #5C8D59; font-family: Inter, sans-serif; font-size: 14px; font-weight: 600;" class="report-meta-row">
                                        <div style="display: flex; align-items: center; gap: 8px;">
                                            <i data-lucide="file-text" style="width: 16px; height: 16px;"></i>
                                            <span>{{ $pages }}</span>
                                        </div>
                                        <div style="display: flex; align-items: center; gap: 8px;">
                                            <i data-lucide="eye" style="width: 16px; height: 16px;"></i>
                                            <span>{{ $downloadsText }}</span>
                                        </div>
                                    </div>
                                    
                                    <!-- Action buttons -->
                                    <div style="border-top: 2px solid #1D1D1D; padding-top: 24px; display: flex; gap: 12px; align-items: center;" class="report-actions-row">
                                        @if($item->image_url)
                                            <a href="{{ $item->image_url }}" target="_blank"
                                               style="height: 52px; padding: 0 32px; background: #1D1D1D; color: #F4F1EA; border: none; font-family: Inter, sans-serif; font-weight: 700; font-size: 15px; letter-spacing: 0.4px; text-transform: uppercase; cursor: pointer; display: inline-flex; align-items: center; justify-content: center; gap: 8px; text-decoration: none; transition: background 0.2s;"
                                               class="hover-action-dark-btn">
                                                <i data-lucide="download" style="width: 18px; height: 18px;"></i>
                                                {{ $btnText }}
                                            </a>
                                            <a href="{{ route('content.show', $item->slug) }}"
                                               style="height: 52px; padding: 0 32px; background: white; color: #1D1D1D; border: 2px solid #1D1D1D; font-family: Inter, sans-serif; font-weight: 700; font-size: 15px; letter-spacing: 0.4px; text-transform: uppercase; cursor: pointer; display: inline-flex; align-items: center; justify-content: center; gap: 8px; text-decoration: none; box-sizing: border-box; transition: background 0.2s;"
                                               class="hover-action-light-btn">
                                                <i data-lucide="book-open" style="width: 18px; height: 18px;"></i>
                                                Detail Laporan
                                            </a>
                                        @else
                                            <button disabled
                                                    style="height: 52px; padding: 0 32px; background: #ddd; color: #aaa; border: none; font-family: Inter, sans-serif; font-weight: 700; font-size: 15px; letter-spacing: 0.4px; text-transform: uppercase; cursor: not-allowed; display: inline-flex; align-items: center; justify-content: center; gap: 8px; opacity: 0.6;">
                                                <i data-lucide="download" style="width: 18px; height: 18px; color: #aaa;"></i>
                                                Berkas Belum Tersedia
                                            </button>
                                            <a href="{{ route('content.show', $item->slug) }}"
                                               style="height: 52px; padding: 0 32px; background: white; color: #1D1D1D; border: 2px solid #1D1D1D; font-family: Inter, sans-serif; font-weight: 700; font-size: 15px; letter-spacing: 0.4px; text-transform: uppercase; cursor: pointer; display: inline-flex; align-items: center; justify-content: center; gap: 8px; text-decoration: none; box-sizing: border-box; transition: background 0.2s;"
                                               class="hover-action-light-btn">
                                                <i data-lucide="book-open" style="width: 18px; height: 18px;"></i>
                                                Detail Laporan
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            </article>
                        @empty
                            <div style="background: white; border: 4px solid #1D1D1D; padding: 48px; text-align: center; font-size: 18px; font-family: Inter, sans-serif; color: #888;">
                                <i data-lucide="alert-circle" style="width: 48px; height: 48px; margin: 0 auto 16px; color: #8B6B4A; display: block;"></i>
                                Belum ada laporan tahunan yang diterbitkan.
                            </div>
                        @endforelse

                        <!-- Neobrutalist Pagination -->
                        @if($items->hasPages())
                            <div style="display: flex; justify-content: center; align-items: center; gap: 12px; margin-top: 48px;">
                                <a href="{{ $items->previousPageUrl() }}" style="display: inline-flex; align-items: center; justify-content: center; width: 48px; height: 48px; background: white; border: 2px solid #1D1D1D; color: #1D1D1D; font-weight: 700; text-decoration: none; cursor: pointer; {{ $items->onFirstPage() ? 'opacity: 0.5; pointer-events: none;' : '' }}">
                                    ‹
                                </a>
                                <span style="font-weight: 700; font-size: 16px; color: #1D1D1D; font-family: Inter, sans-serif;">
                                    Halaman {{ $items->currentPage() }} dari {{ $items->lastPage() }}
                                </span>
                                <a href="{{ $items->nextPageUrl() }}" style="display: inline-flex; align-items: center; justify-content: center; width: 48px; height: 48px; background: white; border: 2px solid #1D1D1D; color: #1D1D1D; font-weight: 700; text-decoration: none; cursor: pointer; {{ !$items->hasMorePages() ? 'opacity: 0.5; pointer-events: none;' : '' }}">
                                    ›
                                </a>
                            </div>
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
