<header style="width: 100%; z-index: 1000; position: sticky; top: 0;">
    <style>
        @media (max-width: 1024px) {
            .desktop-nav {
                display: none !important;
            }
            .desktop-icons {
                display: none !important;
            }
            .mobile-menu-btn {
                display: flex !important;
            }
        }
        @media (min-width: 1025px) {
            .mobile-menu-btn {
                display: none !important;
            }
            .mobile-menu-overlay {
                display: none !important;
            }
        }
    </style>
 
    @php
        $isHome = request()->routeIs('home');
        $isBlog = request()->routeIs('blog');
        $isAbout = request()->routeIs('about');
        $isRegulasi = request()->routeIs('regulasi');
        $isPublikasi = request()->routeIs('siaran-pers') || request()->routeIs('infografis') || request()->routeIs('laporan-tahunan');
        $isDonasi = request()->routeIs('donasi');
 
        $navLinkStyle = function (bool $active): string {
            return 'color: '.($active ? '#256D4A' : '#1D1D1D').'; font-size: 14px; font-family: Oswald, sans-serif; font-weight: 500; text-transform: uppercase; letter-spacing: 0.70px; text-decoration: none; display: inline-flex; align-items: center; gap: 6px; transition: color 0.2s;';
        };
    @endphp
 
    <!-- Top Bar -->
    <div style="width: 100%; height: 41px; background: #1D1D1D; border-bottom: 1px #256D4A solid; display: flex; justify-content: center;">
        <div style="width: 100%; max-width: 1280px; height: 100%; padding: 0 32px; box-sizing: border-box; display: flex; justify-content: space-between; align-items: center;">
            <!-- Left Side -->
            <div style="color: #F4F1EA; font-size: 12px; font-family: Inter, sans-serif; font-weight: 500;">
                Kampanye Darurat: Hentikan Tambang Ilegal
            </div>
            <!-- Right Side -->
            <div style="display: flex; align-items: center; gap: 16px;">
                <a href="https://facebook.com/walhi.jabar" target="_blank" style="color: #F4F1EA; font-size: 12px; font-family: Inter, sans-serif; text-decoration: none; opacity: 0.8; transition: opacity 0.2s;" onmouseover="this.style.opacity=1" onmouseout="this.style.opacity=0.8">Facebook</a>
                <span style="color: #256D4A; font-size: 16px; font-family: Inter, sans-serif; user-select: none;">|</span>
                <a href="https://instagram.com/walhi.jabar" target="_blank" style="color: #F4F1EA; font-size: 12px; font-family: Inter, sans-serif; text-decoration: none; opacity: 0.8; transition: opacity 0.2s;" onmouseover="this.style.opacity=1" onmouseout="this.style.opacity=0.8">Instagram</a>
                <span style="color: #256D4A; font-size: 16px; font-family: Inter, sans-serif; user-select: none;">|</span>
                <a href="https://www.youtube.com/@walhijabar" target="_blank" style="color: #F4F1EA; font-size: 12px; font-family: Inter, sans-serif; text-decoration: none; opacity: 0.8; transition: opacity 0.2s;" onmouseover="this.style.opacity=1" onmouseout="this.style.opacity=0.8">YouTube</a>
            </div>
        </div>
    </div>
 
    <!-- Main Navigation Bar -->
    <div style="width: 100%; height: 80px; background: #F4F1EA; box-shadow: 0px 1px 2px -1px rgba(0, 0, 0, 0.10), 0px 1px 3px rgba(0, 0, 0, 0.10); display: flex; justify-content: center;">
        <div style="width: 100%; max-width: 1280px; height: 100%; padding: 0 32px; box-sizing: border-box; display: flex; justify-content: space-between; align-items: center;">
            <!-- Logo -->
            <div style="height: 48px; display: flex; align-items: center;">
                <a href="{{ route('home') }}" style="display: block; height: 48px;">
                    <img src="{{ asset('assets/images/resources/logo-2-walhi.png') }}" alt="WALHI Jawa Barat" style="height: 48px; object-fit: contain;" />
                </a>
            </div>
 
            <!-- Navigation Links (Desktop) -->
            <nav class="desktop-nav" style="display: flex; align-items: center; justify-content: space-between; width: 599.9px; height: 37px; position: relative;">
                <!-- BERANDA -->
                <div style="position: relative; height: 100%; display: inline-flex; align-items: center;">
                    <a href="{{ route('home') }}" style="{{ $navLinkStyle($isHome) }}">BERANDA</a>
                    @if ($isHome)
                        <div style="width: 100%; height: 2px; left: 0; bottom: 0; position: absolute; background: #256D4A;"></div>
                    @endif
                </div>
 
                <!-- BLOG -->
                <div style="position: relative; height: 100%; display: inline-flex; align-items: center;">
                    <a href="{{ route('blog') }}" style="{{ $navLinkStyle($isBlog) }}">BLOG</a>
                    @if ($isBlog)
                        <div style="width: 100%; height: 2px; left: 0; bottom: 0; position: absolute; background: #256D4A;"></div>
                    @endif
                </div>
 
                <!-- REGULASI -->
                <div style="position: relative; height: 100%; display: inline-flex; align-items: center;">
                    <a href="{{ route('regulasi') }}" style="{{ $navLinkStyle($isRegulasi) }}">REGULASI</a>
                    @if ($isRegulasi)
                        <div style="width: 100%; height: 2px; left: 0; bottom: 0; position: absolute; background: #256D4A;"></div>
                    @endif
                </div>
 
                <!-- PUBLIKASI (with details/summary dropdown) -->
                <details class="site-nav-dropdown" style="position: relative; height: 100%; display: inline-flex; align-items: center; cursor: pointer;">
                    <summary style="display: inline-flex; align-items: center; gap: 6px; position: relative !important; color: {{ $isPublikasi ? '#256D4A' : '#1D1D1D' }}; font-size: 14px; font-family: Oswald, sans-serif; font-weight: 500; text-transform: uppercase; letter-spacing: 0.70px; list-style: none; outline: none;">
                        <span>PUBLIKASI</span>
                        <svg xmlns="http://www.w3.org/2000/svg" width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3.5" stroke-linecap="round" stroke-linejoin="round" style="margin-top: 1px;"><path d="m6 9 6 6 6-6"/></svg>
                    </summary>
                    <div class="site-nav-dropdown-panel" style="width: 492px; left: -160px; top: 37px; position: absolute; background: #F4F1EA; border-top: 4px solid #256D4A; box-shadow: 0 18px 40px rgba(0, 0, 0, 0.14); z-index: 30;">
                        <a href="{{ route('siaran-pers') }}" style="display: flex; align-items: center; min-height: 74px; padding: 0 32px; color: #1D1D1D; font-size: 24px; font-family: Inter, sans-serif; font-weight: 700; line-height: 32px; text-decoration: none; border-bottom: 1px solid rgba(37, 109, 74, 0.18); background: {{ request()->routeIs('siaran-pers') ? '#FFFFFF' : '#F4F1EA' }}; transition: background 0.2s;" onmouseover="this.style.background='#FFFFFF'" onmouseout="this.style.background='{{ request()->routeIs('siaran-pers') ? '#FFFFFF' : '#F4F1EA' }}'">Siaran Pers</a>
                        <a href="{{ route('infografis') }}" style="display: flex; align-items: center; min-height: 74px; padding: 0 32px; color: #1D1D1D; font-size: 24px; font-family: Inter, sans-serif; font-weight: 700; line-height: 32px; text-decoration: none; border-bottom: 1px solid rgba(37, 109, 74, 0.18); background: {{ request()->routeIs('infografis') ? '#FFFFFF' : '#F4F1EA' }}; transition: background 0.2s;" onmouseover="this.style.background='#FFFFFF'" onmouseout="this.style.background='{{ request()->routeIs('infografis') ? '#FFFFFF' : '#F4F1EA' }}'">Infografis</a>
                        <a href="{{ route('laporan-tahunan') }}" style="display: flex; align-items: center; min-height: 74px; padding: 0 32px; color: #1D1D1D; font-size: 24px; font-family: Inter, sans-serif; font-weight: 700; line-height: 32px; text-decoration: none; background: {{ request()->routeIs('laporan-tahunan') ? '#FFFFFF' : '#F4F1EA' }}; transition: background 0.2s;" onmouseover="this.style.background='#FFFFFF'" onmouseout="this.style.background='{{ request()->routeIs('laporan-tahunan') ? '#FFFFFF' : '#F4F1EA' }}'">Laporan Tahunan</a>
                    </div>
                    @if ($isPublikasi)
                        <div style="width: 100%; height: 2px; left: 0; bottom: 0; position: absolute; background: #256D4A;"></div>
                    @endif
                </details>
 
                <!-- DUKUNG KAMI -->
                <div style="position: relative; height: 100%; display: inline-flex; align-items: center;">
                    <a href="{{ route('donasi') }}" style="{{ $navLinkStyle($isDonasi) }}">
                        <span>DUKUNG KAMI</span>
                        <svg xmlns="http://www.w3.org/2000/svg" width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3.5" stroke-linecap="round" stroke-linejoin="round" style="margin-top: 1px;"><path d="m6 9 6 6 6-6"/></svg>
                    </a>
                    @if ($isDonasi)
                        <div style="width: 100%; height: 2px; left: 0; bottom: 0; position: absolute; background: #256D4A;"></div>
                    @endif
                </div>
 
                <!-- TENTANG KAMI -->
                <div style="position: relative; height: 100%; display: inline-flex; align-items: center;">
                    <a href="{{ route('about') }}" style="{{ $navLinkStyle($isAbout) }}">
                        <span>TENTANG KAMI</span>
                        <svg xmlns="http://www.w3.org/2000/svg" width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3.5" stroke-linecap="round" stroke-linejoin="round" style="margin-top: 1px;"><path d="m6 9 6 6 6-6"/></svg>
                    </a>
                    @if ($isAbout)
                        <div style="width: 100%; height: 2px; left: 0; bottom: 0; position: absolute; background: #256D4A;"></div>
                    @endif
                </div>
            </nav>
 
            <!-- Icons (Globe, Search) (Desktop) -->
            <div class="desktop-icons" style="display: flex; align-items: center; gap: 20px; color: #1D1D1D;">
                <!-- Language Selector / Globe -->
                <a href="#" style="color: #1D1D1D; display: flex; align-items: center; justify-content: center; transition: color 0.2s; text-decoration: none;" onmouseover="this.style.color='#256D4A'" onmouseout="this.style.color='#1D1D1D'">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><path d="M12 2a14.5 14.5 0 0 0 0 20 14.5 14.5 0 0 0 0-20"/><path d="M2 12h20"/></svg>
                </a>
                <!-- Search Button -->
                <a href="#" style="color: #1D1D1D; display: flex; align-items: center; justify-content: center; transition: color 0.2s; text-decoration: none;" onmouseover="this.style.color='#256D4A'" onmouseout="this.style.color='#1D1D1D'">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg>
                </a>
            </div>
 
            <!-- Hamburger menu button (Mobile only) -->
            <button id="mobile-menu-toggle" class="mobile-menu-btn" style="display: none; width: 40px; height: 40px; align-items: center; justify-content: center; background: transparent; border: none; cursor: pointer; color: #1D1D1D; outline: none;">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="3" y1="12" x2="21" y2="12"/><line x1="3" y1="6" x2="21" y2="6"/><line x1="3" y1="18" x2="21" y2="18"/></svg>
            </button>
        </div>
    </div>
 
    <!-- Mobile Menu Overlay -->
    <div id="mobile-menu-overlay" class="mobile-menu-overlay" style="display: none; position: fixed; inset: 0; background: #F4F1EA; z-index: 9999; flex-direction: column; padding: 40px 32px; gap: 24px; box-sizing: border-box; overflow-y: auto;">
        <div style="display: flex; justify-content: space-between; align-items: center; border-bottom: 2px solid #1D1D1D; padding-bottom: 16px;">
            <img src="{{ asset('assets/images/resources/logo-2-walhi.png') }}" alt="WALHI Jawa Barat" style="height: 40px; object-fit: contain;" />
            <button id="mobile-menu-close" style="background: transparent; border: none; cursor: pointer; color: #1D1D1D; outline: none; padding: 0;">
                <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
            </button>
        </div>
        <nav style="display: flex; flex-direction: column; gap: 20px; font-family: Oswald, sans-serif; font-size: 20px; font-weight: 500; text-transform: uppercase; letter-spacing: 1px;">
            <a href="{{ route('home') }}" style="color: {{ $isHome ? '#256D4A' : '#1D1D1D' }}; text-decoration: none;">BERANDA</a>
            <a href="{{ route('blog') }}" style="color: {{ $isBlog ? '#256D4A' : '#1D1D1D' }}; text-decoration: none;">BLOG</a>
            <a href="{{ route('regulasi') }}" style="color: {{ $isRegulasi ? '#256D4A' : '#1D1D1D' }}; text-decoration: none;">REGULASI</a>
            
            <div style="display: flex; flex-direction: column; gap: 10px; border-top: 1px solid rgba(0,0,0,0.1); padding-top: 15px;">
                <span style="font-size: 13px; color: #666; font-family: Inter, sans-serif; font-weight: 700; letter-spacing: 0.5px;">PUBLIKASI</span>
                <a href="{{ route('siaran-pers') }}" style="color: {{ request()->routeIs('siaran-pers') ? '#256D4A' : '#1D1D1D' }}; text-decoration: none; padding-left: 12px; font-size: 18px;">Siaran Pers</a>
                <a href="{{ route('infografis') }}" style="color: {{ request()->routeIs('infografis') ? '#256D4A' : '#1D1D1D' }}; text-decoration: none; padding-left: 12px; font-size: 18px;">Infografis</a>
                <a href="{{ route('laporan-tahunan') }}" style="color: {{ request()->routeIs('laporan-tahunan') ? '#256D4A' : '#1D1D1D' }}; text-decoration: none; padding-left: 12px; font-size: 18px;">Laporan Tahunan</a>
            </div>
 
            <a href="{{ route('donasi') }}" style="color: {{ $isDonasi ? '#256D4A' : '#D95C3F' }}; text-decoration: none; border-top: 1px solid rgba(0,0,0,0.1); padding-top: 15px; font-weight: 700;">DUKUNG KAMI</a>
            <a href="{{ route('about') }}" style="color: {{ $isAbout ? '#256D4A' : '#1D1D1D' }}; text-decoration: none; border-top: 1px solid rgba(0,0,0,0.1); padding-top: 15px;">TENTANG KAMI</a>
        </nav>
    </div>
 
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const toggleBtn = document.getElementById('mobile-menu-toggle');
            const closeBtn = document.getElementById('mobile-menu-close');
            const overlay = document.getElementById('mobile-menu-overlay');
 
            if (toggleBtn && closeBtn && overlay) {
                toggleBtn.addEventListener('click', () => {
                    overlay.style.display = 'flex';
                    document.body.style.overflow = 'hidden';
                });
 
                closeBtn.addEventListener('click', () => {
                    overlay.style.display = 'none';
                    document.body.style.overflow = '';
                });
            }
        });
    </script>
</header>
