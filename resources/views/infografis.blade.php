<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        @include('partials.seo-meta', ['title' => 'Infografis & Visualisasi Data - WALHI Jawa Barat'])

        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Anton&family=Bebas+Neue&family=Inter:wght@400;500;600;700;800&family=Oswald:wght@400;500;600;700&display=swap" rel="stylesheet">

        @vite(['resources/css/app.css', 'resources/js/app.js'])
        
        <!-- Lucide Script for Icons -->
        <script src="https://unpkg.com/lucide@0.460.0/dist/umd/lucide.min.js" crossorigin="anonymous"></script>
        
        <style>
            .hover-download-btn:hover {
                background: #1D1D1D !important;
            }
            .infographic-card {
                transition: transform 0.2s ease, box-shadow 0.2s ease;
            }
            .infographic-card:hover {
                transform: translateY(-6px);
                box-shadow: 0 16px 36px rgba(29, 29, 29, 0.15);
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
                                <span style="color: #5C8D59;">Infografis</span>
                            </div>
                            
                            <h1 style="margin: 0; color: #F4F1EA; font-size: clamp(52px, 7vw, 80px); font-family: Anton, sans-serif; font-weight: 400; line-height: 0.95; letter-spacing: 1.6px; text-transform: uppercase;">
                                INFOGRAFIS
                            </h1>
                            <div style="width: 128px; height: 8px; background: #D95C3F;"></div>
                            <p style="margin: 0; color: #5C8D59; font-size: 20px; line-height: 32px; font-family: Inter, sans-serif;">
                                Visualisasi Data Lingkungan Hidup
                            </p>
                        </div>
                    </div>
                </section>

                <!-- Grid Content Section -->
                <section style="background: #F4F1EA; color: #1D1D1D; border-bottom: 4px #1D1D1D solid;" class="py-16 md:py-20">
                    <div class="w-full max-w-6xl mx-auto px-4 sm:px-8">
                        
                        <!-- Grid layout -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8 w-full">
                            @forelse($items as $item)
                                @php
                                    // Fallback cover image based on slug
                                    $coverImage = $item->image_url ?: 'https://placehold.co/376x256/1d1d1d/f4f1ea?text=' . urlencode(Str::limit($item->title, 20));
                                    if (!$item->image_url) {
                                        if (Str::contains(Str::slug($item->title), 'tambang')) {
                                            $coverImage = 'https://placehold.co/376x256/2d221c/f4f1ea?text=Pertambangan+Ilegal';
                                        } elseif (Str::contains(Str::slug($item->title), 'citarum')) {
                                            $coverImage = 'https://placehold.co/376x256/1c2a38/f4f1ea?text=Pencemaran+Citarum';
                                        } elseif (Str::contains(Str::slug($item->title), 'deforestasi')) {
                                            $coverImage = 'https://placehold.co/376x256/1c3821/f4f1ea?text=Deforestasi+Hutan';
                                        }
                                    }
                                @endphp

                                <article style="background: white; border: 4px solid #1D1D1D; outline: 4px #1D1D1D solid; outline-offset: -4px; overflow: hidden; display: flex; flex-direction: column; height: 100%;" class="infographic-card">
                                    <!-- Image cover container -->
                                    <div style="width: 100%; height: 240px; overflow: hidden; border-bottom: 4px solid #1D1D1D; background: #1D1D1D; position: relative;">
                                        <img style="width: 100%; height: 100%; object-fit: cover;" src="{{ $coverImage }}" alt="{{ $item->title }}" />
                                    </div>
                                    
                                    <!-- Card details -->
                                    <div style="padding: 24px; display: flex; flex-direction: column; justify-content: space-between; flex: 1; gap: 16px;">
                                        <h2 style="margin: 0; color: #1D1D1D; font-size: 24px; font-family: 'Bebas Neue', sans-serif; font-weight: 400; text-transform: uppercase; line-height: 1.2; letter-spacing: 0.5px;">
                                            <a href="{{ route('content.show', $item->slug) }}" style="color: #1D1D1D; text-decoration: none; transition: color 0.2s;" onmouseover="this.style.color='#256D4A'" onmouseout="this.style.color='#1D1D1D'">
                                                {{ $item->title }}
                                            </a>
                                        </h2>
                                        
                                        <div>
                                            <a href="{{ route('content.show', $item->slug) }}"
                                               style="width: 100%; height: 48px; background: #256D4A; color: #F4F1EA; border: none; font-family: Inter, sans-serif; font-weight: 700; font-size: 14px; letter-spacing: 0.35px; text-transform: uppercase; cursor: pointer; display: inline-flex; align-items: center; justify-content: center; gap: 8px; text-decoration: none; box-sizing: border-box; transition: background 0.2s;"
                                               class="hover-download-btn">
                                                <i data-lucide="book-open" style="width: 18px; height: 18px;"></i>
                                                Baca Infografis
                                            </a>
                                        </div>
                                    </div>
                                </article>
                            @empty
                                <div style="grid-column: 1 / -1; background: white; border: 4px solid #1D1D1D; padding: 48px; text-align: center; font-size: 18px; font-family: Inter, sans-serif; color: #888;">
                                    <i data-lucide="alert-circle" style="width: 48px; height: 48px; margin: 0 auto 16px; color: #8B6B4A; display: block;"></i>
                                    Belum ada infografis yang diterbitkan.
                                </div>
                            @endforelse
                        </div>

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
