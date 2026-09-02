<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        @include('partials.seo-meta', ['title' => 'Catatan Kritis - WALHI Jawa Barat'])

        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,400;1,600&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="{{ asset('assets/fonts/webfonts/font-face.css') }}">

        @vite(['resources/css/app.css', 'resources/js/app.js'])
        
        <!-- Lucide Script for Icons -->
        <script nonce="{{ Vite::cspNonce() }}" src="https://unpkg.com/lucide@0.460.0/dist/umd/lucide.min.js" integrity="sha384-ieG+IKD0d/ZPXyCBTMVAbqsQdns8QGJR/e26WMw7M4fkaI/rHcS/YIoi+ah9WGge" crossorigin="anonymous"></script>
        
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
    <body style="width: 100%; background: #F4F1EA; margin: 0; overflow-x: clip; color: #1D1D1D; font-family: Montserrat, sans-serif;">
        <div style="position: relative; width: 100%; overflow-x: clip; background: #F4F1EA;">
            @include('partials.site-header')

            <main style="display: flex; flex-direction: column; align-items: stretch;">
                
                <!-- Hero Section -->
                <section style="background: #1D1D1D; border-bottom: 4px #256D4A solid; color: #F4F1EA;" class="py-12 md:py-16">
                    <div class="w-full max-w-5xl mx-auto px-4 sm:px-8">
                        <div style="display: flex; flex-direction: column; gap: 24px; max-width: 860px; width: 100%;">
                            <!-- Breadcrumbs -->
                            <div style="display: flex; align-items: center; gap: 8px; font-size: 12px; font-family: Montserrat, sans-serif; font-weight: 600; text-transform: uppercase; letter-spacing: 0.3px;">
                                <a href="{{ route('home') }}" style="color: #F4F1EA; text-decoration: none; opacity: 0.8;">Beranda</a>
                                <span style="color: #256D4A; font-weight: 400; font-size: 16px;">/</span>
                                <span style="color: #F4F1EA; opacity: 0.8;">Publikasi</span>
                                <span style="color: #256D4A; font-weight: 400; font-size: 16px;">/</span>
                                <span style="color: #5C8D59;">Catatan Kritis</span>
                            </div>
                            
                            <h1 style="margin: 0; color: #F4F1EA; font-size: clamp(48px, 6vw, 76px); font-family: Aspekta, sans-serif; font-weight: 800; line-height: 1; letter-spacing: 1.6px; text-transform: uppercase;">
                                CATATAN KRITIS
                            </h1>
                            <div style="width: 128px; height: 8px; background: #D95C3F;"></div>
                            <p style="margin: 0; color: #5C8D59; font-size: 20px; line-height: 32px; font-family: Montserrat, sans-serif;">
                                Analisis Mendalam dan Catatan Kritis Kebijakan Tata Ruang serta Lingkungan Hidup
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
                                $dateObj = \Carbon\Carbon::parse($item->publish_date ?? $item->created_at);
                                $formattedDate = $dateObj->format('d') . ' ' . $months[$dateObj->format('m')] . ' ' . $dateObj->format('Y');
                            @endphp

                            <!-- Card item -->
                            <article style="background: white; border: 4px solid #1D1D1D; outline: 4px #1D1D1D solid; outline-offset: -4px; padding: 32px; display: flex; flex-direction: column; gap: 16px;" class="press-release-card">
                                <div style="display: flex; justify-content: space-between; align-items: center; width: 100%;" class="card-header-bar">
                                    <div style="background: #D95C3F; color: #F4F1EA; padding: 4px 16px; font-family: Montserrat, sans-serif; font-size: 12px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.6px;">
                                        Catatan Kritis
                                    </div>
                                    <div style="display: flex; align-items: center; gap: 8px; color: #5C8D59; font-family: Montserrat, sans-serif; font-size: 14px; font-weight: 600;">
                                        <i data-lucide="calendar" style="width: 16px; height: 16px;"></i>
                                        <span>{{ $formattedDate }}</span>
                                    </div>
                                </div>
                                
                                <h2 style="margin: 0; color: #1D1D1D; font-size: 28px; font-family: Aspekta, sans-serif; font-weight: 700; text-transform: uppercase; line-height: 1.2; letter-spacing: 0.8px;">
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
                                <p style="margin: 0; color: #1D1D1D; font-size: 16px; font-family: Montserrat, sans-serif; line-height: 1.7;">
                                    {{ $limitedBody }}
                                    @if($hasMore)
                                        <a href="{{ route('content.show', $item->slug) }}" style="color: #256D4A; font-weight: 600; text-decoration: underline; margin-left: 4px;">Baca Selengkapnya</a>
                                    @endif
                                </p>
                                
                                <div style="border-top: 2px solid #1D1D1D; padding-top: 24px; display: flex; gap: 12px; align-items: center;" class="card-actions-bar">
                                    <a href="{{ route('content.show', $item->slug) }}"
                                       style="height: 48px; padding: 0 24px; background: #1D1D1D; color: #F4F1EA; border: none; font-family: Montserrat, sans-serif; font-weight: 700; font-size: 14px; letter-spacing: 0.35px; text-transform: uppercase; cursor: pointer; display: inline-flex; align-items: center; justify-content: center; gap: 8px; text-decoration: none; transition: background 0.2s;"
                                       class="hover-action-dark-btn">
                                        <i data-lucide="book-open" style="width: 16px; height: 16px;"></i>
                                        Baca Lengkap
                                    </a>
                                </div>
                            </article>
                        @empty
                            <div style="background: white; border: 4px solid #1D1D1D; padding: 48px; text-align: center;">
                                <p style="font-size: 18px; color: #666; margin: 0; font-family: Montserrat, sans-serif;">Belum ada dokumen catatan kritis yang diterbitkan.</p>
                            </div>
                        @endforelse

                        <!-- Pagination -->
                        @if($items->hasPages())
                            <div class="mt-8 flex justify-center">
                                {{ $items->links() }}
                            </div>
                        @endif

                    </div>
                </section>
            </main>

            @include('partials.site-footer')
        </div>

        <script nonce="{{ Vite::cspNonce() }}">
            document.addEventListener('DOMContentLoaded', () => {
                if (typeof lucide !== 'undefined') {
                    lucide.createIcons();
                }
            });
        </script>
    </body>
</html>
