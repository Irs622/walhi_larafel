import { useCallback, useEffect, useState } from 'react';

export type ContentStatus = 'published' | 'draft' | 'archived';

export type ContentItem = {
    id: string;
    title: string;
    slug: string;
    body: string;
    tags: string;
    status: ContentStatus;
    imageUrl: string;
    publishDate: string;
    category: string;
    createdAt: string;
    updatedAt: string;
};

const seedData: Record<string, ContentItem[]> = {
    blog: [
        { id: 'b1', title: 'Krisis Air di DAS Citarum: Investigasi Lapangan', slug: 'krisis-air-citarum', body: '...', tags: 'air, citarum, polusi', status: 'published', imageUrl: '', publishDate: '2025-06-01', category: 'blog', createdAt: '2025-06-01', updatedAt: '2025-06-01' },
        { id: 'b2', title: 'Deforestasi Masif di Pegunungan Halimun', slug: 'deforestasi-halimun', body: '...', tags: 'hutan, deforestasi', status: 'published', imageUrl: '', publishDate: '2025-05-15', category: 'blog', createdAt: '2025-05-15', updatedAt: '2025-05-15' },
        { id: 'b3', title: 'Menagih Janji Reklamasi Tambang', slug: 'reklamasi-tambang', body: '...', tags: 'tambang, reklamasi', status: 'draft', imageUrl: '', publishDate: '', category: 'blog', createdAt: '2025-07-01', updatedAt: '2025-07-01' },
    ],
    regulasi: [
        { id: 'r1', title: 'UU No. 32 Tahun 2009 — Perlindungan Lingkungan Hidup', slug: 'uu-32-2009', body: '...', tags: 'undang-undang', status: 'published', imageUrl: '', publishDate: '2009-10-03', category: 'regulasi', createdAt: '2024-01-01', updatedAt: '2024-01-01' },
        { id: 'r2', title: 'PP No. 22 Tahun 2021 — Penyelenggaraan Perlindungan Lingkungan', slug: 'pp-22-2021', body: '...', tags: 'peraturan pemerintah', status: 'published', imageUrl: '', publishDate: '2021-02-02', category: 'regulasi', createdAt: '2024-01-01', updatedAt: '2024-01-01' },
    ],
    'siaran-pers': [
        { id: 'sp1', title: 'WALHI Jabar Menolak Izin Tambang di Kawasan Lindung Cianjur', slug: 'tolak-tambang-cianjur', body: '...', tags: 'tambang, siaran pers', status: 'published', imageUrl: '', publishDate: '2025-06-20', category: 'siaran-pers', createdAt: '2025-06-20', updatedAt: '2025-06-20' },
    ],
    infografis: [{ id: 'i1', title: 'Peta Konflik Agraria Jawa Barat 2024', slug: 'peta-konflik-agraria-2024', body: '...', tags: 'agraria, peta', status: 'published', imageUrl: '', publishDate: '2024-12-01', category: 'infografis', createdAt: '2024-12-01', updatedAt: '2024-12-01' }],
    'kertas-posisi': [{ id: 'kp1', title: 'Posisi WALHI terhadap RUU Pertanahan', slug: 'posisi-ruu-pertanahan', body: '...', tags: 'agraria, posisi', status: 'published', imageUrl: '', publishDate: '2025-03-10', category: 'kertas-posisi', createdAt: '2025-03-10', updatedAt: '2025-03-10' }],
    newsletter: [{ id: 'nl1', title: 'E-Newsletter WALHI Jabar — Edisi Juni 2025', slug: 'newsletter-juni-2025', body: '...', tags: 'newsletter', status: 'published', imageUrl: '', publishDate: '2025-06-30', category: 'newsletter', createdAt: '2025-06-30', updatedAt: '2025-06-30' }],
    'buletin-bumi': [{ id: 'bb1', title: 'Buletin Bumi Vol. 12 — Keadilan Iklim', slug: 'buletin-bumi-vol-12', body: '...', tags: 'buletin, iklim', status: 'published', imageUrl: '', publishDate: '2025-05-01', category: 'buletin-bumi', createdAt: '2025-05-01', updatedAt: '2025-05-01' }],
    jurnal: [{ id: 'j1', title: 'Jurnal Tanah Air — Edisi Khusus Citarum', slug: 'jurnal-citarum', body: '...', tags: 'jurnal, citarum', status: 'published', imageUrl: '', publishDate: '2025-04-01', category: 'jurnal', createdAt: '2025-04-01', updatedAt: '2025-04-01' }],
    'laporan-tahunan': [
        { id: 'lt1', title: 'Laporan Tahunan WALHI Jabar 2024', slug: 'laporan-2024', body: '...', tags: 'laporan', status: 'published', imageUrl: '', publishDate: '2025-03-01', category: 'laporan-tahunan', createdAt: '2025-03-01', updatedAt: '2025-03-01' },
        { id: 'lt2', title: 'Laporan Tahunan WALHI Jabar 2023', slug: 'laporan-2023', body: '...', tags: 'laporan', status: 'published', imageUrl: '', publishDate: '2024-03-01', category: 'laporan-tahunan', createdAt: '2024-03-01', updatedAt: '2024-03-01' },
    ],
    donasi: [{ id: 'd1', title: 'Kampanye Selamatkan Citarum', slug: 'kampanye-citarum', body: 'Target: Rp 50.000.000', tags: 'donasi, citarum', status: 'published', imageUrl: '', publishDate: '2025-01-01', category: 'donasi', createdAt: '2025-01-01', updatedAt: '2025-01-01' }],
    'pekan-rakyat': [{ id: 'pr1', title: 'Pekan Rakyat Lingkungan Hidup 2025', slug: 'pekan-rakyat-2025', body: 'Bandung, 15–20 Agustus 2025', tags: 'event, pekan rakyat', status: 'published', imageUrl: '', publishDate: '2025-08-15', category: 'pekan-rakyat', createdAt: '2025-01-01', updatedAt: '2025-01-01' }],
    sejarah: [{ id: 's1', title: 'Sejarah WALHI Jawa Barat', slug: 'sejarah', body: 'WALHI Jawa Barat berdiri pada 1990...', tags: 'sejarah', status: 'published', imageUrl: '', publishDate: '1990-01-01', category: 'sejarah', createdAt: '2024-01-01', updatedAt: '2024-01-01' }],
    'visi-misi': [{ id: 'vm1', title: 'Visi dan Misi WALHI Jabar', slug: 'visi-misi', body: 'Visi: Terwujudnya tatanan sosial...', tags: 'visi, misi', status: 'published', imageUrl: '', publishDate: '2024-01-01', category: 'visi-misi', createdAt: '2024-01-01', updatedAt: '2024-01-01' }],
    'dewan-nasional': [],
    'eksekutif-nasional': [],
    'eksekutif-daerah': [],
    kontak: [{ id: 'k1', title: 'Informasi Kontak WALHI Jabar', slug: 'kontak', body: 'Jl. Tubagus Ismail No. 16, Bandung', tags: 'kontak', status: 'published', imageUrl: '', publishDate: '2024-01-01', category: 'kontak', createdAt: '2024-01-01', updatedAt: '2024-01-01' }],
};

