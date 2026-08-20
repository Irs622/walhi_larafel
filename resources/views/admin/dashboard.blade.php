@extends('layouts.admin')

@section('content')
<div class="space-y-6">
    <div>
        <h1 class="text-2xl font-bold text-[#1D1D1D]">Dashboard</h1>
        <p class="text-sm text-[#888] mt-1">Ringkasan aktivitas WALHI Jawa Barat</p>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
        <!-- Total Artikel -->
        <div class="bg-white border border-[#ddd] rounded-lg p-5 flex items-start gap-4">
            <div class="w-10 h-10 rounded-lg flex items-center justify-center shrink-0 bg-[#256D4A] text-white">
                <i data-lucide="file-text" class="w-[18px] h-[18px]"></i>
            </div>
            <div class="min-w-0">
                <div class="text-xs text-[#888] uppercase tracking-wide mb-1">Total Artikel</div>
                <div class="text-2xl font-bold text-[#1D1D1D] leading-tight">{{ $stats['total_articles'] }}</div>
                <div class="text-xs text-[#888] mt-0.5">+3 bulan ini</div>
            </div>
        </div>

        <!-- Total Donasi -->
        <div class="bg-white border border-[#ddd] rounded-lg p-5 flex items-start gap-4">
            <div class="w-10 h-10 rounded-lg flex items-center justify-center shrink-0 bg-[#D95C3F] text-white">
                <i data-lucide="heart" class="w-[18px] h-[18px]"></i>
            </div>
            <div class="min-w-0">
                <div class="text-xs text-[#888] uppercase tracking-wide mb-1">Total Donasi</div>
                <div class="text-2xl font-bold text-[#1D1D1D] leading-tight">
                    @if($stats['total_donations_amount'] >= 1000000)
                        Rp {{ number_format($stats['total_donations_amount'] / 1000000, 1, ',', '.') }}jt
                    @else
                        Rp {{ number_format($stats['total_donations_amount'], 0, ',', '.') }}
                    @endif
                </div>
                <div class="text-xs text-[#888] mt-0.5">Sejak Jan 2025</div>
            </div>
        </div>

        <!-- Pengunjung Realtime -->
        <div class="bg-white border border-[#ddd] rounded-lg p-5 flex items-start gap-4">
            <div class="w-10 h-10 rounded-lg flex items-center justify-center shrink-0 bg-[#5C8D59] text-white">
                <i data-lucide="trending-up" class="w-[18px] h-[18px]"></i>
            </div>
            <div class="min-w-0">
                <div class="text-xs text-[#888] uppercase tracking-wide mb-1">Pengunjung Bulan Ini</div>
                <div class="text-2xl font-bold text-[#1D1D1D] leading-tight" id="realtime-visitors">14,320</div>
                <div class="text-xs text-[#888] mt-0.5">Realtime counter</div>
            </div>
        </div>

        <!-- Kampanye Aktif -->
        <div class="bg-white border border-[#ddd] rounded-lg p-5 flex items-start gap-4">
            <div class="w-10 h-10 rounded-lg flex items-center justify-center shrink-0 bg-[#8B6B4A] text-white">
                <i data-lucide="users" class="w-[18px] h-[18px]"></i>
            </div>
            <div class="min-w-0">
                <div class="text-xs text-[#888] uppercase tracking-wide mb-1">Kampanye Aktif</div>
                <div class="text-2xl font-bold text-[#1D1D1D] leading-tight">{{ $stats['active_campaigns'] }}</div>
                <div class="text-xs text-[#888] mt-0.5">{{ $stats['active_donations'] }} donasi, {{ $stats['active_events'] }} event</div>
            </div>
        </div>
    </div>

    <!-- Chart & Live Feed -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Donation Chart -->
        <div class="lg:col-span-2 bg-white border border-[#ddd] rounded-lg p-5">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <h2 class="font-bold text-[#1D1D1D] text-sm">Tren Donasi</h2>
                    <p class="text-xs text-[#888]">12 bulan terakhir</p>
                </div>
            </div>
            <div class="h-[200px] w-full">
                <canvas id="donationChartCanvas" class="w-full h-full"></canvas>
            </div>
        </div>

        <!-- Live Feed Activity -->
        <div class="bg-white border border-[#ddd] rounded-lg p-5 flex flex-col h-[280px]">
            <div class="flex items-center gap-2 mb-3">
                <span class="relative flex h-2 w-2">
                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-[#256D4A] opacity-75"></span>
                    <span class="relative inline-flex rounded-full h-2 w-2 bg-[#256D4A]"></span>
                </span>
                <span class="text-xs font-semibold text-[#1D1D1D] uppercase tracking-wide">Live Aktivitas</span>
            </div>
            <div id="live-feed-container" class="flex-1 overflow-y-auto space-y-2 pr-1">
                <!-- Javascript will populate this with realtime items -->
            </div>
        </div>
    </div>

    <!-- Quick Access Section -->
    <div class="bg-white border border-[#ddd] rounded-lg p-5">
        <h2 class="font-bold text-[#1D1D1D] text-sm mb-4">Akses Cepat</h2>
        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-3">
            <a href="{{ route('admin.content.index', 'blog') }}" class="flex flex-col items-center gap-2 p-4 rounded-lg border border-[#eee] hover:border-[#256D4A] hover:bg-[#f4faf6] transition-colors group">
                <span class="text-[#256D4A]"><i data-lucide="file-text" class="w-4 h-4"></i></span>
                <span class="text-xs font-medium text-[#444] group-hover:text-[#256D4A] text-center">Blog</span>
                <i data-lucide="arrow-right" class="w-2.5 h-2.5 text-[#ccc] group-hover:text-[#256D4A]"></i>
            </a>
            <a href="{{ route('admin.content.index', 'siaran-pers') }}" class="flex flex-col items-center gap-2 p-4 rounded-lg border border-[#eee] hover:border-[#256D4A] hover:bg-[#f4faf6] transition-colors group">
                <span class="text-[#5C8D59]"><i data-lucide="newspaper" class="w-4 h-4"></i></span>
                <span class="text-xs font-medium text-[#444] group-hover:text-[#256D4A] text-center">Siaran Pers</span>
                <i data-lucide="arrow-right" class="w-2.5 h-2.5 text-[#ccc] group-hover:text-[#256D4A]"></i>
            </a>
            <a href="{{ route('admin.content.index', 'laporan-tahunan') }}" class="flex flex-col items-center gap-2 p-4 rounded-lg border border-[#eee] hover:border-[#256D4A] hover:bg-[#f4faf6] transition-colors group">
                <span class="text-[#8B6B4A]"><i data-lucide="bar-chart-3" class="w-4 h-4"></i></span>
                <span class="text-xs font-medium text-[#444] group-hover:text-[#256D4A] text-center">Laporan Tahunan</span>
                <i data-lucide="arrow-right" class="w-2.5 h-2.5 text-[#ccc] group-hover:text-[#256D4A]"></i>
            </a>
            <a href="{{ route('admin.content.index', 'regulasi') }}" class="flex flex-col items-center gap-2 p-4 rounded-lg border border-[#eee] hover:border-[#256D4A] hover:bg-[#f4faf6] transition-colors group">
                <span class="text-[#256D4A]"><i data-lucide="book-open" class="w-4 h-4"></i></span>
                <span class="text-xs font-medium text-[#444] group-hover:text-[#256D4A] text-center">Regulasi</span>
                <i data-lucide="arrow-right" class="w-2.5 h-2.5 text-[#ccc] group-hover:text-[#256D4A]"></i>
            </a>
            <a href="{{ route('admin.content.index', 'donasi') }}" class="flex flex-col items-center gap-2 p-4 rounded-lg border border-[#eee] hover:border-[#256D4A] hover:bg-[#f4faf6] transition-colors group">
                <span class="text-[#D95C3F]"><i data-lucide="heart" class="w-4 h-4"></i></span>
                <span class="text-xs font-medium text-[#444] group-hover:text-[#256D4A] text-center">Donasi</span>
                <i data-lucide="arrow-right" class="w-2.5 h-2.5 text-[#ccc] group-hover:text-[#256D4A]"></i>
            </a>
            <a href="{{ route('admin.content.tentang.index', 'kontak') }}" class="flex flex-col items-center gap-2 p-4 rounded-lg border border-[#eee] hover:border-[#256D4A] hover:bg-[#f4faf6] transition-colors group">
                <span class="text-[#8B6B4A]"><i data-lucide="users" class="w-4 h-4"></i></span>
                <span class="text-xs font-medium text-[#444] group-hover:text-[#256D4A] text-center">Kontak</span>
                <i data-lucide="arrow-right" class="w-2.5 h-2.5 text-[#ccc] group-hover:text-[#256D4A]"></i>
            </a>
        </div>
    </div>

    <!-- Postingan Terbaru Table Section -->
    <div class="bg-white border border-[#ddd] rounded-lg p-5">
        <div class="flex items-center justify-between mb-4">
            <div>
                <h2 class="font-bold text-[#1D1D1D] text-sm">Postingan Terbaru</h2>
                <p class="text-xs text-[#888]">10 publikasi dan artikel berita terakhir</p>
            </div>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-xs text-left border-collapse">
                <thead>
                    <tr class="border-b border-[#eee] text-[#888] font-semibold uppercase tracking-wider">
                        <th class="py-2.5">Judul</th>
                        <th class="py-2.5">Kategori</th>
                        <th class="py-2.5">Penulis</th>
                        <th class="py-2.5">Status</th>
                        <th class="py-2.5">Tanggal</th>
                        <th class="py-2.5 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#f9f9f9]">
                    @forelse($latestPostings as $post)
                        <tr class="hover:bg-[#fafaf8] transition-colors">
                            <td class="py-2.5 font-medium text-[#1D1D1D] max-w-xs truncate">{{ $post->title }}</td>
                            <td class="py-2.5 text-[#666] capitalize">{{ str_replace('-', ' ', $post->category) }}</td>
                            <td class="py-2.5 text-[#666]">{{ $post->author ?: 'WALHI Jawa Barat' }}</td>
                            <td class="py-2.5">
                                @if($post->status === 'published')
                                    <span class="px-1.5 py-0.5 text-[10px] font-medium rounded bg-[#eaf4ee] text-[#256D4A] border border-[#c5e0ce]">Terbit</span>
                                @else
                                    <span class="px-1.5 py-0.5 text-[10px] font-medium rounded bg-[#f5f5f0] text-[#8B6B4A] border border-[#ddd5c5]">Draf</span>
                                @endif
                            </td>
                            <td class="py-2.5 text-[#888]">{{ $post->publish_date ? $post->publish_date->format('Y-m-d') : $post->created_at->format('Y-m-d') }}</td>
                            <td class="py-2.5 text-right">
                                <a href="{{ route('content.show', $post->slug) }}" target="_blank" class="inline-flex items-center gap-1.5 px-2.5 py-1 bg-[#256D4A] hover:bg-[#1e5a3d] text-white text-[11px] font-bold rounded transition-colors uppercase">
                                    Lihat Postingan
                                    <i data-lucide="external-link" class="w-3 h-3"></i>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-4 text-center text-[#888] italic">Belum ada postingan terbaru.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Section Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <!-- Publikasi -->
        <div class="bg-white border border-[#ddd] rounded-lg p-5">
            <h3 class="font-bold text-[#1D1D1D] text-sm mb-3">Publikasi</h3>
            <ul class="space-y-1">
                <li><a href="{{ route('admin.content.index', 'siaran-pers') }}" class="flex items-center gap-2 text-xs text-[#666] hover:text-[#256D4A] transition-colors py-0.5 group"><span class="w-1 h-1 rounded-full bg-[#ddd] group-hover:bg-[#256D4A] transition-colors"></span>Siaran Pers</a></li>
                <li><a href="{{ route('admin.content.index', 'infografis') }}" class="flex items-center gap-2 text-xs text-[#666] hover:text-[#256D4A] transition-colors py-0.5 group"><span class="w-1 h-1 rounded-full bg-[#ddd] group-hover:bg-[#256D4A] transition-colors"></span>Infografis</a></li>
                <li><a href="{{ route('admin.content.index', 'kertas-posisi') }}" class="flex items-center gap-2 text-xs text-[#666] hover:text-[#256D4A] transition-colors py-0.5 group"><span class="w-1 h-1 rounded-full bg-[#ddd] group-hover:bg-[#256D4A] transition-colors"></span>Kertas Posisi</a></li>
                <li><a href="{{ route('admin.content.index', 'newsletter') }}" class="flex items-center gap-2 text-xs text-[#666] hover:text-[#256D4A] transition-colors py-0.5 group"><span class="w-1 h-1 rounded-full bg-[#ddd] group-hover:bg-[#256D4A] transition-colors"></span>E-Newsletter</a></li>
                <li><a href="{{ route('admin.content.index', 'buletin-bumi') }}" class="flex items-center gap-2 text-xs text-[#666] hover:text-[#256D4A] transition-colors py-0.5 group"><span class="w-1 h-1 rounded-full bg-[#ddd] group-hover:bg-[#256D4A] transition-colors"></span>Buletin Bumi</a></li>
                <li><a href="{{ route('admin.content.index', 'jurnal') }}" class="flex items-center gap-2 text-xs text-[#666] hover:text-[#256D4A] transition-colors py-0.5 group"><span class="w-1 h-1 rounded-full bg-[#ddd] group-hover:bg-[#256D4A] transition-colors"></span>Jurnal</a></li>
                <li><a href="{{ route('admin.content.index', 'laporan-tahunan') }}" class="flex items-center gap-2 text-xs text-[#666] hover:text-[#256D4A] transition-colors py-0.5 group"><span class="w-1 h-1 rounded-full bg-[#ddd] group-hover:bg-[#256D4A] transition-colors"></span>Laporan Tahunan</a></li>
            </ul>
        </div>

        <!-- Dukung Kami -->
        <div class="bg-white border border-[#ddd] rounded-lg p-5">
            <h3 class="font-bold text-[#1D1D1D] text-sm mb-3">Dukung Kami</h3>
            <ul class="space-y-1">
                <li><a href="{{ route('admin.content.index', 'donasi') }}" class="flex items-center gap-2 text-xs text-[#666] hover:text-[#256D4A] transition-colors py-0.5 group"><span class="w-1 h-1 rounded-full bg-[#ddd] group-hover:bg-[#256D4A] transition-colors"></span>Donasi Publik</a></li>
                <li><a href="{{ route('admin.content.index', 'pekan-rakyat') }}" class="flex items-center gap-2 text-xs text-[#666] hover:text-[#256D4A] transition-colors py-0.5 group"><span class="w-1 h-1 rounded-full bg-[#ddd] group-hover:bg-[#256D4A] transition-colors"></span>Pekan Rakyat</a></li>
            </ul>
        </div>

        <!-- Tentang Kami -->
        <div class="bg-white border border-[#ddd] rounded-lg p-5">
            <h3 class="font-bold text-[#1D1D1D] text-sm mb-3">Tentang Kami</h3>
            <ul class="space-y-1">
                <li><a href="{{ route('admin.content.tentang.index', 'sejarah') }}" class="flex items-center gap-2 text-xs text-[#666] hover:text-[#256D4A] transition-colors py-0.5 group"><span class="w-1 h-1 rounded-full bg-[#ddd] group-hover:bg-[#256D4A] transition-colors"></span>Sejarah</a></li>
                <li><a href="{{ route('admin.content.tentang.index', 'visi-misi') }}" class="flex items-center gap-2 text-xs text-[#666] hover:text-[#256D4A] transition-colors py-0.5 group"><span class="w-1 h-1 rounded-full bg-[#ddd] group-hover:bg-[#256D4A] transition-colors"></span>Visi & Misi</a></li>
                <li><a href="{{ route('admin.content.tentang.index', 'dewan-nasional') }}" class="flex items-center gap-2 text-xs text-[#666] hover:text-[#256D4A] transition-colors py-0.5 group"><span class="w-1 h-1 rounded-full bg-[#ddd] group-hover:bg-[#256D4A] transition-colors"></span>Dewan Nasional</a></li>
                <li><a href="{{ route('admin.content.tentang.index', 'eksekutif-nasional') }}" class="flex items-center gap-2 text-xs text-[#666] hover:text-[#256D4A] transition-colors py-0.5 group"><span class="w-1 h-1 rounded-full bg-[#ddd] group-hover:bg-[#256D4A] transition-colors"></span>Eksekutif Nasional</a></li>
                <li><a href="{{ route('admin.content.tentang.index', 'eksekutif-daerah') }}" class="flex items-center gap-2 text-xs text-[#666] hover:text-[#256D4A] transition-colors py-0.5 group"><span class="w-1 h-1 rounded-full bg-[#ddd] group-hover:bg-[#256D4A] transition-colors"></span>Eksekutif Daerah</a></li>
                <li><a href="{{ route('admin.content.tentang.index', 'kontak') }}" class="flex items-center gap-2 text-xs text-[#666] hover:text-[#256D4A] transition-colors py-0.5 group"><span class="w-1 h-1 rounded-full bg-[#ddd] group-hover:bg-[#256D4A] transition-colors"></span>Kontak</a></li>
            </ul>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.7/dist/chart.umd.min.js" integrity="sha384-vsrfeLOOY6KuIYKDlmVH5UiBmgIdB1oEf7p01YgWHuqmOHfZr374+odEv96n9tNC" crossorigin="anonymous"></script>
<script>
    // Realtime visitors count logic
    let visitors = 14320;
    const visitorsEl = document.getElementById('realtime-visitors');
    
    function formatVisitors(val) {
        return val.toLocaleString('id-ID');
    }

    setInterval(() => {
        visitors += Math.floor(Math.random() * 3);
        if (visitorsEl) {
            visitorsEl.innerText = formatVisitors(visitors);
        }
    }, 6000);

    // Chart.js Area Chart initialization
    document.addEventListener('DOMContentLoaded', () => {
        const ctx = document.getElementById('donationChartCanvas').getContext('2d');
        
        // Gradient fill
        const gradient = ctx.createLinearGradient(0, 0, 0, 200);
        gradient.addColorStop(0, 'rgba(37, 109, 74, 0.3)');
        gradient.addColorStop(1, 'rgba(37, 109, 74, 0)');

        const data = {!! json_encode($stats['chart_data']) !!};
        const labels = {!! json_encode($stats['chart_labels']) !!};

        new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Donasi',
                    data: data,
                    borderColor: '#256D4A',
                    borderWidth: 2,
                    backgroundColor: gradient,
                    fill: true,
                    tension: 0.4,
                    pointRadius: 0,
                    pointHoverRadius: 5,
                    pointHoverBackgroundColor: '#256D4A'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return 'Rp ' + context.raw.toLocaleString('id-ID');
                            }
                        }
                    }
                },
                scales: {
                    x: {
                        grid: {
                            display: false
                        },
                        ticks: {
                            color: '#888',
                            font: {
                                size: 10
                            }
                        }
                    },
                    y: {
                        grid: {
                            color: '#eee',
                            lineWidth: 1
                        },
                        border: {
                            dash: [3, 3]
                        },
                        ticks: {
                            color: '#888',
                            font: {
                                size: 10
                            },
                            callback: function(value) {
                                if (value >= 1000000) {
                                    return 'Rp ' + (value / 1000000) + 'jt';
                                }
                                return 'Rp ' + value.toLocaleString('id-ID');
                            }
                        }
                    }
                }
            }
        });
    });

    // Realtime Activity Live Feed Logic
    const eventTemplates = [
        { type: 'donation', message: 'Donasi baru masuk', detail: 'Rp 250.000 dari Budi Santoso', icon: 'dollar-sign', bg: 'bg-[#eaf4ee]', color: 'text-[#256D4A]' },
        { type: 'donation', message: 'Donasi baru masuk', detail: 'Rp 500.000 dari Anonim', icon: 'dollar-sign', bg: 'bg-[#eaf4ee]', color: 'text-[#256D4A]' },
        { type: 'donation', message: 'Donasi baru masuk', detail: 'Rp 100.000 dari Siti Rahayu', icon: 'dollar-sign', bg: 'bg-[#eaf4ee]', color: 'text-[#256D4A]' },
        { type: 'comment', message: 'Komentar baru di Blog', detail: '"Artikel ini sangat informatif!" — Ahmad R.', icon: 'message-square', bg: 'bg-[#f0f5f0]', color: 'text-[#5C8D59]' },
        { type: 'comment', message: 'Komentar baru di Siaran Pers', detail: '"Terima kasih atas informasinya." — Dewi S.', icon: 'message-square', bg: 'bg-[#f0f5f0]', color: 'text-[#5C8D59]' },
        { type: 'pageview', message: 'Lonjakan pengunjung', detail: 'Halaman Laporan Tahunan +340 views', icon: 'trending-up', bg: 'bg-[#f5f0ea]', color: 'text-[#8B6B4A]' },
        { type: 'pageview', message: 'Trafik meningkat', detail: 'Blog "Krisis Air Citarum" sedang viral', icon: 'trending-up', bg: 'bg-[#f5f0ea]', color: 'text-[#8B6B4A]' },
        { type: 'submission', message: 'Form Kontak terkirim', detail: 'Dari: press@mediaindonesia.co.id', icon: 'send', bg: 'bg-[#fdf0ee]', color: 'text-[#D95C3F]' },
        { type: 'submission', message: 'Pendaftaran Pekan Rakyat', detail: '3 peserta baru mendaftar', icon: 'send', bg: 'bg-[#fdf0ee]', color: 'text-[#D95C3F]' },
        { type: 'publish', message: 'Artikel dipublikasikan', detail: '"Update Kasus Tambang Emas Pongkor"', icon: 'book-open', bg: 'bg-[#eaf4ee]', color: 'text-[#256D4A]' },
        { type: 'login', message: 'Login admin baru', detail: 'admin@walhijabar.org dari Jakarta', icon: 'log-in', bg: 'bg-[#f5f5f5]', color: 'text-[#888]' },
    ];

    const feedContainer = document.getElementById('live-feed-container');
    const loadedEvents = [];

    // Populate initial 5 items
    for(let i = 4; i >= 0; i--) {
        const randTpl = eventTemplates[Math.floor(Math.random() * eventTemplates.length)];
        const timeAgo = i * 2 + 1; // dummy minutes ago
        loadedEvents.push({
            ...randTpl,
            id: 'init-' + i,
            timeLabel: timeAgo + 'm lalu'
        });
    }

    function renderFeed() {
        feedContainer.innerHTML = '';
        loadedEvents.forEach(ev => {
            const itemHTML = `
                <div class="flex items-start gap-2.5 p-2.5 rounded-lg border border-transparent ${ev.bg}">
                    <div class="mt-0.5 shrink-0 ${ev.color}">
                        <i data-lucide="${ev.icon}" class="w-3.5 h-3.5"></i>
                    </div>
                    <div class="min-w-0 flex-1">
                        <div class="text-xs font-semibold text-[#1D1D1D] leading-snug">${ev.message}</div>
                        <div class="text-xs text-[#666] truncate">${ev.detail}</div>
                    </div>
                    <div class="text-[10px] text-[#aaa] shrink-0 mt-0.5">${ev.timeLabel}</div>
                </div>
            `;
            feedContainer.insertAdjacentHTML('beforeend', itemHTML);
        });
        if (typeof lucide !== 'undefined' && lucide.createIcons) {
            lucide.createIcons();
        }
    }

    // Schedule periodic feed updates
    function addFeedItem() {
        const randTpl = eventTemplates[Math.floor(Math.random() * eventTemplates.length)];
        loadedEvents.unshift({
            ...randTpl,
            id: Date.now(),
            timeLabel: 'baru saja'
        });

        // Limit to 50 items
        if (loadedEvents.length > 50) loadedEvents.pop();

        renderFeed();

        // Update topbar notifications counter for demo consistency
        const notifDot = document.getElementById('notif-dot');
        const notifText = document.getElementById('notif-text');
        if (notifDot) {
            notifDot.style.display = 'block';
        }
        if (notifText) {
            const count = loadedEvents.filter(x => x.timeLabel === 'baru saja').length;
            notifText.innerText = `${count} aktivitas baru dalam sesi ini. Lihat Live Feed di Dashboard.`;
        }

        // Set next trigger
        const nextTime = Math.floor(Math.random() * (9000 - 4000 + 1)) + 4000;
        setTimeout(addFeedItem, nextTime);
    }

    // Run first render & start timers
    renderFeed();
    setTimeout(addFeedItem, 5000);
</script>
@endpush
