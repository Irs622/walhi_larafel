import { useState } from 'react';
import { Heart, Target, TrendingUp, Users } from 'lucide-react';
import { ContentEditor } from '../components/ContentEditor';
import { ContentTable } from '../components/ContentTable';
import { DonationChart } from '../components/DonationChart';
import { StatsCard } from '../components/StatsCard';
import type { ContentItem } from '../hooks/useLocalStore';
import { useLocalStore } from '../hooks/useLocalStore';

const recentDonations = [
    { name: 'Budi Santoso', amount: 250_000, date: '2025-07-03', campaign: 'Selamatkan Citarum' },
    { name: 'Anonim', amount: 500_000, date: '2025-07-03', campaign: 'Hutan untuk Masa Depan' },
    { name: 'Siti Rahayu', amount: 100_000, date: '2025-07-02', campaign: 'Selamatkan Citarum' },
    { name: 'Ahmad Fauzi', amount: 1_000_000, date: '2025-07-02', campaign: 'Anti Reklamasi Pantai' },
    { name: 'Dewi Lestari', amount: 75_000, date: '2025-07-01', campaign: 'Selamatkan Citarum' },
];

export function DonasiManager() {
    const { items, add, update, remove } = useLocalStore('donasi');
    const [editorOpen, setEditorOpen] = useState(false);
    const [editItem, setEditItem] = useState<ContentItem | null>(null);

    return (
        <div className="space-y-6">
            <div>
                <h1 className="text-2xl font-bold text-[#1D1D1D]">Donasi Publik</h1>
                <p className="text-sm text-[#888] mt-1">Manajemen kampanye donasi dan laporan penerimaan</p>
            </div>

            <div className="grid grid-cols-2 lg:grid-cols-4 gap-4">
                <StatsCard label="Total Donasi" value="Rp 287jt" sub="Tahun 2025" icon={<Heart size={18} />} accent="orange" />
                <StatsCard label="Donatur Unik" value="1.243" sub="Sepanjang kampanye" icon={<Users size={18} />} accent="green" />
                <StatsCard label="Kampanye Aktif" value="3" sub="dari 5 total" icon={<Target size={18} />} accent="moss" />
                <StatsCard label="Rata-rata Donasi" value="Rp 231rb" sub="Per transaksi" icon={<TrendingUp size={18} />} accent="brown" />
            </div>

            <div className="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <div className="lg:col-span-2 bg-white border border-[#ddd] rounded-lg p-5">
                    <h2 className="font-bold text-[#1D1D1D] text-sm mb-4">Tren Donasi 12 Bulan Terakhir</h2>
                    <DonationChart />
                </div>

                <div className="bg-white border border-[#ddd] rounded-lg p-5">
                    <h2 className="font-bold text-[#1D1D1D] text-sm mb-4">Donasi Terbaru</h2>
                    <div className="space-y-3">
                        {recentDonations.map((donation, index) => (
                            <div key={index} className="flex items-start justify-between gap-2">
                                <div>
                                    <p className="text-xs font-semibold text-[#1D1D1D]">{donation.name}</p>
                                    <p className="text-[10px] text-[#888]">
                                        {donation.campaign} · {donation.date}
                                    </p>
                                </div>
                                <span className="text-xs font-bold text-[#256D4A] shrink-0">Rp {donation.amount.toLocaleString('id-ID')}</span>
                            </div>
                        ))}
                    </div>
                </div>
            </div>

            <div>
                <h2 className="font-bold text-[#1D1D1D] text-base mb-4">Kampanye Donasi</h2>
                <ContentTable
                    items={items}
                    onAdd={() => {
                        setEditItem(null);
                        setEditorOpen(true);
                    }}
                    onEdit={(item) => {
                        setEditItem(item);
                        setEditorOpen(true);
                    }}
                    onDelete={remove}
                    onToggleStatus={(item) => update(item.id, { status: item.status === 'published' ? 'archived' : 'published' })}
                    pageTitle="Kampanye"
                />
            </div>

            <ContentEditor open={editorOpen} onClose={() => setEditorOpen(false)} item={editItem} onSave={(data) => (editItem ? update(editItem.id, data) : add(data))} pageTitle="Kampanye Donasi" />
        </div>
    );
}