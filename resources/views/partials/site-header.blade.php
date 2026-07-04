<header style="width: 100%;">
    @php
        $isHome = request()->routeIs('home');
        $isBlog = request()->routeIs('blog');
        $isAbout = request()->routeIs('about');
        $isRegulasi = request()->routeIs('regulasi');
        $isPublikasi = request()->routeIs('siaran-pers') || request()->routeIs('infografis') || request()->routeIs('laporan-tahunan');
        $isDonasi = request()->routeIs('donasi');

        $navLinkStyle = function (bool $active): string {
            return 'left: 0; top: 8px; position: absolute; color: '.($active ? '#256D4A' : '#1D1D1D').'; font-size: 14px; font-family: Oswald, sans-serif; font-weight: 500; text-transform: uppercase; line-height: 21px; letter-spacing: 0.70px; word-wrap: break-word; text-decoration: none;';
        };

        $navUnderlineStyle = function (bool $active): string {
            return 'width: 100%; height: 2px; left: 0; top: 35px; position: absolute; background: '.($active ? '#256D4A' : 'transparent').';';
        };

        $navChevronStyle = function (bool $active): string {
            return 'width: 7px; height: 3.5px; left: 3.5px; top: 5.25px; position: absolute; outline: 1.17px '.($active ? '#256D4A' : '#1D1D1D').' solid; outline-offset: -0.58px;';
        };
    @endphp
    <div style="align-self: stretch; height: 41px; padding-bottom: 1px; padding-left: 95px; padding-right: 95px; background: #1D1D1D; border-bottom: 1px #256D4A solid; flex-direction: column; justify-content: flex-start; align-items: flex-start; display: flex;">
        <div style="width: 1280px; height: 40px; padding-left: 32px; padding-right: 32px; justify-content: space-between; align-items: center; display: inline-flex;">
            <div style="width: 255.16px; height: 18px; position: relative;">
                <div style="left: 0; top: 0.5px; position: absolute; color: #F4F1EA; font-size: 12px; font-family: Inter, sans-serif; font-weight: 500; line-height: 18px; word-wrap: break-word;">Kampanye Darurat: Hentikan Tambang Ilegal</div>
            </div>
            <div style="width: 225.83px; height: 24px; justify-content: flex-start; align-items: center; gap: 16px; display: flex;">
                <div style="width: 55.71px; height: 18px; position: relative;"><div style="left: 0; top: 0.5px; position: absolute; color: #F4F1EA; font-size: 12px; font-family: Inter, sans-serif; font-weight: 400; line-height: 18px; word-wrap: break-word;">Facebook</div></div>
                <div style="width: 5.32px; height: 24px; position: relative;"><div style="left: 0; top: -1px; position: absolute; color: #256D4A; font-size: 16px; font-family: Inter, sans-serif; font-weight: 400; line-height: 24px; word-wrap: break-word;">|</div></div>
                <div style="width: 38.98px; height: 18px; position: relative;"><div style="left: 0; top: 0.5px; position: absolute; color: #F4F1EA; font-size: 12px; font-family: Inter, sans-serif; font-weight: 400; line-height: 18px; word-wrap: break-word;">Twitter</div></div>
                <div style="width: 5.32px; height: 24px; position: relative;"><div style="left: 0; top: -1px; position: absolute; color: #256D4A; font-size: 16px; font-family: Inter, sans-serif; font-weight: 400; line-height: 24px; word-wrap: break-word;">|</div></div>
                <div style="flex: 1 1 0; height: 18px; position: relative;"><div style="left: 0; top: 0.5px; position: absolute; color: #F4F1EA; font-size: 12px; font-family: Inter, sans-serif; font-weight: 400; line-height: 18px; word-wrap: break-word;">Instagram</div></div>
            </div>
        </div>
    </div>

    <div style="align-self: stretch; height: 80px; padding-left: 95px; padding-right: 95px; background: #F4F1EA; box-shadow: 0px 1px 2px -1px rgba(0, 0, 0, 0.10), 0px 1px 3px rgba(0, 0, 0, 0.10); flex-direction: column; justify-content: flex-start; align-items: flex-start; display: flex;">
        <div style="width: 1280px; height: 80px; padding-left: 32px; padding-right: 32px; justify-content: space-between; align-items: center; display: inline-flex;">
            <div style="width: 80.13px; height: 48px; justify-content: flex-start; align-items: center; display: flex;">
                <img src="{{ asset('assets/images/resources/logo-2.jpg') }}" alt="WALHI Jawa Barat" style="flex: 1 1 0; height: 48px; position: relative; object-fit: contain;" />
            </div>
            <div style="width: 599.9px; height: 37px; position: relative;">
                <div style="width: 56.48px; height: 37px; left: 0; top: 0; position: absolute;"><a href="{{ route('home') }}" style="{{ $navLinkStyle($isHome) }}">BERANDA</a>@if ($isHome)<div style="width: 56.48px; height: 2px; left: 0; top: 35px; position: absolute; background: #256D4A;"></div>@endif</div>
                <div style="width: 32.07px; height: 37px; left: 88.48px; top: 0; position: absolute;"><a href="{{ route('blog') }}" style="{{ $navLinkStyle($isBlog) }}">BLOG</a>@if ($isBlog)<div style="width: 32.07px; height: 2px; left: 0; top: 35px; position: absolute; background: #256D4A;"></div>@endif</div>
                <div style="width: 59.1px; height: 37px; left: 152.55px; top: 0; position: absolute;">
                    <a href="{{ route('regulasi') }}" style="{{ $navLinkStyle($isRegulasi) }}">REGULASI</a>
                    @if ($isRegulasi)<div style="width: 59.1px; height: 2px; left: 0; top: 35px; position: absolute; background: #256D4A;"></div>@endif
                </div>
                <details class="site-nav-dropdown" style="width: 82.61px; height: 37px; left: 243.65px; top: 0; position: absolute;">
                    <summary style="width: 82.61px; height: 37px; position: relative; display: block; color: {{ $isPublikasi ? '#256D4A' : '#1D1D1D' }}; cursor: pointer; list-style: none;">
                        <span style="left: 0; top: 8px; position: absolute; text-align: center; color: {{ $isPublikasi ? '#256D4A' : '#1D1D1D' }}; font-size: 14px; font-family: Oswald, sans-serif; font-weight: 500; text-transform: uppercase; line-height: 21px; letter-spacing: 0.70px; word-wrap: break-word; text-decoration: none;">PUBLIKASI</span>
                    </summary>
                    <div style="width: 14px; height: 14px; left: 68.61px; top: 11.5px; position: absolute; overflow: hidden;"><div style="width: 7px; height: 3.5px; left: 3.5px; top: 5.25px; position: absolute; outline: 1.17px {{ $isPublikasi ? '#256D4A' : '#1D1D1D' }} solid; outline-offset: -0.58px;"></div></div>
                    <div class="site-nav-dropdown-panel" style="width: 492px; left: -160px; top: 37px; position: absolute; background: #F4F1EA; border-top: 4px solid #256D4A; box-shadow: 0 18px 40px rgba(0, 0, 0, 0.14); z-index: 30;">
                        <a href="{{ route('siaran-pers') }}" style="display: flex; align-items: center; min-height: 74px; padding: 0 32px; color: #1D1D1D; font-size: 24px; font-family: Inter, sans-serif; font-weight: 700; line-height: 32px; text-decoration: none; border-bottom: 1px solid rgba(37, 109, 74, 0.18); background: {{ request()->routeIs('siaran-pers') ? '#FFFFFF' : '#F4F1EA' }};">Siaran Pers</a>
                        <a href="{{ route('infografis') }}" style="display: flex; align-items: center; min-height: 74px; padding: 0 32px; color: #1D1D1D; font-size: 24px; font-family: Inter, sans-serif; font-weight: 700; line-height: 32px; text-decoration: none; border-bottom: 1px solid rgba(37, 109, 74, 0.18); background: {{ request()->routeIs('infografis') ? '#FFFFFF' : '#F4F1EA' }};">Infografis</a>
                        <a href="{{ route('laporan-tahunan') }}" style="display: flex; align-items: center; min-height: 74px; padding: 0 32px; color: #1D1D1D; font-size: 24px; font-family: Inter, sans-serif; font-weight: 700; line-height: 32px; text-decoration: none; background: {{ request()->routeIs('laporan-tahunan') ? '#FFFFFF' : '#F4F1EA' }};">Laporan Tahunan</a>
                    </div>
                    @if ($isPublikasi)<div style="width: 82.61px; height: 2px; left: 0; top: 35px; position: absolute; background: #256D4A;"></div>@endif
                </details>
                <div style="width: 103.84px; height: 37px; left: 358.26px; top: 0; position: absolute;">
                    <a href="{{ route('donasi') }}" style="left: 0; top: 8px; position: absolute; text-align: center; color: {{ $isDonasi ? '#256D4A' : '#1D1D1D' }}; font-size: 14px; font-family: Oswald, sans-serif; font-weight: 500; text-transform: uppercase; line-height: 21px; letter-spacing: 0.70px; word-wrap: break-word; text-decoration: none;">DUKUNG KAMI</a>
                    <div style="width: 14px; height: 14px; left: 89.84px; top: 11.5px; position: absolute; overflow: hidden;"><div style="width: 7px; height: 3.5px; left: 3.5px; top: 5.25px; position: absolute; outline: 1.17px {{ $isDonasi ? '#256D4A' : '#1D1D1D' }} solid; outline-offset: -0.58px;"></div></div>
                    @if ($isDonasi)<div style="width: 103.84px; height: 2px; left: 0; top: 35px; position: absolute; background: #256D4A;"></div>@endif
                </div>
                <div style="width: 105.8px; height: 37px; left: 494.1px; top: 0; position: absolute;">
                    <a href="{{ route('about') }}" style="{{ $navLinkStyle($isAbout) }} text-align: center;">TENTANG KAMI</a>
                    <div style="width: 14px; height: 14px; left: 91.8px; top: 11.5px; position: absolute; overflow: hidden;"><div style="{{ $navChevronStyle($isAbout) }}"></div></div>
                    @if ($isAbout)<div style="{{ $navUnderlineStyle(true) }}"></div>@endif
                </div>
            </div>
            <div style="width: 88px; height: 36px; justify-content: flex-start; align-items: center; gap: 16px; display: flex;">
                <div style="width: 36px; height: 36px; padding-top: 8px; padding-left: 8px; padding-right: 8px; flex-direction: column; justify-content: flex-start; align-items: flex-start; display: inline-flex;">
                    <div style="align-self: stretch; height: 20px; position: relative; overflow: hidden;">
                        <div style="width: 16.67px; height: 16.67px; left: 1.67px; top: 1.67px; position: absolute; outline: 1.67px #1D1D1D solid; outline-offset: -0.83px;"></div>
                        <div style="width: 6.67px; height: 16.67px; left: 6.67px; top: 1.67px; position: absolute; outline: 1.67px #1D1D1D solid; outline-offset: -0.83px;"></div>
                    </div>
                </div>
                <div style="flex: 1 1 0; height: 36px; padding-top: 8px; padding-left: 8px; padding-right: 8px; flex-direction: column; justify-content: flex-start; align-items: flex-start; display: inline-flex;">
                    <div style="align-self: stretch; height: 20px; position: relative; overflow: hidden;">
                        <div style="width: 13.33px; height: 13.33px; left: 2.5px; top: 2.5px; position: absolute; outline: 1.67px #1D1D1D solid; outline-offset: -0.83px;"></div>
                        <div style="width: 3.58px; height: 3.58px; left: 13.92px; top: 13.92px; position: absolute; outline: 1.67px #1D1D1D solid; outline-offset: -0.83px;"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
