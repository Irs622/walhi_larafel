import { useState } from 'react';
import { ChevronLeft, ChevronRight, Edit2, Eye, Plus, Search, Trash2 } from 'lucide-react';
import type { ContentItem } from '../hooks/useLocalStore';
import { cn } from './ui/utils';

const statusStyle: Record<string, string> = {
    published: 'bg-[#eaf4ee] text-[#256D4A] border-[#c5e0ce]',
    draft: 'bg-[#f5f5f0] text-[#8B6B4A] border-[#ddd5c5]',
    archived: 'bg-[#f5f5f5] text-[#888] border-[#ddd]',
};

const statusLabel: Record<string, string> = {
    published: 'Terbit',
    draft: 'Draf',
    archived: 'Arsip',
};

type Props = {
    items: ContentItem[];
    onAdd: () => void;
    onEdit: (item: ContentItem) => void;
    onDelete: (id: string) => void;
    onToggleStatus: (item: ContentItem) => void;
    pageTitle: string;
};

const perPage = 10;

export function ContentTable({ items, onAdd, onEdit, onDelete, onToggleStatus, pageTitle }: Props) {
    const [search, setSearch] = useState('');
    const [page, setPage] = useState(1);

    const filtered = items.filter((item) => item.title.toLowerCase().includes(search.toLowerCase()) || item.tags.toLowerCase().includes(search.toLowerCase()));
    const totalPages = Math.max(1, Math.ceil(filtered.length / perPage));
    const paginated = filtered.slice((page - 1) * perPage, page * perPage);

    return (
        <div>
            <div className="flex flex-col sm:flex-row gap-3 mb-4">
                <div className="relative flex-1">
                    <Search size={14} className="absolute left-3 top-1/2 -translate-y-1/2 text-[#888]" />
                    <input
                        type="text"
                        placeholder="Cari judul atau tag..."
                        value={search}
                        onChange={(event) => {
                            setSearch(event.target.value);
                            setPage(1);
                        }}
                        className="w-full pl-8 pr-3 py-2 text-sm border border-[#ddd] rounded bg-white focus:outline-none focus:border-[#256D4A]"
                    />
                </div>
                <button onClick={onAdd} className="flex items-center gap-2 px-4 py-2 bg-[#256D4A] text-white text-sm font-semibold rounded hover:bg-[#1e5a3d] transition-colors shrink-0">
                    <Plus size={14} />
                    Tambah {pageTitle}
                </button>
            </div>

            <div className="bg-white border border-[#ddd] rounded-lg overflow-hidden">
                <div className="overflow-x-auto">
                    <table className="w-full text-sm">
                        <thead>
                            <tr className="bg-[#f9f8f5] border-b border-[#ddd]">
                                <th className="text-left px-4 py-3 text-xs font-semibold text-[#888] uppercase tracking-wide">Judul</th>
                                <th className="text-left px-4 py-3 text-xs font-semibold text-[#888] uppercase tracking-wide hidden md:table-cell">Tag</th>
                                <th className="text-left px-4 py-3 text-xs font-semibold text-[#888] uppercase tracking-wide">Status</th>
                                <th className="text-left px-4 py-3 text-xs font-semibold text-[#888] uppercase tracking-wide hidden sm:table-cell">Tanggal</th>
                                <th className="text-right px-4 py-3 text-xs font-semibold text-[#888] uppercase tracking-wide">Aksi</th>
                            </tr>
                        </thead>
                        <tbody className="divide-y divide-[#f0ede8]">
                            {paginated.length === 0 ? (
                                <tr>
                                    <td colSpan={5} className="text-center py-10 text-[#888] text-sm">
                                        {search ? 'Tidak ada hasil ditemukan.' : 'Belum ada konten. Klik Tambah untuk mulai.'}
                                    </td>
                                </tr>
                            ) : (
                                paginated.map((item) => (
                                    <tr key={item.id} className="hover:bg-[#fafaf8] transition-colors">
                                        <td className="px-4 py-3">
                                            <div className="font-medium text-[#1D1D1D] leading-snug line-clamp-2 max-w-xs">{item.title}</div>
                                            <div className="text-xs text-[#aaa] mt-0.5">/{item.slug}</div>
                                        </td>
                                        <td className="px-4 py-3 hidden md:table-cell">
                                            <div className="flex flex-wrap gap-1">
                                                {item.tags
                                                    .split(',')
                                                    .filter(Boolean)
                                                    .map((tag) => (
                                                        <span key={tag} className="px-1.5 py-0.5 bg-[#f0ede8] text-[#666] text-[10px] rounded">
                                                            {tag.trim()}
                                                        </span>
                                                    ))}
                                            </div>
                                        </td>
                                        <td className="px-4 py-3">
                                            <span className={cn('px-2 py-0.5 text-xs font-medium rounded border', statusStyle[item.status])}>{statusLabel[item.status]}</span>
                                        </td>
                                        <td className="px-4 py-3 text-xs text-[#888] hidden sm:table-cell">{item.publishDate || item.updatedAt}</td>
                                        <td className="px-4 py-3">
                                            <div className="flex items-center justify-end gap-1">
                                                <button onClick={() => onToggleStatus(item)} title={item.status === 'published' ? 'Arsipkan' : 'Terbitkan'} className="p-1.5 rounded hover:bg-[#eaf4ee] text-[#256D4A] transition-colors">
                                                    <Eye size={13} />
                                                </button>
                                                <button onClick={() => onEdit(item)} className="p-1.5 rounded hover:bg-[#f0f5ff] text-[#555] transition-colors">
                                                    <Edit2 size={13} />
                                                </button>
                                                <button
                                                    onClick={() => {
                                                        if (window.confirm(`Hapus \"${item.title}\"?`)) {
                                                            onDelete(item.id);
                                                        }
                                                    }}
                                                    className="p-1.5 rounded hover:bg-[#fdf0ee] text-[#D95C3F] transition-colors"
                                                >
                                                    <Trash2 size={13} />
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                ))
                            )}
                        </tbody>
                    </table>
                </div>

                <div className="flex items-center justify-between px-4 py-3 border-t border-[#f0ede8] bg-[#fafaf8]">
                    <span className="text-xs text-[#888]">
                        {filtered.length} item · Hal {page} dari {totalPages}
                    </span>
                    <div className="flex gap-1">
                        <button onClick={() => setPage((value) => Math.max(1, value - 1))} disabled={page === 1} className="p-1.5 rounded border border-[#ddd] disabled:opacity-40 hover:bg-[#eee] transition-colors">
                            <ChevronLeft size={13} />
                        </button>
                        <button onClick={() => setPage((value) => Math.min(totalPages, value + 1))} disabled={page === totalPages} className="p-1.5 rounded border border-[#ddd] disabled:opacity-40 hover:bg-[#eee] transition-colors">
                            <ChevronRight size={13} />
                        </button>
                    </div>
                </div>
            </div>
        </div>
    );
}