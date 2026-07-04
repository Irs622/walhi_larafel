@extends('layouts.admin')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div>
        <h1 class="text-2xl font-bold text-[#1D1D1D]">Donasi Publik</h1>
        <p class="text-sm text-[#888] mt-1">Manajemen kampanye donasi dan laporan penerimaan</p>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
        <!-- Total Donasi -->
        <div class="bg-white border border-[#ddd] rounded-lg p-5 flex items-start gap-4">
            <div class="w-10 h-10 rounded-lg flex items-center justify-center shrink-0 bg-[#D95C3F] text-white">
                <i data-lucide="heart" class="w-[18px] h-[18px]"></i>
            </div>
            <div class="min-w-0">
                <div class="text-xs text-[#888] uppercase tracking-wide mb-1">Total Donasi</div>
                <div class="text-2xl font-bold text-[#1D1D1D] leading-tight">Rp 287jt</div>
                <div class="text-xs text-[#888] mt-0.5">Tahun 2025</div>
            </div>
        </div>

        <!-- Donatur Unik -->
        <div class="bg-white border border-[#ddd] rounded-lg p-5 flex items-start gap-4">
            <div class="w-10 h-10 rounded-lg flex items-center justify-center shrink-0 bg-[#256D4A] text-white">
                <i data-lucide="users" class="w-[18px] h-[18px]"></i>
            </div>
            <div class="min-w-0">
                <div class="text-xs text-[#888] uppercase tracking-wide mb-1">Donatur Unik</div>
                <div class="text-2xl font-bold text-[#1D1D1D] leading-tight">1.243</div>
                <div class="text-xs text-[#888] mt-0.5">Sepanjang kampanye</div>
            </div>
        </div>

        <!-- Kampanye Aktif -->
        <div class="bg-white border border-[#ddd] rounded-lg p-5 flex items-start gap-4">
            <div class="w-10 h-10 rounded-lg flex items-center justify-center shrink-0 bg-[#5C8D59] text-white">
                <i data-lucide="target" class="w-[18px] h-[18px]"></i>
            </div>
            <div class="min-w-0">
                <div class="text-xs text-[#888] uppercase tracking-wide mb-1">Kampanye Aktif</div>
                <div class="text-2xl font-bold text-[#1D1D1D] leading-tight">{{ $counts['published'] }}</div>
                <div class="text-xs text-[#888] mt-0.5">dari {{ $counts['total'] }} total</div>
            </div>
        </div>

        <!-- Rata-rata Donasi -->
        <div class="bg-white border border-[#ddd] rounded-lg p-5 flex items-start gap-4">
            <div class="w-10 h-10 rounded-lg flex items-center justify-center shrink-0 bg-[#8B6B4A] text-white">
                <i data-lucide="trending-up" class="w-[18px] h-[18px]"></i>
            </div>
            <div class="min-w-0">
                <div class="text-xs text-[#888] uppercase tracking-wide mb-1">Rata-rata Donasi</div>
                <div class="text-2xl font-bold text-[#1D1D1D] leading-tight">Rp 231rb</div>
                <div class="text-xs text-[#888] mt-0.5">Per transaksi</div>
            </div>
        </div>
    </div>

    <!-- Chart & Recent Donations -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Donation Chart -->
        <div class="lg:col-span-2 bg-white border border-[#ddd] rounded-lg p-5">
            <h2 class="font-bold text-[#1D1D1D] text-sm mb-4">Tren Donasi 12 Bulan Terakhir</h2>
            <div class="h-[200px] w-full">
                <canvas id="donationChartCanvas" class="w-full h-full"></canvas>
            </div>
        </div>

        <!-- Recent Donations -->
        <div class="bg-white border border-[#ddd] rounded-lg p-5">
            <h2 class="font-bold text-[#1D1D1D] text-sm mb-4">Donasi Terbaru</h2>
            <div class="space-y-3">
                <div class="flex items-start justify-between gap-2">
                    <div>
                        <p class="text-xs font-semibold text-[#1D1D1D]">Budi Santoso</p>
                        <p class="text-[10px] text-[#888]">Selamatkan Citarum · 2025-07-03</p>
                    </div>
                    <span class="text-xs font-bold text-[#256D4A] shrink-0">Rp 250.000</span>
                </div>
                <div class="flex items-start justify-between gap-2">
                    <div>
                        <p class="text-xs font-semibold text-[#1D1D1D]">Anonim</p>
                        <p class="text-[10px] text-[#888]">Hutan untuk Masa Depan · 2025-07-03</p>
                    </div>
                    <span class="text-xs font-bold text-[#256D4A] shrink-0">Rp 500.000</span>
                </div>
                <div class="flex items-start justify-between gap-2">
                    <div>
                        <p class="text-xs font-semibold text-[#1D1D1D]">Siti Rahayu</p>
                        <p class="text-[10px] text-[#888]">Selamatkan Citarum · 2025-07-02</p>
                    </div>
                    <span class="text-xs font-bold text-[#256D4A] shrink-0">Rp 100.000</span>
                </div>
                <div class="flex items-start justify-between gap-2">
                    <div>
                        <p class="text-xs font-semibold text-[#1D1D1D]">Ahmad Fauzi</p>
                        <p class="text-[10px] text-[#888]">Anti Reklamasi Pantai · 2025-07-02</p>
                    </div>
                    <span class="text-xs font-bold text-[#256D4A] shrink-0">Rp 1.000.000</span>
                </div>
                <div class="flex items-start justify-between gap-2">
                    <div>
                        <p class="text-xs font-semibold text-[#1D1D1D]">Dewi Lestari</p>
                        <p class="text-[10px] text-[#888]">Selamatkan Citarum · 2025-07-01</p>
                    </div>
                    <span class="text-xs font-bold text-[#256D4A] shrink-0">Rp 75.000</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Campaigns Table -->
    <div>
        <div class="flex items-center justify-between gap-4 mb-4">
            <h2 class="font-bold text-[#1D1D1D] text-base">Kampanye Donasi</h2>
            <button onclick="openAddModal()" class="flex items-center gap-2 px-4 py-2 bg-[#256D4A] text-white text-sm font-semibold rounded hover:bg-[#1e5a3d] transition-colors shrink-0">
                <i data-lucide="plus" class="w-3.5 h-3.5"></i>
                Tambah Kampanye
            </button>
        </div>

        <div class="bg-white border border-[#ddd] rounded-lg overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="bg-[#f9f8f5] border-b border-[#ddd]">
                            <th class="text-left px-4 py-3 text-xs font-semibold text-[#888] uppercase tracking-wide">Judul Kampanye</th>
                            <th class="text-left px-4 py-3 text-xs font-semibold text-[#888] uppercase tracking-wide">Status</th>
                            <th class="text-left px-4 py-3 text-xs font-semibold text-[#888] uppercase tracking-wide hidden sm:table-cell">Tanggal Mulai</th>
                            <th class="text-right px-4 py-3 text-xs font-semibold text-[#888] uppercase tracking-wide">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-[#f0ede8]">
                        @if($items->isEmpty())
                            <tr>
                                <td colSpan="4" class="text-center py-10 text-[#888] text-sm">
                                    Belum ada kampanye donasi. Klik Tambah untuk mulai.
                                </td>
                            </tr>
                        @else
                            @foreach($items as $item)
                                <tr class="hover:bg-[#fafaf8] transition-colors">
                                    <td class="px-4 py-3">
                                        <div class="font-medium text-[#1D1D1D] leading-snug line-clamp-2 max-w-xs">{{ $item->title }}</div>
                                        <div class="text-xs text-[#aaa] mt-0.5">/{{ $item->slug }}</div>
                                    </td>
                                    <td class="px-4 py-3">
                                        @if($item->status === 'published')
                                            <span class="px-2 py-0.5 text-xs font-medium rounded border bg-[#eaf4ee] text-[#256D4A] border-[#c5e0ce]">Terbit</span>
                                        @elseif($item->status === 'draft')
                                            <span class="px-2 py-0.5 text-xs font-medium rounded border bg-[#f5f5f0] text-[#8B6B4A] border-[#ddd5c5]">Draf</span>
                                        @else
                                            <span class="px-2 py-0.5 text-xs font-medium rounded border bg-[#f5f5f5] text-[#888] border-[#ddd]">Arsip</span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-3 text-xs text-[#888] hidden sm:table-cell">
                                        {{ $item->publish_date ? $item->publish_date->format('Y-m-d') : $item->updated_at->format('Y-m-d') }}
                                    </td>
                                    <td class="px-4 py-3">
                                        <div class="flex items-center justify-end gap-1">
                                            <form action="{{ route('admin.content.toggle-status', [$category, $item->id]) }}" method="POST">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" title="{{ $item->status === 'published' ? 'Arsipkan' : 'Terbitkan' }}" class="p-1.5 rounded hover:bg-[#eaf4ee] text-[#256D4A] transition-colors">
                                                    <i data-lucide="eye" class="w-3.5 h-3.5"></i>
                                                </button>
                                            </form>
                                            
                                            <button onclick='openEditModal({!! json_encode($item) !!})' class="p-1.5 rounded hover:bg-[#f0f5ff] text-[#555] transition-colors">
                                                <i data-lucide="edit-2" class="w-3.5 h-3.5"></i>
                                            </button>

                                            <form action="{{ route('admin.content.destroy', [$category, $item->id]) }}" method="POST" onsubmit="return confirm('Hapus kampanye &quot;{{ $item->title }}&quot;?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="p-1.5 rounded hover:bg-[#fdf0ee] text-[#D95C3F] transition-colors">
                                                    <i data-lucide="trash-2" class="w-3.5 h-3.5"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
            </div>

            <!-- Pagination Section -->
            <div class="flex items-center justify-between px-4 py-3 border-t border-[#f0ede8] bg-[#fafaf8]">
                <span class="text-xs text-[#888]">
                    {{ $items->total() }} item · Hal {{ $items->currentPage() }} dari {{ $items->lastPage() }}
                </span>
                <div class="flex gap-1">
                    <a href="{{ $items->previousPageUrl() }}" class="p-1.5 rounded border border-[#ddd] @if($items->onFirstPage()) opacity-40 pointer-events-none @endif hover:bg-[#eee] transition-colors">
                        <i data-lucide="chevron-left" class="w-3.5 h-3.5"></i>
                    </a>
                    <a href="{{ $items->nextPageUrl() }}" class="p-1.5 rounded border border-[#ddd] @if(!$items->hasMorePages()) opacity-40 pointer-events-none @endif hover:bg-[#eee] transition-colors">
                        <i data-lucide="chevron-right" class="w-3.5 h-3.5"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Dialog (Add / Edit) -->
<div id="editor-modal" class="fixed inset-0 bg-black/50 z-50 backdrop-blur-sm hidden flex items-center justify-center">
    <div class="bg-white rounded-xl shadow-2xl w-full max-w-2xl max-h-[90vh] overflow-y-auto">
        <div class="flex items-center justify-between px-6 py-4 border-b border-[#ddd] sticky top-0 bg-white z-10">
            <h2 id="modal-title" class="font-bold text-[#1D1D1D]">Tambah Kampanye Donasi</h2>
            <button onclick="closeModal()" class="p-1.5 rounded hover:bg-[#f0ede8] transition-colors">
                <i data-lucide="x" class="w-4 h-4"></i>
            </button>
        </div>

        <form id="modal-form" action="" method="POST" class="p-6 space-y-4">
            @csrf
            <div id="method-field"></div>

            <div>
                <label class="block text-xs font-semibold text-[#555] mb-1.5 uppercase tracking-wide">Nama Kampanye *</label>
                <input type="text" id="form-title" name="title" required class="w-full px-3 py-2 border border-[#ddd] rounded text-sm focus:outline-none focus:border-[#256D4A]" placeholder="Masukkan nama kampanye..." />
            </div>

            <div>
                <label class="block text-xs font-semibold text-[#555] mb-1.5 uppercase tracking-wide">Slug URL</label>
                <input type="text" id="form-slug" name="slug" class="w-full px-3 py-2 border border-[#ddd] rounded text-sm font-mono text-[#666] focus:outline-none focus:border-[#256D4A]" placeholder="slug-otomatis" />
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-semibold text-[#555] mb-1.5 uppercase tracking-wide">Status</label>
                    <select id="form-status" name="status" class="w-full px-3 py-2 border border-[#ddd] rounded text-sm focus:outline-none focus:border-[#256D4A] bg-white">
                        <option value="draft">Draf</option>
                        <option value="published">Terbit</option>
                        <option value="archived">Arsip</option>
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-[#555] mb-1.5 uppercase tracking-wide">Tanggal Mulai</label>
                    <input type="date" id="form-date" name="publish_date" class="w-full px-3 py-2 border border-[#ddd] rounded text-sm focus:outline-none focus:border-[#256D4A]" />
                </div>
            </div>

            <div>
                <label class="block text-xs font-semibold text-[#555] mb-1.5 uppercase tracking-wide">URL Gambar Kampanye</label>
                <input type="text" id="form-image" name="image_url" class="w-full px-3 py-2 border border-[#ddd] rounded text-sm focus:outline-none focus:border-[#256D4A]" placeholder="https://..." />
            </div>

            <div>
                <label class="block text-xs font-semibold text-[#555] mb-1.5 uppercase tracking-wide">Target Pendanaan & Tag</label>
                <input type="text" id="form-tags" name="tags" class="w-full px-3 py-2 border border-[#ddd] rounded text-sm focus:outline-none focus:border-[#256D4A]" placeholder="citarum, donasi, air" />
            </div>

            <div>
                <label class="block text-xs font-semibold text-[#555] mb-1.5 uppercase tracking-wide font-mono">Deskripsi Kampanye / Target Detail</label>
                <textarea id="form-body" name="body" rows="8" class="w-full px-3 py-2 border border-[#ddd] rounded text-sm focus:outline-none focus:border-[#256D4A] resize-y" placeholder="Target: Rp 50.000.000..."></textarea>
            </div>

            <div class="flex justify-end gap-3 pt-2">
                <button type="button" onclick="closeModal()" class="px-4 py-2 text-sm border border-[#ddd] rounded hover:bg-[#f0ede8] transition-colors">
                    Batal
                </button>
                <button type="submit" class="px-5 py-2 text-sm bg-[#256D4A] text-white font-semibold rounded hover:bg-[#1e5a3d] transition-colors">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Chart.js Area Chart initialization
    document.addEventListener('DOMContentLoaded', () => {
        const ctx = document.getElementById('donationChartCanvas').getContext('2d');
        
        // Gradient fill
        const gradient = ctx.createLinearGradient(0, 0, 0, 200);
        gradient.addColorStop(0, 'rgba(37, 109, 74, 0.3)');
        gradient.addColorStop(1, 'rgba(37, 109, 74, 0)');

        const data = [12500000, 18200000, 14800000, 22000000, 31500000, 19300000, 16700000, 24100000, 27800000, 33200000, 29400000, 38900000];
        const labels = ["Agt '24", "Sep '24", "Okt '24", "Nov '24", "Des '24", "Jan '25", "Feb '25", "Mar '25", "Apr '25", "Mei '25", "Jun '25", "Jul '25"];

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

    const modal = document.getElementById('editor-modal');
    const modalTitle = document.getElementById('modal-title');
    const modalForm = document.getElementById('modal-form');
    const methodField = document.getElementById('method-field');
    let currentMode = 'add';

    // Auto-generate slug on adding
    document.getElementById('form-title').addEventListener('input', function() {
        if (currentMode === 'add') {
            const slug = this.value.toLowerCase()
                .replace(/[^a-z0-9\s-]/g, '') // remove invalid chars
                .replace(/\s+/g, '-')         // collapse whitespace and replace by -
                .replace(/-+/g, '-');         // collapse dashes
            document.getElementById('form-slug').value = slug;
        }
    });

    function openAddModal() {
        currentMode = 'add';
        modalTitle.innerText = 'Tambah Kampanye Donasi';
        
        const baseRoute = '{{ route('admin.content.store', $category) }}';
        modalForm.setAttribute('action', baseRoute);
        methodField.innerHTML = ''; // POST is default

        // Clear values
        document.getElementById('form-title').value = '';
        document.getElementById('form-slug').value = '';
        document.getElementById('form-status').value = 'draft';
        document.getElementById('form-date').value = new Date().toISOString().slice(0, 10);
        document.getElementById('form-image').value = '';
        document.getElementById('form-tags').value = '';
        document.getElementById('form-body').value = '';

        modal.classList.remove('hidden');
    }

    function openEditModal(item) {
        currentMode = 'edit';
        modalTitle.innerText = 'Edit ' + item.title;
        
        let updateUrl = '{{ route('admin.content.update', [$category, ':id']) }}';
        updateUrl = updateUrl.replace(':id', item.id);
        modalForm.setAttribute('action', updateUrl);
        methodField.innerHTML = '@method("PUT")';

        // Populate values
        document.getElementById('form-title').value = item.title;
        document.getElementById('form-slug').value = item.slug;
        document.getElementById('form-status').value = item.status;
        
        if (item.publish_date) {
            const pDate = typeof item.publish_date === 'object' ? item.publish_date.date.slice(0,10) : item.publish_date.slice(0,10);
            document.getElementById('form-date').value = pDate;
        } else {
            document.getElementById('form-date').value = '';
        }
        
        document.getElementById('form-image').value = item.image_url || '';
        document.getElementById('form-tags').value = item.tags || '';
        document.getElementById('form-body').value = item.body || '';

        modal.classList.remove('hidden');
    }

    function closeModal() {
        modal.classList.add('hidden');
    }

    window.addEventListener('click', function(e) {
        if (e.target === modal) {
            closeModal();
        }
    });
</script>
@endpush
