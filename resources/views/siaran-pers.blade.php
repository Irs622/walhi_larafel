<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        @include('partials.seo-meta', ['title' => 'Siaran Pers - WALHI Jawa Barat'])

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
            .press-release-card {
                transition: transform 0.2s ease, box-shadow 0.2s ease;
            }
            .press-release-card:hover {
                transform: translateY(-4px);
                box-shadow: 0 12px 32px rgba(29, 29, 29, 0.12);
            }
            
            /* Responsive layout for mobile devices */
            @media (max-width: 640px) {
                .card-header-bar {
                    flex-direction: column !important;
                    align-items: flex-start !important;
                    gap: 12px !important;
                }
                .card-actions-bar {
                    flex-direction: column !important;
                    align-items: stretch !important;
                    gap: 12px !important;
                }
                .card-actions-bar > * {
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
                                <span style="color: #5C8D59;">Siaran Pers</span>
                            </div>
                            
                            <h1 style="margin: 0; color: #F4F1EA; font-size: clamp(52px, 7vw, 80px); font-family: Anton, sans-serif; font-weight: 400; line-height: 0.95; letter-spacing: 1.6px; text-transform: uppercase;">
                                SIARAN PERS
                            </h1>
                            <div style="width: 128px; height: 8px; background: #D95C3F;"></div>
                            <p style="margin: 0; color: #5C8D59; font-size: 20px; line-height: 32px; font-family: Inter, sans-serif;">
                                Pernyataan Resmi dan Posisi WALHI Jawa Barat
                            </p>
                        </div>
                    </div>
                </section>

                <!-- List Content Section -->
                <section style="background: #F4F1EA; color: #1D1D1D; border-bottom: 4px #1D1D1D solid;" class="py-16 md:py-20">
                    <div class="w-full max-w-5xl mx-auto px-4 sm:px-8 flex flex-col gap-10">
                        
                        @forelse($items as $item)
                            @php
                                $months = [
                                    '01' => 'Januari', '02' => 'Februari', '03' => 'Maret', '04' => 'April',
                                    '05' => 'Mei', '06' => 'Juni', '07' => 'Juli', '08' => 'Agustus',
                                    '09' => 'September', '10' => 'Oktober', '11' => 'November', '12' => 'Desember'
                                ];
                                $dateObj = \Carbon\Carbon::parse($item->publish_date);
                                $formattedDate = $dateObj->format('d') . ' ' . $months[$dateObj->format('m')] . ' ' . $dateObj->format('Y');
                            @endphp

                            <!-- Card item -->
                            <article style="background: white; border: 4px solid #1D1D1D; outline: 4px #1D1D1D solid; outline-offset: -4px; padding: 32px; display: flex; flex-direction: column; gap: 16px;" class="press-release-card">
                                <div style="display: flex; justify-content: space-between; align-items: center; width: 100%;" class="card-header-bar">
                                    <div style="background: #D95C3F; color: #F4F1EA; padding: 4px 16px; font-family: Inter, sans-serif; font-size: 12px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.6px;">
                                        Siaran Pers
                                    </div>
                                    <div style="display: flex; align-items: center; gap: 8px; color: #5C8D59; font-family: Inter, sans-serif; font-size: 14px; font-weight: 600;">
                                        <i data-lucide="calendar" style="width: 16px; height: 16px;"></i>
                                        <span>{{ $formattedDate }}</span>
                                    </div>
                                </div>
                                
                                <h2 style="margin: 0; color: #1D1D1D; font-size: 32px; font-family: 'Bebas Neue', sans-serif; font-weight: 400; text-transform: uppercase; line-height: 1.1; letter-spacing: 1.6px;">
                                    {{ $item->title }}
                                </h2>
                                
                                @php
                                    $cleanBody = strip_tags($item->body);
                                    $wordsArray = preg_split('/\s+/', trim($cleanBody));
                                    $hasMore = count($wordsArray) > 13;
                                    if ($hasMore) {
                                        $limitedBody = implode(' ', array_slice($wordsArray, 0, 13)) . '...';
                                    } else {
                                        $limitedBody = $cleanBody;
                                    }
                                @endphp
                                <p style="margin: 0; color: #1D1D1D; font-size: 18px; font-family: Inter, sans-serif; line-height: 1.7;">
                                    {{ $limitedBody }}
                                    @if($hasMore)
                                        <a href="{{ route('content.show', $item->slug) }}" style="color: #256D4A; font-weight: 600; text-decoration: underline; margin-left: 4px;">Baca Selengkapnya</a>
                                    @endif
                                </p>
                                
                                <div style="border-top: 2px solid #1D1D1D; padding-top: 24px; display: flex; gap: 12px; align-items: center;" class="card-actions-bar">
                                    <a href="{{ route('content.show', $item->slug) }}"
                                       style="height: 48px; padding: 0 24px; background: #1D1D1D; color: #F4F1EA; border: none; font-family: Inter, sans-serif; font-weight: 700; font-size: 14px; letter-spacing: 0.35px; text-transform: uppercase; cursor: pointer; display: inline-flex; align-items: center; justify-content: center; gap: 8px; text-decoration: none; transition: background 0.2s;"
                                       class="hover-action-dark-btn">
                                        <i data-lucide="book-open" style="width: 16px; height: 16px;"></i>
                                        Baca Lengkap
                                    </a>
                                    
                                    @if($item->image_url)
                                        <a href="{{ $item->image_url }}" target="_blank"
                                           style="height: 48px; padding: 0 24px; background: white; color: #1D1D1D; border: 2px solid #1D1D1D; font-family: Inter, sans-serif; font-weight: 700; font-size: 14px; letter-spacing: 0.35px; text-transform: uppercase; cursor: pointer; display: inline-flex; align-items: center; justify-content: center; gap: 8px; text-decoration: none; box-sizing: border-box; transition: background 0.2s;"
                                           class="hover-action-light-btn">
                                            <i data-lucide="download" style="width: 16px; height: 16px;"></i>
                                            Download PDF
                                        </a>
                                    @else
                                        <button disabled
                                                style="height: 48px; padding: 0 24px; background: white; color: #aaa; border: 2px solid #ddd; font-family: Inter, sans-serif; font-weight: 700; font-size: 14px; letter-spacing: 0.35px; text-transform: uppercase; cursor: not-allowed; display: inline-flex; align-items: center; justify-content: center; gap: 8px; box-sizing: border-box; opacity: 0.6;">
                                            <i data-lucide="download" style="width: 16px; height: 16px; color: #aaa;"></i>
                                            Download PDF
                                        </button>
                                    @endif
                                </div>
                            </article>
                        @empty
                            <div style="background: white; border: 4px solid #1D1D1D; padding: 48px; text-align: center; font-size: 18px; font-family: Inter, sans-serif; color: #888;">
                                <i data-lucide="alert-circle" style="width: 48px; height: 48px; margin: 0 auto 16px; color: #8B6B4A; display: block;"></i>
                                Belum ada siaran pers yang diterbitkan.
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

        <!-- Premium Details Modal Removed -->
        <script>
            // Initialize Lucide icons on page load
            document.addEventListener('DOMContentLoaded', function() {
                lucide.createIcons();
            });
        </script>
    </body>
</html>
