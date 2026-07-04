<header style="width: 100%; z-index: 1000; position: sticky; top: 0;">
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
                <a href="#" style="color: #F4F1EA; font-size: 12px; font-family: Inter, sans-serif; text-decoration: none; opacity: 0.8; transition: opacity 0.2s;" onmouseover="this.style.opacity=1" onmouseout="this.style.opacity=0.8">Facebook</a>
                <span style="color: #256D4A; font-size: 16px; font-family: Inter, sans-serif; user-select: none;">|</span>
                <a href="#" style="color: #F4F1EA; font-size: 12px; font-family: Inter, sans-serif; text-decoration: none; opacity: 0.8; transition: opacity 0.2s;" onmouseover="this.style.opacity=1" onmouseout="this.style.opacity=0.8">Twitter</a>
                <span style="color: #256D4A; font-size: 16px; font-family: Inter, sans-serif; user-select: none;">|</span>
                <a href="#" style="color: #F4F1EA; font-size: 12px; font-family: Inter, sans-serif; text-decoration: none; opacity: 0.8; transition: opacity 0.2s;" onmouseover="this.style.opacity=1" onmouseout="this.style.opacity=0.8">Instagram</a>
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

            <!-- Navigation Links -->
            <nav style="display: flex; align-items: center; justify-content: space-between; width: 599.9px; height: 37px; position: relative;">
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

            <!-- Icons (Globe, Search) -->
            <div style="display: flex; align-items: center; gap: 20px; color: #1D1D1D;">
                <!-- Language Selector / Globe -->
                <a href="#" style="color: #1D1D1D; display: flex; align-items: center; justify-content: center; transition: color 0.2s; text-decoration: none;" onmouseover="this.style.color='#256D4A'" onmouseout="this.style.color='#1D1D1D'">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><path d="M12 2a14.5 14.5 0 0 0 0 20 14.5 14.5 0 0 0 0-20"/><path d="M2 12h20"/></svg>
                </a>
                <!-- Search Button -->
                <a href="#" style="color: #1D1D1D; display: flex; align-items: center; justify-content: center; transition: color 0.2s; text-decoration: none;" onmouseover="this.style.color='#256D4A'" onmouseout="this.style.color='#1D1D1D'">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg>
                </a>
            </div>
        </div>
    </div>
</header>
