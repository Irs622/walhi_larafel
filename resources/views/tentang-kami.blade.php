<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        @include('partials.seo-meta', ['title' => 'Profil & Sejarah - WALHI Jawa Barat'])

        <!-- Google Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Anton&family=Bebas+Neue&family=Inter:wght@400;500;600;700;800&family=Oswald:wght@400;500;600;700&display=swap" rel="stylesheet">
        
        <style>
            [x-cloak] { display: none !important; }
        </style>
        
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="bg-[#F4F1EA] text-[#1D1D1D] font-sans antialiased overflow-x-hidden">
        @include('partials.site-header')

        <!-- Hero Section -->
        <section class="bg-[#1D1D1D] border-b-4 border-[#256D4A] py-16 px-4 md:px-8 lg:px-16">
            <div class="max-w-6xl mx-auto">
                <nav class="flex items-center gap-2 text-xs font-semibold uppercase tracking-wider text-[#F4F1EA] mb-6">
                    <a href="{{ route('home') }}" class="hover:text-[#5C8D59]">Beranda</a>
                    <span class="text-[#256D4A]">/</span>
                    <span class="text-[#5C8D59]">Tentang Kami</span>
                </nav>
                
                <h1 class="text-5xl md:text-7xl lg:text-8xl font-heading text-[#F4F1EA] uppercase tracking-wider mb-4">
                    PROFIL & SEJARAH
                </h1>
                <p class="text-[#5C8D59] text-lg md:text-xl font-medium max-w-2xl mb-6">
                    Wahana Lingkungan Hidup Indonesia — Jawa Barat
                </p>
                <div class="w-32 h-2 bg-[#D95C3F]"></div>
            </div>
        </section>

        <!-- Main Content Area -->
        <main class="max-w-6xl mx-auto py-12 px-4 md:px-8 lg:px-16">
            
            <!-- Navigation Tabs (Neo-Brutalist Style) -->
            <div class="flex flex-col sm:flex-row gap-3 sm:gap-4 justify-center mb-12">
                <button type="button" 
                        onclick="setTentangTab('profil')"
                        id="tab-btn-profil" 
                        style="background-color: #256D4A; color: #F4F1EA;"
                        class="tab-btn px-6 py-3 border-4 border-[#1D1D1D] font-heading text-base md:text-lg uppercase tracking-wider transition-all shadow-[4px_4px_0px_0px_#1D1D1D] active:translate-x-[2px] active:translate-y-[2px] cursor-pointer outline-none select-none">
                    Profil & Anggota
                </button>
                <button type="button" 
                        onclick="setTentangTab('visi-misi')"
                        id="tab-btn-visi-misi" 
                        style="background-color: #FFFFFF; color: #1D1D1D;"
                        class="tab-btn px-6 py-3 border-4 border-[#1D1D1D] font-heading text-base md:text-lg uppercase tracking-wider transition-all shadow-[4px_4px_0px_0px_#1D1D1D] hover:bg-[#F4F1EA] active:translate-x-[2px] active:translate-y-[2px] cursor-pointer outline-none select-none">
                    Visi, Misi & Nilai
                </button>
                <button type="button" 
                        onclick="setTentangTab('pengurus')"
                        id="tab-btn-pengurus" 
                        style="background-color: #FFFFFF; color: #1D1D1D;"
                        class="tab-btn px-6 py-3 border-4 border-[#1D1D1D] font-heading text-base md:text-lg uppercase tracking-wider transition-all shadow-[4px_4px_0px_0px_#1D1D1D] hover:bg-[#F4F1EA] active:translate-x-[2px] active:translate-y-[2px] cursor-pointer outline-none select-none">
                    Kepengurusan & Sejarah
                </button>
            </div>

            <!-- TAB 1: PROFIL & ANGGOTA -->
            <div id="tab-content-profil" class="tentang-tab-panel flex flex-col gap-12" style="display: flex;">
                <!-- Tentang WALHI -->
                <section class="bg-white border-4 border-[#1D1D1D] shadow-[8px_8px_0px_0px_#1D1D1D] p-8 md:p-12">
                    <div class="flex items-center bg-[#256D4A] text-white px-4 py-1.5 text-xs font-bold uppercase tracking-[0.06em] w-fit mb-6">
                        Apa dan Siapa WALHI Jawa Barat?
                    </div>
                    <h3 class="text-3xl md:text-4xl font-heading text-[#1D1D1D] uppercase tracking-wide mb-6">
                        Organisasi Lingkungan Hidup Independen Terbesar di Indonesia
                    </h3>
                    <p class="text-base md:text-lg leading-relaxed text-[#1D1D1D]/90 mb-6">
                        WALHI adalah organisasi lingkungan hidup yang independen, non-profit dan terbesar di Indonesia. Di tingkat internasional, WALHI berkampanye melalui jaringan <strong>Friends of the Earth International</strong> yang beranggotakan 71 organisasi akar rumput di 70 negara, 15 organisasi afiliasi, dan lebih dari 2 juta anggota individu dan pendukung di seluruh dunia.
                    </p>
                    <p class="text-base md:text-lg leading-relaxed text-[#1D1D1D]/90">
                        WALHI Jawa Barat hadir secara aktif mengkonsolidasikan gerakan rakyat di tingkat lokal Jawa Barat, mengadvokasi kebijakan tata ruang dan energi, serta mendampingi masyarakat tapak yang hak ekologisnya terancam.
                    </p>
                </section>

                <!-- Latar Belakang -->
                <section class="grid grid-cols-1 lg:grid-cols-12 gap-8">
                    <div class="lg:col-span-7 bg-[#1D1D1D] text-[#F4F1EA] border-4 border-[#1D1D1D] shadow-[8px_8px_0px_0px_#256D4A] p-8 md:p-10">
                        <h4 class="font-heading text-3xl uppercase text-[#5C8D59] mb-6">Latar Belakang</h4>
                        <div class="space-y-4 text-sm md:text-base leading-relaxed text-[#F4F1EA]/90">
                            <p>
                                WALHI Jawa Barat sadar kecenderungan kerusakan lingkungan hidup dan ekosistem semakin masif dan kompleks baik di pedesaan maupun perkotaan. Memburuknya kondisi lingkungan hidup secara terbuka diakui mempengaruhi dinamika sosial politik dan sosial ekonomi masyarakat baik di tingkat komunitas, regional, maupun nasional.
                            </p>
                            <p>
                                Pada gilirannya krisis lingkungan hidup secara langsung mengancam kenyamanan, keselamatan dan meningkatkan kerentanan kehidupan setiap warga negara. Kerusakan lingkungan hidup telah hadir di rumah-rumah kita, seperti kelangkaan air bersih, pencemaran air dan udara, banjir dan kekeringan, serta energi yang semakin mahal. Siapa yang bertanggung jawab atas kerusakan lingkungan hidup kian sulit dipastikan karena penyebabnya sendiri saling bertautan baik antarsektor, antaraktor, antarinstitusi, antarwilayah dan bahkan antarnegara.
                            </p>
                        </div>
                    </div>

                    <div class="lg:col-span-5 bg-[#D95C3F] text-white border-4 border-[#1D1D1D] shadow-[8px_8px_0px_0px_#1D1D1D] p-8 md:p-10 flex flex-col justify-between">
                        <div>
                            <h4 class="font-heading text-3xl uppercase text-white mb-6">Gerakan Rakyat</h4>
                            <p class="text-sm md:text-base leading-relaxed mb-6">
                                Untuk menjamin keberlanjutan kehidupan generasi mendatang dibutuhkan gerakan sosial yang kuat dan meluas. Generasi mendatang berhak atas lingkungan hidup yang baik dan sehat. Untuk itu generasi sekarang bertanggungjawab mempertahankan dan meningkatkan kualitas lingkungan yang lebih baik.
                            </p>
                        </div>
                        <div class="border-t border-white/30 pt-4 text-xs font-semibold leading-relaxed">
                            Kampanye penyelamatan lingkungan WALHI Jawa Barat dibantu oleh <strong>SAHABAT WALHI Jawa Barat</strong>, simpul sayap gerakan yang terintegrasi secara langsung dalam kerja advokasi di tapak.
                        </div>
                    </div>
                </section>

                <!-- Jangkauan Wilayah & 29 Organisasi Anggota -->
                <section class="bg-white border-4 border-[#1D1D1D] shadow-[8px_8px_0px_0px_#1D1D1D] p-8 md:p-12">
                    <div class="mb-8">
                        <div class="bg-[#8B6B4A] text-white px-4 py-1.5 text-xs font-bold uppercase tracking-[0.06em] w-fit mb-4">
                            Jaringan Organisasi
                        </div>
                        <h3 class="text-3xl font-heading text-[#1D1D1D] uppercase tracking-wide">
                            Hadir di 13 Kabupaten/Kota dengan 29 Lembaga Anggota
                        </h3>
                        <p class="text-base text-[#1D1D1D]/80 mt-2">
                            Anggota-anggota resmi WALHI Jawa Barat yang secara aktif mengorganisir gerakan lingkungan di tingkat lokal:
                        </p>
                    </div>

                    @php
                        $members = [
                            ['name' => 'YPBB', 'city' => 'Kota Bandung'],
                            ['name' => 'Argawilis ISBI', 'city' => 'Kota Bandung'],
                            ['name' => 'FK3I Jawa Barat', 'city' => 'Kota Bandung'],
                            ['name' => 'Mapenta Unisba', 'city' => 'Kota Bandung'],
                            ['name' => 'HMTL Unpas', 'city' => 'Kota Bandung'],
                            ['name' => 'Pakuan', 'city' => 'Kota Bandung'],
                            ['name' => 'Poklan', 'city' => 'Kota Bandung'],
                            ['name' => 'LPTT', 'city' => 'Kota Bandung'],
                            ['name' => 'Katurnagari', 'city' => 'Kota Bandung'],
                            ['name' => 'PPMK-SA', 'city' => 'Kota Bandung'],
                            ['name' => 'Swadaya Muda', 'city' => 'Kota Bandung'],
                            ['name' => 'LKrapin', 'city' => 'Kota Bandung'],
                            ['name' => 'PSDK', 'city' => 'Kab. Bandung'],
                            ['name' => 'Lencana', 'city' => 'Kab. Bandung'],
                            ['name' => 'MPSA', 'city' => 'Kab. Bandung'],
                            ['name' => 'Siklus', 'city' => 'Kab. Indramayu'],
                            ['name' => 'Paguyuban Bale Rahayat', 'city' => 'Kab. Banjar'],
                            ['name' => 'Rekapala', 'city' => 'Kab. Garut'],
                            ['name' => 'SPP', 'city' => 'Kab. Garut'],
                            ['name' => 'FPPMG', 'city' => 'Kab. Garut'],
                            ['name' => 'UKL Fapet Unpad', 'city' => 'Kab. Sumedang'],
                            ['name' => 'Himikan Unpad', 'city' => 'Kab. Sumedang'],
                            ['name' => 'Palamus', 'city' => 'Kab. Subang'],
                            ['name' => 'Forum Akar', 'city' => 'Kab. Banjar'],
                            ['name' => 'FMPL', 'city' => 'Kab. Bogor'],
                            ['name' => 'Farmaci', 'city' => 'Kab. Ciamis'],
                            ['name' => 'Mahakupala', 'city' => 'Kab. Kuningan'],
                            ['name' => 'Blue Ocean', 'city' => 'Kab. Cirebon'],
                            ['name' => 'FMPR', 'city' => 'Kab. Tasikmalaya'],
                        ];
                    @endphp

                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
                        @foreach($members as $member)
                            <div class="p-4 bg-[#F4F1EA] border-2 border-[#1D1D1D] shadow-[4px_4px_0px_0px_#1D1D1D] hover:translate-x-[-2px] hover:translate-y-[-2px] hover:shadow-[6px_6px_0px_0px_#256D4A] transition-all">
                                <div class="font-heading text-lg text-[#1D1D1D] uppercase">{{ $member['name'] }}</div>
                                <div class="text-xs font-semibold text-[#256D4A] uppercase mt-1 tracking-wider">{{ $member['city'] }}</div>
                            </div>
                        @endforeach
                    </div>
                </section>
            </div>

            <!-- TAB 2: VISI, MISI & NILAI -->
            <div id="tab-content-visi-misi" class="tentang-tab-panel flex flex-col gap-12" style="display: none;">
                <!-- Visi & Motto -->
                <section class="grid grid-cols-1 lg:grid-cols-12 gap-8">
                    <!-- Visi -->
                    <div class="lg:col-span-7 bg-[#256D4A] text-[#F4F1EA] border-4 border-[#1D1D1D] shadow-[8px_8px_0px_0px_#1D1D1D] p-8 md:p-12 relative flex flex-col justify-center">
                        <span class="absolute -top-4 left-6 bg-[#1D1D1D] text-[#5C8D59] font-bold text-xs uppercase tracking-widest px-4 py-2 border-2 border-[#F4F1EA]">
                            Visi Kami
                        </span>
                        <h2 class="text-3xl md:text-4xl lg:text-5xl font-heading uppercase tracking-wide leading-tight mt-4">
                            Terwujudnya gerakan rakyat yang mampu mempertahankan fungsi sumber-sumber kehidupan dan keberlanjutan ekosistem di Jawa Barat
                        </h2>
                    </div>

                    <!-- Motto -->
                    <div class="lg:col-span-5 bg-[#D95C3F] text-white border-4 border-[#1D1D1D] shadow-[8px_8px_0px_0px_#256D4A] p-8 md:p-12 flex flex-col justify-center text-center">
                        <span class="bg-[#1D1D1D] text-white font-bold text-xs uppercase tracking-widest px-4 py-1.5 w-fit mx-auto mb-4 border border-white">
                            Motto Perjuangan
                        </span>
                        <h3 class="text-4xl md:text-5xl font-heading uppercase tracking-wider leading-tight">
                            PULIHKAN EKOLOGI JAWA BARAT,
                        </h3>
                        <h3 class="text-3xl md:text-4xl font-label uppercase tracking-widest text-[#1D1D1D] mt-2">
                            UTAMAKAN KESELAMATAN RAKYAT!
                        </h3>
                    </div>
                </section>

                <!-- Misi -->
                <section class="bg-white border-4 border-[#1D1D1D] shadow-[8px_8px_0px_0px_#1D1D1D] p-8 md:p-12">
                    <div class="text-center mb-10">
                        <span class="inline-block bg-[#256D4A] text-white font-bold text-xs uppercase tracking-widest px-4 py-2 mb-4">
                            Misi Organisasi
                        </span>
                        <h3 class="text-3xl md:text-4xl font-heading text-[#1D1D1D] uppercase tracking-wide">
                            4 Langkah Kerja Nyata
                        </h3>
                    </div>
                    
                    @php
                        $misiItems = [
                            'WALHI Jawa Barat menjadi organisasi advokasi lingkungan berbasis masyarakat.',
                            'Mendorong rakyat memiliki akses dan kontrol terhadap sumber-sumber kehidupan di Jawa Barat.',
                            'Memastikan adanya jaminan keselamatan dan pelestarian keanekaragaman hayati.',
                            'Mendorong kebijakan pemerintah yang berpihak pada rakyat.'
                        ];
                    @endphp

                    <div class="grid md:grid-cols-2 gap-6">
                        @foreach ($misiItems as $index => $misi)
                            <div class="flex gap-4 p-6 bg-[#F4F1EA] border-2 border-[#1D1D1D] shadow-[4px_4px_0px_0px_#1D1D1D]">
                                <div class="flex-shrink-0 w-12 h-12 bg-[#1D1D1D] flex justify-center items-center text-[#256D4A] text-2xl font-heading">
                                    {{ $index + 1 }}
                                </div>
                                <div class="flex-1 text-[#1D1D1D] text-base font-semibold leading-relaxed">
                                    {{ $misi }}
                                </div>
                            </div>
                        @endforeach
                    </div>
                </section>

                <!-- Nilai Perjuangan WALHI -->
                <section class="bg-[#1D1D1D] text-[#F4F1EA] border-4 border-[#1D1D1D] shadow-[8px_8px_0px_0px_#256D4A] p-8 md:p-12">
                    <div class="text-center mb-12">
                        <span class="inline-block bg-[#D95C3F] text-white font-bold text-xs uppercase tracking-widest px-4 py-2 mb-4">
                            Nilai-Nilai Perjuangan
                        </span>
                        <h3 class="text-3xl md:text-4xl font-heading text-white uppercase tracking-wide">
                            10 Prinsip Dasar Gerakan WALHI
                        </h3>
                        <p class="text-sm text-[#F4F1EA]/70 mt-2 max-w-2xl mx-auto">
                            Untuk melawan segala bentuk penindasan atas rakyat jelata dan sumber-sumber kehidupannya, WALHI memegang teguh nilai perjuangan berikut:
                        </p>
                    </div>

                    @php
                        $nilai = [
                            ['title' => 'Demokrasi', 'desc' => 'Seluruh rakyat harus terlibat dalam proses pengambilan keputusan apa pun yang akan berdampak bagi keberlanjutan kehidupan rakyat.'],
                            ['title' => 'Keadilan antar Generasi', 'desc' => 'Semua generasi baik sekarang maupun mendatang berhak atas lingkungan yang berkualitas dan sehat.'],
                            ['title' => 'Keadilan Gender', 'desc' => 'Semua orang berhak memperoleh kehidupan dan lingkungan hidup yang layak tanpa membedakan jenis kelamin, agama dan status sosial.'],
                            ['title' => 'Penghormatan Terhadap Makhluk Hidup', 'desc' => 'Semua makhluk hidup baik manusia maupun non manusia memiliki hak dihormati dan dihargai.'],
                            ['title' => 'Persamaan Hak Masyarakat Adat', 'desc' => 'Masyarakat adat di seluruh pelosok nusantara berhak menentukan nasibnya sendiri untuk berkembang sesuai kebudayaannya.'],
                            ['title' => 'Solidaritas Sosial', 'desc' => 'Semua orang memiliki hak sipil, politik, ekonomi, sosial dan budaya yang sama.'],
                            ['title' => 'Anti Kekerasan', 'desc' => 'Negara dilarang melakukan kekerasan fisik dan non fisik kepada seluruh rakyat.'],
                            ['title' => 'Keterbukaan', 'desc' => 'Seluruh rakyat berhak atas semua informasi berkenaan dengan kebijakan dan program yang akan mempengaruhi kehidupannya.'],
                            ['title' => 'Keswadayaan', 'desc' => 'Semua pihak diharapkan mendukung keswadayaan politik dan ekonomi masyarakat.'],
                            ['title' => 'Profesionalisme', 'desc' => 'Semua pihak hendaknya bekerja secara profesional, sepenuh hati, efektif, sistematik dan tetap mengembangkan semangat kolektivitas.']
                        ];
                    @endphp

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 text-brand-dark">
                        @foreach ($nilai as $index => $item)
                            <div class="bg-white border-2 border-[#1D1D1D] p-6 shadow-[4px_4px_0px_0px_#D95C3F] hover:translate-x-[-2px] hover:translate-y-[-2px] hover:shadow-[6px_6px_0px_0px_#D95C3F] transition-all">
                                <div class="flex items-center gap-4 mb-2">
                                    <div class="w-8 h-8 bg-[#1D1D1D] text-white flex items-center justify-center font-heading text-sm">
                                        {{ sprintf("%02d", $index + 1) }}
                                    </div>
                                    <h4 class="font-heading text-lg uppercase tracking-wide">{{ $item['title'] }}</h4>
                                </div>
                                <p class="text-xs md:text-sm text-[#1D1D1D]/80 leading-relaxed">
                                    {{ $item['desc'] }}
                                </p>
                            </div>
                        @endforeach
                    </div>
                </section>

                <!-- Program Strategis -->
                <section class="bg-white border-4 border-[#1D1D1D] shadow-[8px_8px_0px_0px_#1D1D1D] p-8 md:p-12">
                    <div class="text-center mb-10">
                        <span class="inline-block bg-[#8B6B4A] text-white font-bold text-xs uppercase tracking-widest px-4 py-2 mb-4">
                            Strategi Perjuangan
                        </span>
                        <h3 class="text-3xl md:text-4xl font-heading text-[#1D1D1D] uppercase tracking-wide">
                            6 Program Strategis Organisasi
                        </h3>
                    </div>

                    @php
                        $programs = [
                            'Mendorong Tata Kelola DAS yang berkelanjutan dan berkeadilan.',
                            'Mendorong Kebijakan untuk menciptakan tata kelola energi yang terdesentralisasi.',
                            'Mendorong energi baru yang terbarukan yang tidak merampas hak ruang hidup.',
                            'Meningkatkan kesadaran publik terkait dampak energi kotor.',
                            'Mengkonsolidasikan posisi organisasi dalam menyikapi kebijakan-kebijakan infrastruktur yang berdampak terhadap alih fungsi lahan (Hutan, Urban, Pesisir Kelautan, Pertanian Pedesaan).',
                            'Mewujudkan WALHI Jawa Barat sebagai lembaga yang mandiri dan kompeten dalam melakukan kerja-kerja advokasi.'
                        ];
                    @endphp

                    <div class="space-y-4">
                        @foreach ($programs as $index => $program)
                            <div class="flex gap-4 p-5 bg-[#F4F1EA] border-2 border-[#1D1D1D] shadow-[4px_4px_0px_0px_#1D1D1D]">
                                <div class="flex-shrink-0 w-8 h-8 bg-[#256D4A] text-white flex items-center justify-center font-bold text-sm">
                                    {{ $index + 1 }}
                                </div>
                                <p class="text-[#1D1D1D] text-sm md:text-base font-semibold leading-relaxed">
                                    {{ $program }}
                                </p>
                            </div>
                        @endforeach
                    </div>
                </section>
            </div>

            <!-- TAB 3: KEPENGURUSAN & SEJARAH -->
            <div id="tab-content-pengurus" class="tentang-tab-panel flex flex-col gap-12" style="display: none;">
                <!-- Sejarah Capaian -->
                <section class="bg-white border-4 border-[#1D1D1D] shadow-[8px_8px_0px_0px_#1D1D1D] p-8 md:p-12">
                    <div class="mb-8">
                        <span class="inline-block bg-[#256D4A] text-white font-bold text-xs uppercase tracking-widest px-4 py-2 mb-4">
                            Sejarah Gerakan
                        </span>
                        <h3 class="text-3xl font-heading text-[#1D1D1D] uppercase tracking-wide">
                            Perjalanan Gerakan Sejak 15 Oktober 1980
                        </h3>
                        <p class="text-base text-[#1D1D1D]/80 mt-2">
                            Semenjak dibentuk pada 15 Oktober 1980, WALHI bersama kelompok masyarakat sipil lainnya telah:
                        </p>
                    </div>

                    @php
                        $achievements = [
                            'Menumbuhkan kesadaran lingkungan hidup dan mempromosikan kedaulatan rakyat dalam pengelolaan sumber-sumber kehidupan.',
                            'Memelopori gerakan lingkungan hidup di Indonesia dan menjadi bagian integral dari gerakan lingkungan hidup global.',
                            'Mengangkat masalah dari tingkat rakyat paling bawah sampai ke proses pembuatan kebijakan di tingkat lokal, regional dan nasional.',
                            'Mendukung perjuangan puluhan kelompok masyarakat untuk menegaskan hak mereka atas lingkungan dan pengelolaan sumber-sumber kehidupan.',
                            'Menjadi narasumber krusial untuk persoalan lingkungan hidup di Indonesia bagi media, industri dan lembaga pemerintah.'
                        ];
                    @endphp

                    <div class="space-y-4">
                        @foreach ($achievements as $ach)
                            <div class="flex gap-4 items-start p-4 bg-[#F4F1EA] border border-[#1D1D1D]">
                                <div class="w-6 h-6 bg-[#D95C3F] text-white flex items-center justify-center shrink-0 mt-0.5">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><path d="M20 6 9 17l-5-5"/></svg>
                                </div>
                                <p class="text-sm md:text-base text-[#1D1D1D] leading-relaxed">{{ $ach }}</p>
                            </div>
                        @endforeach
                    </div>
                </section>

                <!-- Struktur Kepengurusan -->
                <section class="bg-white border-4 border-[#1D1D1D] shadow-[8px_8px_0px_0px_#1D1D1D] p-8 md:p-12">
                    <div class="text-center mb-10">
                        <span class="inline-block bg-[#D95C3F] text-white font-bold text-xs uppercase tracking-widest px-4 py-2 mb-4">
                            Struktur Organisasi
                        </span>
                        <h3 class="text-3xl md:text-4xl font-heading text-[#1D1D1D] uppercase tracking-wide">
                            Kepengurusan WALHI Jawa Barat 2019-2023
                        </h3>
                    </div>

                    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
                        <!-- Eksekutif Daerah (7 Kolom) -->
                        <div class="lg:col-span-7 bg-[#F4F1EA] border-4 border-[#1D1D1D] p-6 shadow-[4px_4px_0px_0px_#1D1D1D]">
                            <h4 class="font-heading text-2xl uppercase border-b-2 border-[#1D1D1D] pb-2 mb-6 text-[#256D4A]">
                                1. Eksekutif Daerah
                            </h4>
                            
                            <div class="space-y-4">
                                <!-- Direktur -->
                                <div class="p-4 bg-white border-2 border-[#1D1D1D] shadow-[3px_3px_0px_0px_#1D1D1D]">
                                    <div class="text-xs uppercase font-bold text-[#D95C3F] tracking-wide">Direktur Eksekutif</div>
                                    <div class="font-heading text-2xl text-[#1D1D1D] mt-1">Meiki W Paendong</div>
                                </div>

                                <!-- Divisi-divisi -->
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                    <!-- Keuangan -->
                                    <div class="p-4 bg-white border border-[#1D1D1D] flex flex-col justify-between">
                                        <div>
                                             <div class="text-[10px] uppercase font-bold text-[#256D4A] tracking-wider">Divisi Keuangan</div>
                                            <div class="font-bold text-base mt-1">Dwi Retnastuti</div>
                                        </div>
                                        <div class="text-xs text-gray-500 mt-2 border-t border-gray-100 pt-1">Staf: Putri Rodhiyatul</div>
                                    </div>

                                    <!-- Pendidikan -->
                                    <div class="p-4 bg-white border border-[#1D1D1D]">
                                        <div class="text-[10px] uppercase font-bold text-[#256D4A] tracking-wider">Divisi Pendidikan & Kaderisasi</div>
                                        <div class="font-bold text-base mt-1">Haerudin Inas</div>
                                    </div>

                                    <!-- Advokasi -->
                                    <div class="p-4 bg-white border border-[#1D1D1D]">
                                        <div class="text-[10px] uppercase font-bold text-[#256D4A] tracking-wider">Divisi Advokasi & Kampanye</div>
                                        <div class="font-bold text-base mt-1">Wahyudin</div>
                                    </div>

                                    <!-- Pengembangan Program -->
                                    <div class="p-4 bg-white border border-[#1D1D1D] flex flex-col justify-between">
                                        <div>
                                            <div class="text-[10px] uppercase font-bold text-[#256D4A] tracking-wider">Divisi Pengembangan Program & Sumber Daya</div>
                                            <div class="font-bold text-base mt-1">Fauzi R Danial</div>
                                        </div>
                                        <div class="text-xs text-gray-500 mt-2 border-t border-gray-100 pt-1">Staf: Klistjart T Bawar</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Dewan Daerah (5 Kolom) -->
                        <div class="lg:col-span-5 bg-white border-4 border-[#1D1D1D] p-6 shadow-[4px_4px_0px_0px_#256D4A]">
                            <h4 class="font-heading text-2xl uppercase border-b-2 border-[#1D1D1D] pb-2 mb-6 text-[#D95C3F]">
                                2. Dewan Daerah
                            </h4>

                            <div class="space-y-4">
                                <!-- Ketua -->
                                <div class="p-4 bg-[#F4F1EA] border-2 border-[#1D1D1D] shadow-[3px_3px_0px_0px_#1D1D1D]">
                                    <div class="text-xs uppercase font-bold text-[#256D4A] tracking-wide">Ketua Dewan Daerah</div>
                                    <div class="font-heading text-2xl text-[#1D1D1D] mt-1">Dedi Kurniawan</div>
                                </div>

                                <!-- Anggota -->
                                <div class="p-4 bg-[#F4F1EA] border border-[#1D1D1D]">
                                    <div class="text-xs uppercase font-bold text-[#1D1D1D]/60 tracking-wider mb-2">Anggota Dewan Daerah</div>
                                    <ul class="space-y-2 font-bold text-sm text-[#1D1D1D]">
                                        <li class="flex items-center gap-2">
                                            <span class="w-2 h-2 bg-[#D95C3F]"></span> Dadan Ramdan
                                        </li>
                                        <li class="flex items-center gap-2">
                                            <span class="w-2 h-2 bg-[#D95C3F]"></span> Alex D Pransisca
                                        </li>
                                        <li class="flex items-center gap-2">
                                            <span class="w-2 h-2 bg-[#D95C3F]"></span> Abdul Ajiz
                                        </li>
                                        <li class="flex items-center gap-2">
                                            <span class="w-2 h-2 bg-[#D95C3F]"></span> Dede Supriadi
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>

            <!-- Kontak Section -->
            <section id="kontak" class="bg-white border-4 border-[#1D1D1D] shadow-[8px_8px_0px_0px_#256D4A] p-8 md:p-12 scroll-mt-24 mt-16">
                <div class="text-center mb-10">
                    <span class="inline-block bg-[#D95C3F] text-[#F4F1EA] font-bold text-xs uppercase tracking-widest px-4 py-2 mb-4">
                        Hubungi Kami
                    </span>
                    <h3 class="text-3xl md:text-4xl font-heading text-[#1D1D1D] uppercase tracking-wide">
                        Kantor Eksekutif Daerah WALHI Jabar
                    </h3>
                </div>

                <div class="grid md:grid-cols-2 gap-8">
                    <!-- Info Kontak -->
                    <div class="flex flex-col gap-6">
                        <div class="flex gap-4 items-start">
                            <div class="w-10 h-10 bg-[#1D1D1D] text-[#5C8D59] flex items-center justify-center shrink-0">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 10c0 4.993-5.539 10.193-7.399 11.799a1 1 0 0 1-1.202 0C9.539 20.193 4 14.993 4 10a8 8 0 0 1 16 0"/><circle cx="12" cy="10" r="3"/></svg>
                            </div>
                            <div>
                                <h4 class="font-bold text-[#1D1D1D] text-sm uppercase tracking-wider mb-1">Alamat Kantor</h4>
                                <p class="text-base text-[#1D1D1D]/80 leading-relaxed">Jalan Pecah Kopi, No. 14 , Bandung 40123</p>
                            </div>
                        </div>

                        <div class="flex gap-4 items-start">
                            <div class="w-10 h-10 bg-[#1D1D1D] text-[#5C8D59] flex items-center justify-center shrink-0">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="20" height="16" x="2" y="4" rx="2"/><path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/></svg>
                            </div>
                            <div>
                                <h4 class="font-bold text-[#1D1D1D] text-sm uppercase tracking-wider mb-1">E-mail Resmi</h4>
                                <p class="text-base text-[#1D1D1D]/80">
                                    <a href="mailto:walhijabar@gmail.com" class="hover:text-[#256D4A] underline font-semibold">walhijabar@gmail.com</a><br>
                                    <a href="mailto:walhijabar@walhijabar.id" class="hover:text-[#256D4A] underline font-semibold">walhijabar@walhijabar.id</a>
                                </p>
                            </div>
                        </div>

                        <div class="flex gap-4 items-start">
                            <div class="w-10 h-10 bg-[#1D1D1D] text-[#5C8D59] flex items-center justify-center shrink-0">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
                            </div>
                            <div>
                                <h4 class="font-bold text-[#1D1D1D] text-sm uppercase tracking-wider mb-1">Telepon & Fax</h4>
                                <p class="text-base text-[#1D1D1D]/80">
                                    <a href="tel:02220458503" class="hover:text-[#256D4A] underline font-semibold">022 - 20458503</a>
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Peta / Social Media -->
                    <div class="bg-[#F4F1EA] border-4 border-[#1D1D1D] p-6 flex flex-col justify-between gap-6">
                        <div>
                            <h4 class="font-heading text-2xl text-[#1D1D1D] uppercase tracking-wide mb-4">Media Sosial Resmi</h4>
                            <div class="grid grid-cols-2 gap-4 text-sm font-semibold">
                                <a href="https://instagram.com/walhi.jabar" target="_blank" rel="noopener noreferrer" class="flex items-center gap-2 text-[#1D1D1D] hover:text-[#256D4A] transition-colors">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-[#D95C3F]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="20" height="20" x="2" y="2" rx="5" ry="5"/><path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"/><line x1="17.5" x2="17.51" y1="6.5" y2="6.5"/></svg>
                                    <span>Instagram</span>
                                </a>
                                <a href="https://www.youtube.com/@walhijabar" target="_blank" rel="noopener noreferrer" class="flex items-center gap-2 text-[#1D1D1D] hover:text-[#256D4A] transition-colors">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-[#D95C3F]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M2.5 17a24.12 24.12 0 0 1 0-10 2 2 0 0 1 1.4-1.4 49.56 49.56 0 0 1 16.2 0A2 2 0 0 1 21.5 7a24.12 24.12 0 0 1 0 10 2 2 0 0 1-1.4 1.4 49.55 49.55 0 0 1-16.2 0A2 2 0 0 1 2.5 17z"/><polygon points="9.75 15.02 15.5 11.75 9.75 8.48 9.75 15.02"/></svg>
                                    <span>YouTube</span>
                                </a>
                                <a href="https://facebook.com/walhi.jabar" target="_blank" rel="noopener noreferrer" class="flex items-center gap-2 text-[#1D1D1D] hover:text-[#256D4A] transition-colors">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-[#256D4A]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"/></svg>
                                    <span>Facebook</span>
                                </a>
                                <a href="https://x.com/walhijabar" target="_blank" rel="noopener noreferrer" class="flex items-center gap-2 text-[#1D1D1D] hover:text-[#256D4A] transition-colors">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="currentColor"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>
                                    <span>@walhijabar</span>
                                </a>
                            </div>
                        </div>

                        <div class="border-t border-[#1D1D1D]/20 pt-4">
                            <p class="text-xs text-[#666] leading-relaxed">
                                Silakan hubungi kami untuk laporan pelanggaran lingkungan, advokasi bersama, atau dukungan donasi bagi gerakan lingkungan hidup Jawa Barat.
                            </p>
                        </div>
                    </div>
                </div>
            </section>

        </main>

        @include('partials.site-footer')

        <!-- Tab Switcher Script -->
        <script nonce="{{ Vite::cspNonce() }}">
            function setTentangTab(tabId) {
                var panels = {
                    'profil': document.getElementById('tab-content-profil'),
                    'visi-misi': document.getElementById('tab-content-visi-misi'),
                    'pengurus': document.getElementById('tab-content-pengurus')
                };
                var buttons = {
                    'profil': document.getElementById('tab-btn-profil'),
                    'visi-misi': document.getElementById('tab-btn-visi-misi'),
                    'pengurus': document.getElementById('tab-btn-pengurus')
                };

                // Hide all panels & reset buttons
                for (var key in panels) {
                    if (panels[key]) {
                        panels[key].style.display = 'none';
                    }
                    if (buttons[key]) {
                        buttons[key].style.backgroundColor = '#FFFFFF';
                        buttons[key].style.color = '#1D1D1D';
                    }
                }

                // Show selected panel & activate button
                if (panels[tabId]) {
                    panels[tabId].style.display = 'flex';
                }
                if (buttons[tabId]) {
                    buttons[tabId].style.backgroundColor = '#256D4A';
                    buttons[tabId].style.color = '#F4F1EA';
                }

                if (window.history.pushState) {
                    window.history.pushState(null, null, '#' + tabId);
                }
            }

            // Global alias for compatibility
            window.switchTab = setTentangTab;
            window.manualSwitchTab = setTentangTab;

            document.addEventListener('DOMContentLoaded', function() {
                var hash = window.location.hash.replace('#', '');
                if (hash === 'visi-misi' || hash === 'pengurus' || hash === 'profil') {
                    setTentangTab(hash);
                } else if (hash === 'kontak') {
                    setTentangTab('profil');
                    var el = document.getElementById('kontak');
                    if (el) {
                        setTimeout(function() { el.scrollIntoView({ behavior: 'smooth' }); }, 150);
                    }
                } else {
                    setTentangTab('profil');
                }
            });

            window.addEventListener('hashchange', function() {
                var hash = window.location.hash.replace('#', '');
                if (hash === 'visi-misi' || hash === 'pengurus' || hash === 'profil') {
                    setTentangTab(hash);
                } else if (hash === 'kontak') {
                    var el = document.getElementById('kontak');
                    if (el) el.scrollIntoView({ behavior: 'smooth' });
                }
            });
        </script>
    </body>
</html>
