@php
$breadcrumbMap = [
    'admin' => 'Dashboard',
    'admin/blog' => 'Blog',
    'admin/regulasi' => 'Regulasi',
    'admin/siaran-pers' => 'Publikasi › Siaran Pers',
    'admin/infografis' => 'Publikasi › Infografis',
    'admin/kertas-posisi' => 'Publikasi › Kertas Posisi',
    'admin/newsletter' => 'Publikasi › E-Newsletter',
    'admin/buletin-bumi' => 'Publikasi › Buletin Bumi',
    'admin/jurnal' => 'Publikasi › Jurnal Tanah Air',
    'admin/laporan-tahunan' => 'Publikasi › Laporan Tahunan',
    'admin/donasi' => 'Dukung Kami › Donasi Publik',
    'admin/pekan-rakyat' => 'Dukung Kami › Pekan Rakyat',
    'admin/comments' => 'Moderasi Komentar',
    'admin/subscribers' => 'Pelanggan (Newsletter)',
    'admin/tentang/sejarah' => 'Tentang Kami › Sejarah',
    'admin/tentang/visi-misi' => 'Tentang Kami › Visi & Misi',
    'admin/tentang/dewan-nasional' => 'Tentang Kami › Dewan Nasional',
    'admin/tentang/eksekutif-nasional' => 'Tentang Kami › Eksekutif Nasional',
    'admin/tentang/eksekutif-daerah' => 'Tentang Kami › Eksekutif Daerah',
    'admin/tentang/kontak' => 'Tentang Kami › Kontak',
    'admin/statistik' => 'Beranda › Statistik Utama',
    'admin/isu-kritis' => 'Beranda › Isu Kritis',
    'admin/kampanye-darurat' => 'Header › Kampanye Darurat',
];
$currentPath = request()->path();
$breadcrumb = $breadcrumbMap[$currentPath] ?? 'Admin';
$dateStr = now()->locale('id')->isoFormat('dddd, D MMMM YYYY');
@endphp
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $breadcrumb }} - WALHI Jawa Barat Admin</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css'])
    <script src="https://unpkg.com/lucide@0.460.0/dist/umd/lucide.min.js" crossorigin="anonymous"></script>
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
        /* Custom scrollbar to match React app design */
        ::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }
        ::-webkit-scrollbar-track {
            background: transparent;
        }
        ::-webkit-scrollbar-thumb {
            background: #ddd;
            border-radius: 3px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #ccc;
        }
    </style>