function storageKey(category: string) {
    return `walhi_admin_${category}`;
}

function seed(category: string): ContentItem[] {
    const key = storageKey(category);
    const raw = localStorage.getItem(key);

    if (raw) {
        return JSON.parse(raw) as ContentItem[];
    }

    const data = seedData[category] ?? [];
    localStorage.setItem(key, JSON.stringify(data));
    return data;
}

export function useLocalStore(category: string) {
    const [items, setItems] = useState<ContentItem[]>(() => seed(category));

    useEffect(() => {
        setItems(seed(category));
    }, [category]);

    const persist = useCallback((next: ContentItem[]) => {
        localStorage.setItem(storageKey(category), JSON.stringify(next));
        setItems(next);
    }, [category]);

    const add = useCallback((item: Omit<ContentItem, 'id' | 'createdAt' | 'updatedAt' | 'category'>) => {
        const now = new Date().toISOString().slice(0, 10);
        const newItem: ContentItem = { ...item, id: `${Date.now()}`, category, createdAt: now, updatedAt: now };
        persist([newItem, ...items]);
    }, [category, items, persist]);

    const update = useCallback((id: string, patch: Partial<ContentItem>) => {
        persist(items.map((item) => (item.id === id ? { ...item, ...patch, updatedAt: new Date().toISOString().slice(0, 10) } : item)));
    }, [items, persist]);

    const remove = useCallback((id: string) => {
        persist(items.filter((item) => item.id !== id));
    }, [items, persist]);

    return { items, add, update, remove };
}