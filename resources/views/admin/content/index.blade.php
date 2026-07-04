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
                            <th class="text-left px-4 py-3 text-xs font-semibold text-[#888] uppercase tracking-wide hidden md:table-cell">Tag</th>
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
                                            <!-- Toggle Status -->
                                            <form action="{{ route('admin.content' . (request()->is('admin/tentang/*') ? '.tentang' : '') . '.toggle-status', [$category, $item->id]) }}" method="POST">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" title="{{ $item->status === 'published' ? 'Arsipkan' : 'Terbitkan' }}" class="p-1.5 rounded hover:bg-[#eaf4ee] text-[#256D4A] transition-colors">
                                                    <i data-lucide="eye" class="w-3.5 h-3.5"></i>
                                                </button>
                                            </form>
                                            
                                            <!-- Edit -->
                                            <button onclick='openEditModal({!! json_encode($item) !!})' class="p-1.5 rounded hover:bg-[#f0f5ff] text-[#555] transition-colors">
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
        <form id="modal-form" action="" method="POST" class="p-6 space-y-4">
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

            <div>
                <label class="block text-xs font-semibold text-[#555] mb-1.5 uppercase tracking-wide">URL Gambar Utama</label>
                <input type="text" id="form-image" name="image_url" class="w-full px-3 py-2 border border-[#ddd] rounded text-sm focus:outline-none focus:border-[#256D4A]" placeholder="https://..." />
            </div>

            <div>
                <label class="block text-xs font-semibold text-[#555] mb-1.5 uppercase tracking-wide">Tag (pisah dengan koma)</label>
                <input type="text" id="form-tags" name="tags" class="w-full px-3 py-2 border border-[#ddd] rounded text-sm focus:outline-none focus:border-[#256D4A]" placeholder="lingkungan, air, hutan" />
            </div>

            <div>
                <label class="block text-xs font-semibold text-[#555] mb-1.5 uppercase tracking-wide">Konten / Deskripsi</label>
                <textarea id="form-body" name="body" rows="8" class="w-full px-3 py-2 border border-[#ddd] rounded text-sm focus:outline-none focus:border-[#256D4A] resize-y" placeholder="Tulis konten di sini..."></textarea>
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
<script>
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
        document.getElementById('form-image').value = '';
        document.getElementById('form-tags').value = '';
        document.getElementById('form-body').value = '';

        modal.classList.remove('hidden');
    }

    function openEditModal(item) {
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
            // Check if object or string
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

    // Close on click outside modal
    window.addEventListener('click', function(e) {
        if (e.target === modal) {
            closeModal();
        }
    });
</script>
@endpush