</head>
<body class="bg-[#F4F1EA] text-[#1D1D1D]">
    <div class="flex h-screen overflow-hidden" id="admin-layout" x-data="{ collapsed: false }">
        <!-- Sidebar -->
        <aside id="sidebar" class="flex flex-col h-full bg-[#1D1D1D] border-r border-[#2a2a2a] transition-all duration-200 shrink-0 w-56">
            <div class="flex items-center gap-3 px-3 py-4 border-b border-[#2a2a2a] min-h-[56px]">
                <span id="logo-text" class="text-[#F4F1EA] font-bold text-sm leading-tight tracking-wide uppercase">
                    WALHI Jabar<br />
                    <span class="text-[#256D4A] text-xs font-normal">Admin Panel</span>
                </span>
                <button onclick="toggleSidebar()" class="ml-auto text-[#888] hover:text-[#F4F1EA] transition-colors">
                    <i data-lucide="panel-left-close" id="sidebar-toggle-icon" class="w-4 h-4"></i>
                </button>
            </div>

            <nav class="flex-1 overflow-y-auto py-3 space-y-0.5 px-2">
                <!-- Dashboard Link -->
                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-2.5 px-2 py-2 rounded text-sm transition-colors {{ request()->is('admin') ? 'bg-[#256D4A] text-white' : 'text-[#aaa] hover:text-[#F4F1EA] hover:bg-[#2a2a2a]' }}">
                    <i data-lucide="layout-dashboard" class="w-4 h-4 shrink-0"></i>
                    <span class="nav-label">Dashboard</span>
                </a>

                <!-- Blog Link -->
                <a href="{{ route('admin.content.index', 'blog') }}" class="flex items-center gap-2.5 px-2 py-2 rounded text-sm transition-colors {{ request()->is('admin/blog*') ? 'bg-[#256D4A] text-white' : 'text-[#aaa] hover:text-[#F4F1EA] hover:bg-[#2a2a2a]' }}">
                    <i data-lucide="file-text" class="w-4 h-4 shrink-0"></i>
                    <span class="nav-label">Blog</span>
                </a>

                <!-- Regulasi Link -->
                <a href="{{ route('admin.content.index', 'regulasi') }}" class="flex items-center gap-2.5 px-2 py-2 rounded text-sm transition-colors {{ request()->is('admin/regulasi*') ? 'bg-[#256D4A] text-white' : 'text-[#aaa] hover:text-[#F4F1EA] hover:bg-[#2a2a2a]' }}">
                    <i data-lucide="book-open" class="w-4 h-4 shrink-0"></i>
                    <span class="nav-label">Regulasi</span>
                </a>

                <!-- Comments Link -->
                <a href="{{ route('admin.comments.index') }}" class="flex items-center gap-2.5 px-2 py-2 rounded text-sm transition-colors {{ request()->is('admin/comments*') ? 'bg-[#256D4A] text-white' : 'text-[#aaa] hover:text-[#F4F1EA] hover:bg-[#2a2a2a]' }}">
                    <i data-lucide="message-square" class="w-4 h-4 shrink-0"></i>
                    <span class="nav-label">Komentar</span>
                </a>

                <!-- Subscribers Link -->
                <a href="{{ route('admin.subscribers.index') }}" class="flex items-center gap-2.5 px-2 py-2 rounded text-sm transition-colors {{ request()->is('admin/subscribers*') ? 'bg-[#256D4A] text-white' : 'text-[#aaa] hover:text-[#F4F1EA] hover:bg-[#2a2a2a]' }}">
                    <i data-lucide="mail" class="w-4 h-4 shrink-0"></i>
                    <span class="nav-label">Pelanggan</span>
                </a>

                <!-- Halaman Beranda Dropdown Group -->
                @php
                    $berandaActive = request()->is('admin/statistik*') || request()->is('admin/isu-kritis*') || request()->is('admin/kampanye-darurat*');
                @endphp
                <div class="group-container" id="group-beranda">
                    <button onclick="toggleGroup('beranda')" class="w-full flex items-center gap-2.5 px-2 py-2 rounded text-sm transition-colors {{ $berandaActive ? 'text-[#5C8D59]' : 'text-[#aaa] hover:text-[#F4F1EA] hover:bg-[#2a2a2a]' }}">
                        <i data-lucide="home" class="w-4 h-4 shrink-0"></i>
                        <span class="flex-1 text-left nav-label font-medium">Halaman Beranda</span>
                        <i data-lucide="chevron-down" class="w-3 h-3 group-chevron nav-label" id="chevron-beranda"></i>
                    </button>
                    <div class="ml-4 mt-0.5 space-y-0.5 border-l border-[#2a2a2a] pl-3 sub-nav" id="sub-beranda">
                        <a href="{{ route('admin.content.index', 'statistik') }}" class="block px-2 py-1.5 rounded text-xs transition-colors {{ request()->is('admin/statistik*') ? 'text-[#5C8D59] font-semibold' : 'text-[#888] hover:text-[#F4F1EA]' }}">Statistik Utama</a>
                        <a href="{{ route('admin.content.index', 'isu-kritis') }}" class="block px-2 py-1.5 rounded text-xs transition-colors {{ request()->is('admin/isu-kritis*') ? 'text-[#5C8D59] font-semibold' : 'text-[#888] hover:text-[#F4F1EA]' }}">Isu Kritis</a>
                        <a href="{{ route('admin.content.index', 'kampanye-darurat') }}" class="block px-2 py-1.5 rounded text-xs transition-colors {{ request()->is('admin/kampanye-darurat*') ? 'text-[#5C8D59] font-semibold' : 'text-[#888] hover:text-[#F4F1EA]' }}">Kampanye Darurat</a>
                    </div>
                </div>

                <!-- Publikasi Dropdown Group -->
                @php
                    $publikasiActive = request()->is('admin/siaran-pers*') || request()->is('admin/infografis*') || request()->is('admin/kertas-posisi*') || request()->is('admin/newsletter*') || request()->is('admin/buletin-bumi*') || request()->is('admin/jurnal*') || request()->is('admin/laporan-tahunan*');
                @endphp
                <div class="group-container" id="group-publikasi">
                    <button onclick="toggleGroup('publikasi')" class="w-full flex items-center gap-2.5 px-2 py-2 rounded text-sm transition-colors {{ $publikasiActive ? 'text-[#5C8D59]' : 'text-[#aaa] hover:text-[#F4F1EA] hover:bg-[#2a2a2a]' }}">
                        <i data-lucide="newspaper" class="w-4 h-4 shrink-0"></i>
                        <span class="flex-1 text-left nav-label">Publikasi</span>
                        <i data-lucide="chevron-down" class="w-3 h-3 group-chevron nav-label" id="chevron-publikasi"></i>
                    </button>
                    <div class="ml-4 mt-0.5 space-y-0.5 border-l border-[#2a2a2a] pl-3 sub-nav" id="sub-publikasi">
                        <a href="{{ route('admin.content.index', 'siaran-pers') }}" class="block px-2 py-1.5 rounded text-xs transition-colors {{ request()->is('admin/siaran-pers*') ? 'text-[#5C8D59] font-semibold' : 'text-[#888] hover:text-[#F4F1EA]' }}">Siaran Pers</a>
                        <a href="{{ route('admin.content.index', 'infografis') }}" class="block px-2 py-1.5 rounded text-xs transition-colors {{ request()->is('admin/infografis*') ? 'text-[#5C8D59] font-semibold' : 'text-[#888] hover:text-[#F4F1EA]' }}">Infografis</a>
                        <a href="{{ route('admin.content.index', 'kertas-posisi') }}" class="block px-2 py-1.5 rounded text-xs transition-colors {{ request()->is('admin/kertas-posisi*') ? 'text-[#5C8D59] font-semibold' : 'text-[#888] hover:text-[#F4F1EA]' }}">Kertas Posisi</a>
                        <a href="{{ route('admin.content.index', 'newsletter') }}" class="block px-2 py-1.5 rounded text-xs transition-colors {{ request()->is('admin/newsletter*') ? 'text-[#5C8D59] font-semibold' : 'text-[#888] hover:text-[#F4F1EA]' }}">E-Newsletter</a>
                        <a href="{{ route('admin.content.index', 'buletin-bumi') }}" class="block px-2 py-1.5 rounded text-xs transition-colors {{ request()->is('admin/buletin-bumi*') ? 'text-[#5C8D59] font-semibold' : 'text-[#888] hover:text-[#F4F1EA]' }}">Buletin Bumi</a>
                        <a href="{{ route('admin.content.index', 'jurnal') }}" class="block px-2 py-1.5 rounded text-xs transition-colors {{ request()->is('admin/jurnal*') ? 'text-[#5C8D59] font-semibold' : 'text-[#888] hover:text-[#F4F1EA]' }}">Jurnal Tanah Air</a>
                        <a href="{{ route('admin.content.index', 'laporan-tahunan') }}" class="block px-2 py-1.5 rounded text-xs transition-colors {{ request()->is('admin/laporan-tahunan*') ? 'text-[#5C8D59] font-semibold' : 'text-[#888] hover:text-[#F4F1EA]' }}">Laporan Tahunan</a>
                    </div>
                </div>

                <!-- Dukung Kami Dropdown Group -->
                @php
                    $dukungActive = request()->is('admin/donasi*') || request()->is('admin/pekan-rakyat*');
                @endphp
                <div class="group-container" id="group-dukung">
                    <button onclick="toggleGroup('dukung')" class="w-full flex items-center gap-2.5 px-2 py-2 rounded text-sm transition-colors {{ $dukungActive ? 'text-[#5C8D59]' : 'text-[#aaa] hover:text-[#F4F1EA] hover:bg-[#2a2a2a]' }}">
                        <i data-lucide="heart" class="w-4 h-4 shrink-0"></i>
                        <span class="flex-1 text-left nav-label">Dukung Kami</span>
                        <i data-lucide="chevron-down" class="w-3 h-3 group-chevron nav-label" id="chevron-dukung"></i>
                    </button>
                    <div class="ml-4 mt-0.5 space-y-0.5 border-l border-[#2a2a2a] pl-3 sub-nav" id="sub-dukung">
                        <a href="{{ route('admin.content.index', 'donasi') }}" class="block px-2 py-1.5 rounded text-xs transition-colors {{ request()->is('admin/donasi*') ? 'text-[#5C8D59] font-semibold' : 'text-[#888] hover:text-[#F4F1EA]' }}">Donasi Publik</a>
                        <a href="{{ route('admin.content.index', 'pekan-rakyat') }}" class="block px-2 py-1.5 rounded text-xs transition-colors {{ request()->is('admin/pekan-rakyat*') ? 'text-[#5C8D59] font-semibold' : 'text-[#888] hover:text-[#F4F1EA]' }}">Pekan Rakyat</a>
                    </div>
                </div>

                <!-- Tentang Kami Dropdown Group -->
                @php
                    $tentangActive = request()->is('admin/tentang*');
                @endphp
                <div class="group-container" id="group-tentang">
                    <button onclick="toggleGroup('tentang')" class="w-full flex items-center gap-2.5 px-2 py-2 rounded text-sm transition-colors {{ $tentangActive ? 'text-[#5C8D59]' : 'text-[#aaa] hover:text-[#F4F1EA] hover:bg-[#2a2a2a]' }}">
                        <i data-lucide="building-2" class="w-4 h-4 shrink-0"></i>
                        <span class="flex-1 text-left nav-label">Tentang Kami</span>
                        <i data-lucide="chevron-down" class="w-3 h-3 group-chevron nav-label" id="chevron-tentang"></i>
                    </button>
                    <div class="ml-4 mt-0.5 space-y-0.5 border-l border-[#2a2a2a] pl-3 sub-nav" id="sub-tentang">
                        <a href="{{ route('admin.content.tentang.index', 'sejarah') }}" class="block px-2 py-1.5 rounded text-xs transition-colors {{ request()->is('admin/tentang/sejarah*') ? 'text-[#5C8D59] font-semibold' : 'text-[#888] hover:text-[#F4F1EA]' }}">Sejarah</a>
                        <a href="{{ route('admin.content.tentang.index', 'visi-misi') }}" class="block px-2 py-1.5 rounded text-xs transition-colors {{ request()->is('admin/tentang/visi-misi*') ? 'text-[#5C8D59] font-semibold' : 'text-[#888] hover:text-[#F4F1EA]' }}">Visi & Misi</a>
                        <a href="{{ route('admin.content.tentang.index', 'dewan-nasional') }}" class="block px-2 py-1.5 rounded text-xs transition-colors {{ request()->is('admin/tentang/dewan-nasional*') ? 'text-[#5C8D59] font-semibold' : 'text-[#888] hover:text-[#F4F1EA]' }}">Dewan Nasional</a>
                        <a href="{{ route('admin.content.tentang.index', 'eksekutif-nasional') }}" class="block px-2 py-1.5 rounded text-xs transition-colors {{ request()->is('admin/tentang/eksekutif-nasional*') ? 'text-[#5C8D59] font-semibold' : 'text-[#888] hover:text-[#F4F1EA]' }}">Eksekutif Nasional</a>
                        <a href="{{ route('admin.content.tentang.index', 'eksekutif-daerah') }}" class="block px-2 py-1.5 rounded text-xs transition-colors {{ request()->is('admin/tentang/eksekutif-daerah*') ? 'text-[#5C8D59] font-semibold' : 'text-[#888] hover:text-[#F4F1EA]' }}">Eksekutif Daerah</a>
                        <a href="{{ route('admin.content.tentang.index', 'kontak') }}" class="block px-2 py-1.5 rounded text-xs transition-colors {{ request()->is('admin/tentang/kontak*') ? 'text-[#5C8D59] font-semibold' : 'text-[#888] hover:text-[#F4F1EA]' }}">Kontak</a>
                    </div>
                </div>
            </nav>

            <div class="px-4 py-3 border-t border-[#2a2a2a] nav-label">
                <a href="/" target="_blank" rel="noopener noreferrer" class="flex items-center gap-2 text-xs text-[#666] hover:text-[#5C8D59] transition-colors">
                    <i data-lucide="external-link" class="w-3 h-3"></i>
                    Lihat Website Publik
                </a>
            </div>
        </aside>

        <!-- Main Wrapper -->
        <div class="flex flex-col flex-1 min-w-0 overflow-hidden">
            <!-- Header/Topbar -->
            <header class="h-14 bg-[#F4F1EA] border-b border-[#ddd] flex items-center px-6 gap-4 shrink-0">
                <div class="flex-1">
                    <div class="text-xs text-[#888]">WALHI Jawa Barat Admin</div>
                    <div class="text-sm font-semibold text-[#1D1D1D]">{{ $breadcrumb }}</div>
                </div>

                <div class="text-xs text-[#888] hidden md:block">{{ $dateStr }}</div>

                <div class="flex items-center gap-2 ml-4">
                    <button class="p-2 rounded hover:bg-[#e8e5de] transition-colors text-[#666]">
                        <i data-lucide="search" class="w-4 h-4"></i>
                    </button>

                    <!-- Notifications Dropdown -->
                    <div class="relative" id="notification-dropdown">
                        <button onclick="toggleNotifs()" class="p-2 rounded hover:bg-[#e8e5de] transition-colors text-[#666] relative">
                            <i data-lucide="bell" class="w-4 h-4"></i>
                            <span class="absolute top-1 right-1 w-2 h-2 rounded-full bg-[#D95C3F]" id="notif-dot" style="display: none;"></span>
                        </button>
                        <div class="absolute right-0 top-10 w-64 bg-white border border-[#ddd] rounded shadow-lg z-50 p-3 text-xs" id="notif-menu" style="display: none;">
                            <p class="font-semibold text-[#1D1D1D] mb-2">Notifikasi</p>
                            <p class="text-[#666]" id="notif-text">0 aktivitas baru dalam sesi ini. Lihat Live Feed di Dashboard.</p>
                        </div>
                    </div>

                    <div class="flex items-center gap-2 pl-2 border-l border-[#ddd]">
                        <div class="w-7 h-7 rounded-full bg-[#256D4A] flex items-center justify-center">
                            <i data-lucide="user" class="text-white w-3.5 h-3.5"></i>
                        </div>
                        <div class="hidden sm:block">
                            <div class="text-xs font-semibold text-[#1D1D1D]">Admin</div>
                            <div class="text-[10px] text-[#888]">Super Admin</div>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Main Content Area -->
            <main class="flex-1 overflow-y-auto p-6">
                @yield('content')
            </main>
        </div>
    </div>

    <!-- Scripting for UI Collapsible / Toggles -->
    <script>
        // Sidebar collapse logic
        let sidebarCollapsed = false;
        function toggleSidebar() {
            sidebarCollapsed = !sidebarCollapsed;
            const sidebar = document.getElementById('sidebar');
            const logoText = document.getElementById('logo-text');
            const toggleIcon = document.getElementById('sidebar-toggle-icon');
            const labels = document.querySelectorAll('.nav-label');
            const subNavs = document.querySelectorAll('.sub-nav');

            if (sidebarCollapsed) {
                sidebar.classList.remove('w-56');
                sidebar.classList.add('w-14');
                logoText.style.display = 'none';
                toggleIcon.setAttribute('data-lucide', 'panel-left');
                labels.forEach(el => el.style.display = 'none');
                subNavs.forEach(el => el.style.display = 'none');
            } else {
                sidebar.classList.remove('w-14');
                sidebar.classList.add('w-56');
                logoText.style.display = 'block';
                toggleIcon.setAttribute('data-lucide', 'panel-left-close');
                labels.forEach(el => el.style.display = '');
                // restore group states
                Object.keys(groupStates).forEach(key => {
                    if (groupStates[key]) {
                        document.getElementById('sub-' + key).style.display = 'block';
                        document.getElementById('chevron-' + key).setAttribute('data-lucide', 'chevron-down');
                    }
                });
            }
            lucide.createIcons();
        }

        // Submenu groups toggling
        const groupStates = {
            publikasi: {{ $publikasiActive ? 'true' : 'false' }},
            dukung: {{ $dukungActive ? 'true' : 'false' }},
            tentang: {{ $tentangActive ? 'true' : 'false' }},
            beranda: {{ $berandaActive ? 'true' : 'false' }}
        };

        function toggleGroup(groupName) {
            if (sidebarCollapsed) return; // don't toggle if collapsed
            groupStates[groupName] = !groupStates[groupName];
            const sub = document.getElementById('sub-' + groupName);
            const chevron = document.getElementById('chevron-' + groupName);
            
            if (groupStates[groupName]) {
                sub.style.display = 'block';
                chevron.setAttribute('data-lucide', 'chevron-down');
            } else {
                sub.style.display = 'none';
                chevron.setAttribute('data-lucide', 'chevron-right');
            }
            lucide.createIcons();
        }

        // Initialize group visibilities
        Object.keys(groupStates).forEach(key => {
            const sub = document.getElementById('sub-' + key);
            const chevron = document.getElementById('chevron-' + key);
            if (groupStates[key]) {
                sub.style.display = 'block';
                chevron.setAttribute('data-lucide', 'chevron-down');
            } else {
                sub.style.display = 'none';
                chevron.setAttribute('data-lucide', 'chevron-right');
            }
        });

        // Notifications toggling
        let showNotifs = false;
        function toggleNotifs() {
            showNotifs = !showNotifs;
            const menu = document.getElementById('notif-menu');
            menu.style.display = showNotifs ? 'block' : 'none';
        }

        // Click outside notification closes it
        window.addEventListener('click', function(e) {
            const dropdown = document.getElementById('notification-dropdown');
            if (dropdown && !dropdown.contains(e.target)) {
                showNotifs = false;
                document.getElementById('notif-menu').style.display = 'none';
            }
        });

        // Initialize Lucide icons on boot
        document.addEventListener('DOMContentLoaded', () => {
            lucide.createIcons();
        });
    </script>
    @stack('scripts')
</body>
</html>
