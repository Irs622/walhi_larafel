@extends('layouts.admin')

@section('content')
<div class="space-y-5">
    <!-- Header -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-[#1D1D1D]">{{ $config['title'] }}</h1>
            @if($config['desc'])
                <p class="text-sm text-[#888] mt-1">{{ $config['desc'] }}</p>
            @endif
            <div class="flex gap-4 mt-3 text-xs text-[#888]">
                <span>Total: <strong class="text-[#1D1D1D]">{{ $counts['total'] }}</strong></span>
                <span>Terbit: <strong class="text-[#256D4A]">{{ $counts['published'] }}</strong></span>
                <span>Draf: <strong class="text-[#8B6B4A]">{{ $counts['draft'] }}</strong></span>
                <span>Arsip: <strong class="text-[#888]">{{ $counts['archived'] }}</strong></span>
            </div>
        </div>
    </div>

    <!-- Search & Add Actions -->
    <div>
        <div class="flex flex-col sm:flex-row gap-3 mb-4">
            <form action="{{ request()->url() }}" method="GET" class="relative flex-1">
                <i data-lucide="search" class="absolute left-3 top-1/2 -translate-y-1/2 text-[#888] w-3.5 h-3.5"></i>
                <input
                    type="text"
                    name="search"
                    placeholder="Cari judul atau tag..."
                    value="{{ request('search') }}"
                    class="w-full pl-8 pr-3 py-2 text-sm border border-[#ddd] rounded bg-white focus:outline-none focus:border-[#256D4A]"
                />
            </form>
            <button onclick="openAddModal()" class="flex items-center gap-2 px-4 py-2 bg-[#256D4A] text-white text-sm font-semibold rounded hover:bg-[#1e5a3d] transition-colors shrink-0">
                <i data-lucide="plus" class="w-3.5 h-3.5"></i>
                Tambah {{ $config['title'] }}
            </button>
        </div>

        <!-- Table Container -->
        <div class="bg-white border border-[#ddd] rounded-lg overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="bg-[#f9f8f5] border-b border-[#ddd]">
                            <th class="text-left px-4 py-3 text-xs font-semibold text-[#888] uppercase tracking-wide">Judul</th>
                            <th class="text-left px-4 py-3 text-xs font-semibold text-[#888] uppercase tracking-wide hidden md:table-cell">
                                @if($category === 'kampanye-darurat')
                                    Tautan Aksi
                                @elseif($category === 'isu-kritis' || $category === 'statistik')
                                    Badge/Ikon
                                @elseif($category === 'regulasi')
                                    Detail Regulasi
                                @else
                                    Tag
                                @endif
                            </th>
                            <th class="text-left px-4 py-3 text-xs font-semibold text-[#888] uppercase tracking-wide">Status</th>
                            <th class="text-left px-4 py-3 text-xs font-semibold text-[#888] uppercase tracking-wide hidden sm:table-cell">Tanggal</th>
                            <th class="text-right px-4 py-3 text-xs font-semibold text-[#888] uppercase tracking-wide">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-[#f0ede8]">
                        @if($items->isEmpty())
                            <tr>
                                <td colSpan="5" class="text-center py-10 text-[#888] text-sm">
                                    {{ request('search') ? 'Tidak ada hasil ditemukan.' : 'Belum ada konten. Klik Tambah untuk mulai.' }}
                                </td>
                            </tr>
                        @else
                            @foreach($items as $item)
                                <tr class="hover:bg-[#fafaf8] transition-colors">
                                    <td class="px-4 py-3">
                                        <div class="font-medium text-[#1D1D1D] leading-snug line-clamp-2 max-w-xs">{{ $item->title }}</div>
                                        <div class="text-xs text-[#aaa] mt-0.5">/{{ $item->slug }}</div>
                                    </td>
                                    <td class="px-4 py-3 hidden md:table-cell">
                                        @if($category === 'kampanye-darurat')
                                            <a href="{{ $item->tags }}" target="_blank" class="text-[#256D4A] hover:underline text-xs break-all">
                                                {{ $item->tags }}
                                            </a>
                                        @elseif($category === 'isu-kritis')
                                            @php
                                                $parts = explode('|', $item->tags);
                                                $icon = $parts[0] ?? 'Icon-4.svg';
                                                $badge = $parts[1] ?? '';
                                            @endphp
                                            <span class="inline-flex items-center gap-1.5">
                                                <img src="{{ asset('assets/images/icons/' . $icon) }}" class="w-4 h-4" />
                                                <span class="px-1.5 py-0.5 bg-[#f0ede8] text-[#666] text-[10px] rounded">{{ $badge }}</span>
                                            </span>
                                        @elseif($category === 'statistik')
                                            <span class="inline-flex items-center gap-1.5">
                                                <img src="{{ asset('assets/images/icons/' . $item->tags) }}" class="w-4 h-4" />
                                                <span class="text-xs text-gray-500 font-mono">{{ $item->tags }}</span>
                                            </span>
                                        @elseif($category === 'regulasi')
                                            <div class="flex flex-wrap gap-1">
                                                @foreach(explode(',', $item->tags) as $tag)
                                                    <span class="px-1.5 py-0.5 bg-[#f0ede8] text-[#666] text-[10px] rounded">
                                                        {{ trim($tag) }}
                                                    </span>
                                                @endforeach
                                            </div>
                                        @else
                                            <div class="flex flex-wrap gap-1">
                                                @if($item->tags)
                                                    @foreach(explode(',', $item->tags) as $tag)
                                                        @if(trim($tag))
                                                            <span class="px-1.5 py-0.5 bg-[#f0ede8] text-[#666] text-[10px] rounded">
                                                                {{ trim($tag) }}
                                                            </span>
                                                        @endif
                                                    @endforeach
                                                @endif
                                            </div>
                                        @endif
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
                                            <!-- Lihat Postingan -->
                                            @if(in_array($category, ['blog', 'regulasi', 'siaran-pers', 'infografis', 'laporan-tahunan', 'kertas-posisi', 'newsletter', 'buletin-bumi', 'jurnal']))
                                                <a href="{{ route('content.show', $item->slug) }}" target="_blank" title="Lihat Postingan" class="p-1.5 rounded hover:bg-[#f4faf6] text-[#256D4A] transition-colors">
                                                    <i data-lucide="external-link" class="w-3.5 h-3.5"></i>
                                                </a>
                                            @endif

                                            <!-- Toggle Status -->
                                            <form action="{{ route('admin.content' . (request()->is('admin/tentang/*') ? '.tentang' : '') . '.toggle-status', [$category, $item->id]) }}" method="POST">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" title="{{ $item->status === 'published' ? 'Arsipkan' : 'Terbitkan' }}" class="p-1.5 rounded hover:bg-[#eaf4ee] text-[#256D4A] transition-colors">
                                                    <i data-lucide="eye" class="w-3.5 h-3.5"></i>
                                                </button>
                                            </form>
                                            
                                            <!-- Edit -->
                                            <button onclick="openEditModal(this)" data-item="{{ json_encode($item) }}" class="p-1.5 rounded hover:bg-[#f0f5ff] text-[#555] transition-colors">
                                                <i data-lucide="edit-2" class="w-3.5 h-3.5"></i>
                                            </button>

                                            <!-- Delete -->
                                            <form action="{{ route('admin.content' . (request()->is('admin/tentang/*') ? '.tentang' : '') . '.destroy', [$category, $item->id]) }}" method="POST" onsubmit="return confirm('Hapus &quot;{{ $item->title }}&quot;?')">
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
        <!-- Modal Header -->
        <div class="flex items-center justify-between px-6 py-4 border-b border-[#ddd] sticky top-0 bg-white z-10">
            <h2 id="modal-title" class="font-bold text-[#1D1D1D]">Tambah {{ $config['title'] }}</h2>
            <button onclick="closeModal()" class="p-1.5 rounded hover:bg-[#f0ede8] transition-colors">
                <i data-lucide="x" class="w-4 h-4"></i>
            </button>
        </div>

        <!-- Modal Form -->
        <form id="modal-form" action="" method="POST" enctype="multipart/form-data" class="p-6 space-y-4">
            @csrf
            <div id="method-field"></div>

            <div>
                <label class="block text-xs font-semibold text-[#555] mb-1.5 uppercase tracking-wide">Judul *</label>
                <input type="text" id="form-title" name="title" required class="w-full px-3 py-2 border border-[#ddd] rounded text-sm focus:outline-none focus:border-[#256D4A]" placeholder="Masukkan judul..." />
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
                    <label class="block text-xs font-semibold text-[#555] mb-1.5 uppercase tracking-wide">Tanggal Terbit</label>
                    <input type="date" id="form-date" name="publish_date" class="w-full px-3 py-2 border border-[#ddd] rounded text-sm focus:outline-none focus:border-[#256D4A]" />
                </div>
            </div>

            @if(in_array($category, ['blog', 'siaran-pers', 'infografis', 'kertas-posisi', 'newsletter', 'buletin-bumi', 'jurnal', 'laporan-tahunan', 'regulasi']))
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-semibold text-[#555] mb-1.5 uppercase tracking-wide">Penulis / Kontributor</label>
                    <input type="text" id="form-author" name="author" class="w-full px-3 py-2 border border-[#ddd] rounded text-sm focus:outline-none focus:border-[#256D4A]" placeholder="Contoh: WALHI Jawa Barat" />
                </div>
                <div class="flex items-center pt-2 sm:pt-6">
                    <label class="inline-flex items-center cursor-pointer select-none">
                        <input type="checkbox" id="form-is-promoted" name="is_promoted" value="1" class="rounded border-gray-300 text-[#256D4A] shadow-sm focus:border-[#256D4A] focus:ring focus:ring-[#256D4A] focus:ring-opacity-50">
                        <span class="ml-2 text-xs font-semibold text-[#555] uppercase tracking-wide">Promosikan / Tampilkan sebagai Hype</span>
                    </label>
                </div>
            </div>
            @endif

            @if($category !== 'kampanye-darurat')
            <div>
                <label class="block text-xs font-semibold text-[#555] mb-1.5 uppercase tracking-wide">
                    @if($category === 'laporan-tahunan' || $category === 'regulasi')
                        Berkas / Dokumen Lampiran (PDF / Excel / Image)
                    @else
                        Gambar Utama
                    @endif
                </label>
                <div class="flex items-center gap-3 mb-2 text-xs">
                    <button type="button" onclick="setImageInputMode('upload')" id="btn-mode-upload" class="px-2.5 py-1 rounded bg-[#256D4A] text-white font-medium transition-colors">Unggah File</button>
                    <button type="button" onclick="setImageInputMode('url')" id="btn-mode-url" class="px-2.5 py-1 rounded bg-[#f0ede8] text-[#666] font-medium transition-colors">Teks URL</button>
                </div>
                
                <!-- Upload File Container -->
                <div id="container-mode-upload" class="space-y-2">
                    <input type="file" id="form-upload" name="image" @if($category === 'laporan-tahunan' || $category === 'regulasi') accept=".pdf,.xls,.xlsx,.doc,.docx,image/*" @else accept="image/*" @endif onchange="previewSelectedImage(this)" class="w-full text-xs text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-xs file:font-semibold file:bg-[#256D4A]/10 file:text-[#256D4A] hover:file:bg-[#256D4A]/20" />
                </div>

                <!-- URL Container -->
                <div id="container-mode-url" class="hidden">
                    <input type="text" id="form-image" name="image_url" class="w-full px-3 py-2 border border-[#ddd] rounded text-sm focus:outline-none focus:border-[#256D4A]" placeholder="https://..." />
                </div>

                <!-- Image Preview -->
                <div id="image-preview-wrapper" class="hidden mt-3 p-2 border border-[#eee] rounded bg-gray-50 flex items-center gap-3">
                    <img id="image-preview-el" src="" class="h-16 w-24 object-cover border border-[#ddd] rounded" />
                    <div class="text-xs">
                        <span class="text-[#888] block">Preview File / Gambar</span>
                        <button type="button" onclick="clearImagePreview()" class="text-[#D95C3F] font-semibold hover:underline">Hapus Berkas</button>
                    </div>
                </div>
            </div>
            @endif

            @if($category === 'kampanye-darurat')
            <div>
                <label class="block text-xs font-semibold text-[#555] mb-1.5 uppercase tracking-wide">Tautan Aksi Kampanye (Action URL) *</label>
                <input type="text" id="form-tags" name="tags" required class="w-full px-3 py-2 border border-[#ddd] rounded text-sm focus:outline-none focus:border-[#256D4A]" placeholder="Contoh: https://example.com/petisi" />
            </div>
            @elseif($category === 'isu-kritis')
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-semibold text-[#555] mb-1.5 uppercase tracking-wide">Pilih Ikon Isu</label>
                    <select id="form-isu-icon" name="isu_icon" class="w-full px-3 py-2 border border-[#ddd] rounded text-sm focus:outline-none focus:border-[#256D4A] bg-white">
                        @for($i = 1; $i <= 27; $i++)
                            <option value="Icon-{{ $i }}.svg">Ikon {{ $i }}</option>
                        @endfor
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-[#555] mb-1.5 uppercase tracking-wide">Teks Badge / Statistik *</label>
                    <input type="text" id="form-isu-badge" name="isu_badge" class="w-full px-3 py-2 border border-[#ddd] rounded text-sm focus:outline-none focus:border-[#256D4A]" placeholder="Contoh: 200+ Titik" />
                </div>
            </div>
            @elseif($category === 'statistik')
            <div>
                <label class="block text-xs font-semibold text-[#555] mb-1.5 uppercase tracking-wide">Pilih Ikon Statistik</label>
                <select id="form-isu-icon" name="isu_icon" class="w-full px-3 py-2 border border-[#ddd] rounded text-sm focus:outline-none focus:border-[#256D4A] bg-white">
                    @for($i = 1; $i <= 27; $i++)
                        <option value="Icon-{{ $i }}.svg">Ikon {{ $i }}</option>
                    @endfor
                </select>
            </div>
            @elseif($category === 'regulasi')
            <div class="grid grid-cols-3 gap-4">
                <div>
                    <label class="block text-xs font-semibold text-[#555] mb-1.5 uppercase tracking-wide">Kategori</label>
                    <select id="form-reg-category" name="reg_category" class="w-full px-3 py-2 border border-[#ddd] rounded text-sm focus:outline-none focus:border-[#256D4A] bg-white">
                        <option value="undang-undang">Undang-Undang</option>
                        <option value="peraturan pemerintah">Peraturan Pemerintah</option>
                        <option value="peraturan daerah">Peraturan Daerah</option>
                        <option value="peraturan menteri">Peraturan / Keputusan Menteri</option>
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-[#555] mb-1.5 uppercase tracking-wide">Lembaga Penerbit *</label>
                    <input type="text" id="form-reg-issuer" name="reg_issuer" class="w-full px-3 py-2 border border-[#ddd] rounded text-sm focus:outline-none focus:border-[#256D4A]" placeholder="Contoh: Pemerintah RI" />
                </div>
                <div>
                    <label class="block text-xs font-semibold text-[#555] mb-1.5 uppercase tracking-wide">Status</label>
                    <select id="form-reg-status" name="reg_status" class="w-full px-3 py-2 border border-[#ddd] rounded text-sm focus:outline-none focus:border-[#256D4A] bg-white">
                        <option value="berlaku">Berlaku</option>
                        <option value="tidak berlaku">Tidak Berlaku</option>
                    </select>
                </div>
            </div>
            @else
            <div>
                <label class="block text-xs font-semibold text-[#555] mb-1.5 uppercase tracking-wide">Tag (pisah dengan koma)</label>
                <input type="text" id="form-tags" name="tags" class="w-full px-3 py-2 border border-[#ddd] rounded text-sm focus:outline-none focus:border-[#256D4A]" placeholder="lingkungan, air, hutan" />
            </div>
            @endif

            @if($category !== 'kampanye-darurat')
            <div>
                <label class="block text-xs font-semibold text-[#555] mb-1.5 uppercase tracking-wide">Konten / Deskripsi</label>
                <textarea id="form-body" name="body" rows="8" class="w-full px-3 py-2 border border-[#ddd] rounded text-sm focus:outline-none focus:border-[#256D4A] resize-y" placeholder="Tulis konten di sini..."></textarea>
            </div>
            @endif

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
<script>
    const modal = document.getElementById('editor-modal');
    const modalTitle = document.getElementById('modal-title');
    const modalForm = document.getElementById('modal-form');
    const methodField = document.getElementById('method-field');
    let currentMode = 'add';
    let imageInputMode = 'upload';

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

    function setImageInputMode(mode) {
        imageInputMode = mode;
        const btnUpload = document.getElementById('btn-mode-upload');
        const btnUrl = document.getElementById('btn-mode-url');
        const containerUpload = document.getElementById('container-mode-upload');
        const containerUrl = document.getElementById('container-mode-url');

        if (!btnUpload || !btnUrl || !containerUpload || !containerUrl) {
            return;
        }

        if (mode === 'upload') {
            btnUpload.className = "px-2.5 py-1 rounded bg-[#256D4A] text-white font-medium transition-colors";
            btnUrl.className = "px-2.5 py-1 rounded bg-[#f0ede8] text-[#666] font-medium transition-colors";
            containerUpload.classList.remove('hidden');
            containerUrl.classList.add('hidden');
            
            const fileInput = document.getElementById('form-upload');
            if (fileInput && fileInput.files && fileInput.files[0]) {
                previewSelectedImage(fileInput);
            } else {
                const formImage = document.getElementById('form-image');
                const formImageVal = formImage ? formImage.value : '';
                if (formImageVal && formImageVal.startsWith('/storage/')) {
                    showPreview(formImageVal);
                } else {
                    hidePreview();
                }
            }
        } else {
            btnUpload.className = "px-2.5 py-1 rounded bg-[#f0ede8] text-[#666] font-medium transition-colors";
            btnUrl.className = "px-2.5 py-1 rounded bg-[#256D4A] text-white font-medium transition-colors";
            containerUpload.classList.add('hidden');
            containerUrl.classList.remove('hidden');
            
            const formImage = document.getElementById('form-image');
            const urlVal = formImage ? formImage.value : '';
            if (urlVal) {
                showPreview(urlVal);
            } else {
                hidePreview();
            }
        }
    }

    const formImageEl = document.getElementById('form-image');
    if (formImageEl) {
        formImageEl.addEventListener('input', function() {
            if (imageInputMode === 'url') {
                if (this.value) {
                    showPreview(this.value);
                } else {
                    hidePreview();
                }
            }
        });
    }

    function showPreview(src) {
        const wrapper = document.getElementById('image-preview-wrapper');
        const img = document.getElementById('image-preview-el');
        if (wrapper && img) {
            img.src = src;
            wrapper.classList.remove('hidden');
        }
    }

    function hidePreview() {
        const wrapper = document.getElementById('image-preview-wrapper');
        if (wrapper) {
            wrapper.classList.add('hidden');
        }
    }

    function previewSelectedImage(input) {
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                showPreview(e.target.result);
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    function clearImagePreview() {
        document.getElementById('form-upload').value = '';
        document.getElementById('form-image').value = '';
        hidePreview();
    }

    function openAddModal() {
        currentMode = 'add';
        modalTitle.innerText = 'Tambah {{ $config['title'] }}';
        
        // Setup Form Action
        const baseRoute = '{{ route('admin.content' . (request()->is('admin/tentang/*') ? '.tentang' : '') . '.store', $category) }}';
        modalForm.setAttribute('action', baseRoute);
        methodField.innerHTML = ''; // POST is default

        // Clear values
        document.getElementById('form-title').value = '';
        document.getElementById('form-slug').value = '';
        document.getElementById('form-status').value = 'draft';
        document.getElementById('form-date').value = new Date().toISOString().slice(0, 10);
        if(document.getElementById('form-upload')) document.getElementById('form-upload').value = '';
        if(document.getElementById('form-image')) document.getElementById('form-image').value = '';
        if(document.getElementById('form-tags')) document.getElementById('form-tags').value = '';
        if(document.getElementById('form-body')) document.getElementById('form-body').value = '';
        if(document.getElementById('form-author')) document.getElementById('form-author').value = '';
        if(document.getElementById('form-is-promoted')) document.getElementById('form-is-promoted').checked = false;

        if(document.getElementById('form-isu-icon')) document.getElementById('form-isu-icon').value = 'Icon-4.svg';
        if(document.getElementById('form-isu-badge')) document.getElementById('form-isu-badge').value = '';
        if(document.getElementById('form-reg-category')) document.getElementById('form-reg-category').value = 'undang-undang';
        if(document.getElementById('form-reg-issuer')) document.getElementById('form-reg-issuer').value = '';
        if(document.getElementById('form-reg-status')) document.getElementById('form-reg-status').value = 'berlaku';

        hidePreview();
        setImageInputMode('upload');

        modal.classList.remove('hidden');
    }

    function openEditModal(button) {
        const item = JSON.parse(button.getAttribute('data-item'));
        currentMode = 'edit';
        modalTitle.innerText = 'Edit ' + item.title;
        
        // Setup Form Action for PUT
        let updateUrl = '{{ route('admin.content' . (request()->is('admin/tentang/*') ? '.tentang' : '') . '.update', [$category, ':id']) }}';
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
        
        if(document.getElementById('form-upload')) document.getElementById('form-upload').value = '';
        if(document.getElementById('form-image')) document.getElementById('form-image').value = item.image_url || '';
        if(document.getElementById('form-tags')) document.getElementById('form-tags').value = item.tags || '';
        if(document.getElementById('form-body')) document.getElementById('form-body').value = item.body || '';
        if(document.getElementById('form-author')) document.getElementById('form-author').value = item.author || '';
        if(document.getElementById('form-is-promoted')) document.getElementById('form-is-promoted').checked = !!item.is_promoted;

        // Handle tags parsing for specific categories
        if (item.tags) {
            if ('{{ $category }}' === 'isu-kritis') {
                if (item.tags.includes('|')) {
                    const parts = item.tags.split('|');
                    if (document.getElementById('form-isu-icon')) document.getElementById('form-isu-icon').value = parts[0];
                    if (document.getElementById('form-isu-badge')) document.getElementById('form-isu-badge').value = parts[1];
                } else {
                    if (document.getElementById('form-isu-icon')) document.getElementById('form-isu-icon').value = 'Icon-4.svg';
                    if (document.getElementById('form-isu-badge')) document.getElementById('form-isu-badge').value = item.tags;
                }
            } else if ('{{ $category }}' === 'statistik') {
                if (document.getElementById('form-isu-icon')) document.getElementById('form-isu-icon').value = item.tags;
            } else if ('{{ $category }}' === 'regulasi') {
                const parts = item.tags.split(',').map(s => s.trim());
                if (parts.length >= 3) {
                    if (document.getElementById('form-reg-category')) document.getElementById('form-reg-category').value = parts[0];
                    if (document.getElementById('form-reg-issuer')) document.getElementById('form-reg-issuer').value = parts[1];
                    if (document.getElementById('form-reg-status')) document.getElementById('form-reg-status').value = parts[2];
                } else {
                    if (document.getElementById('form-reg-category')) document.getElementById('form-reg-category').value = 'undang-undang';
                    if (document.getElementById('form-reg-issuer')) document.getElementById('form-reg-issuer').value = 'Pemerintah RI';
                    if (document.getElementById('form-reg-status')) document.getElementById('form-reg-status').value = 'berlaku';
                }
            }
        }

        if (item.image_url) {
            showPreview(item.image_url);
            if (item.image_url.startsWith('/storage/')) {
                setImageInputMode('upload');
            } else {
                setImageInputMode('url');
            }
        } else {
            hidePreview();
            setImageInputMode('upload');
        }

        modal.classList.remove('hidden');
    }

    function closeModal() {
        modal.classList.add('hidden');
    }

    // Close on click outside modal
    window.addEventListener('click', function(e) {
        if (e.target === modal) {
            closeModal();
        }
    });
</script>
@endpush
