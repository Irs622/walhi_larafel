<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Siaran Pers - WALHI Jawa Barat</title>

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
                <section style="background: #1D1D1D; border-bottom: 4px #256D4A solid; padding: 64px 95px 64px; color: #F4F1EA;">
                    <div style="width: 100%; max-width: 1280px; margin: 0 auto; padding: 0 32px; box-sizing: border-box;">
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
                <section style="padding: 80px 95px 96px; background: #F4F1EA; color: #1D1D1D; border-bottom: 4px #1D1D1D solid;">
                    <div style="width: 100%; max-width: 1024px; margin: 0 auto; padding: 0 32px; box-sizing: border-box; display: flex; flex-direction: column; gap: 32px;">
                        
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
                                
                                <p style="margin: 0; color: #1D1D1D; font-size: 18px; font-family: Inter, sans-serif; line-height: 1.7;">
                                    {{ Str::limit($item->body, 280, '...') }}
                                </p>
                                
                                <div style="border-top: 2px solid #1D1D1D; padding-top: 24px; display: flex; gap: 12px; align-items: center;" class="card-actions-bar">
                                    <button onclick="openReleaseModal({{ json_encode($item) }}, '{{ $formattedDate }}')"
                                            style="height: 48px; padding: 0 24px; background: #1D1D1D; color: #F4F1EA; border: none; font-family: Inter, sans-serif; font-weight: 700; font-size: 14px; letter-spacing: 0.35px; text-transform: uppercase; cursor: pointer; display: inline-flex; align-items: center; justify-content: center; gap: 8px; transition: background 0.2s;"
                                            class="hover-action-dark-btn">
                                        <i data-lucide="book-open" style="width: 16px; height: 16px;"></i>
                                        Baca Selengkapnya
                                    </button>
                                    
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

                    </div>
                </section>
            </main>

            @include('partials.site-footer')
        </div>

        <!-- Premium Details Modal -->
        <div id="release-modal" style="position: fixed; inset: 0; background: rgba(0, 0, 0, 0.6); z-index: 1000; backdrop-filter: blur(4px); display: none; align-items: center; justify-content: center; padding: 16px; box-sizing: border-box;">
            <div style="background: white; border: 4px solid #1D1D1D; width: 100%; max-width: 768px; max-height: 90vh; display: flex; flex-direction: column; box-shadow: 0 20px 40px rgba(0,0,0,0.3); overflow: hidden; box-sizing: border-box;">
                <!-- Modal Header -->
                <div style="padding: 24px; border-bottom: 2px solid #1D1D1D; display: flex; justify-content: space-between; align-items: center; background: #F4F1EA;">
                    <div style="display: flex; align-items: center; gap: 12px;">
                        <span style="background: #D95C3F; color: #F4F1EA; padding: 2px 12px; font-family: Inter, sans-serif; font-size: 10px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px;">Siaran Pers</span>
                        <span id="modal-date" style="color: #5C8D59; font-family: Inter, sans-serif; font-size: 13px; font-weight: 600;">22 Mei 2026</span>
                    </div>
                    <button onclick="closeReleaseModal()" style="background: transparent; border: none; font-size: 24px; font-family: Inter, sans-serif; cursor: pointer; display: flex; align-items: center; color: #1D1D1D;">
                        <i data-lucide="x" style="width: 24px; height: 24px;"></i>
                    </button>
                </div>
                
                <!-- Modal Body -->
                <div style="padding: 32px; overflow-y: auto; flex: 1;">
                    <h2 id="modal-title" style="margin: 0 0 16px; color: #1D1D1D; font-size: 32px; font-family: 'Bebas Neue', sans-serif; letter-spacing: 1px; line-height: 1.2; text-transform: uppercase;">
                        Title Placeholder
                    </h2>
                    <p id="modal-body" style="margin: 0; color: #1D1D1D; font-size: 16px; font-family: Inter, sans-serif; line-height: 1.8; white-space: pre-wrap;">
                        Content Placeholder
                    </p>
                </div>
                
                <!-- Modal Footer -->
                <div style="padding: 20px 24px; border-top: 2px solid #1D1D1D; background: #F4F1EA; display: flex; justify-content: flex-end; gap: 12px;">
                    <a id="modal-pdf" href="#" target="_blank"
                       style="height: 44px; padding: 0 20px; background: white; color: #1D1D1D; border: 2px solid #1D1D1D; font-family: Inter, sans-serif; font-weight: 700; font-size: 12px; letter-spacing: 0.35px; text-transform: uppercase; cursor: pointer; display: inline-flex; align-items: center; gap: 6px; text-decoration: none; box-sizing: border-box; transition: background 0.2s;"
                       class="hover-action-light-btn">
                        <i data-lucide="download" style="width: 14px; height: 14px;"></i>
                        Download PDF
                    </a>
                    <button onclick="closeReleaseModal()" 
                            style="height: 44px; padding: 0 20px; background: #1D1D1D; color: #F4F1EA; border: none; font-family: Inter, sans-serif; font-weight: 700; font-size: 12px; letter-spacing: 0.35px; text-transform: uppercase; cursor: pointer; display: inline-flex; align-items: center; transition: background 0.2s;"
                            class="hover-action-dark-btn">
                        Tutup
                    </button>
                </div>
            </div>
        </div>
        
        <script>
            // Modal controller functions
            function openReleaseModal(item, formattedDate) {
                document.getElementById('modal-title').textContent = item.title;
                document.getElementById('modal-date').textContent = formattedDate;
                document.getElementById('modal-body').textContent = item.body;
                
                var pdfBtn = document.getElementById('modal-pdf');
                if (item.image_url) {
                    pdfBtn.href = item.image_url;
                    pdfBtn.style.display = 'inline-flex';
                } else {
                    pdfBtn.style.display = 'none';
                }
                
                var modal = document.getElementById('release-modal');
                modal.style.display = 'flex';
                document.body.style.overflow = 'hidden';
            }
            
            function closeReleaseModal() {
                var modal = document.getElementById('release-modal');
                modal.style.display = 'none';
                document.body.style.overflow = 'auto';
            }
            
            // Initialize Lucide icons on page load
            document.addEventListener('DOMContentLoaded', function() {
                lucide.createIcons();
            });
            
            // Close modal when clicking outside content area
            window.addEventListener('click', function(event) {
                var modal = document.getElementById('release-modal');
                if (event.target === modal) {
                    closeReleaseModal();
                }
            });
        </script>
    </body>
</html>
