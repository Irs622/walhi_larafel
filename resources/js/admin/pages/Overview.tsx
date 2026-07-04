import { useEffect, useState } from 'react';
import { Link } from 'react-router-dom';
import { ArrowRight, BarChart3, BookOpen, FileText, Heart, Newspaper, TrendingUp, Users } from 'lucide-react';
import { DonationChart } from '../components/DonationChart';
import { LiveFeed } from '../components/LiveFeed';
import { StatsCard } from '../components/StatsCard';
import { useRealtimeFeed } from '../hooks/useRealtimeFeed';

const quickLinks = [
    { label: 'Blog', path: '/admin/blog', icon: <FileText size={16} />, color: 'text-[#256D4A]' },
    { label: 'Siaran Pers', path: '/admin/siaran-pers', icon: <Newspaper size={16} />, color: 'text-[#5C8D59]' },
    { label: 'Laporan Tahunan', path: '/admin/laporan-tahunan', icon: <BarChart3 size={16} />, color: 'text-[#8B6B4A]' },
    { label: 'Regulasi', path: '/admin/regulasi', icon: <BookOpen size={16} />, color: 'text-[#256D4A]' },
    { label: 'Donasi', path: '/admin/donasi', icon: <Heart size={16} />, color: 'text-[#D95C3F]' },
    { label: 'Kontak', path: '/admin/tentang/kontak', icon: <Users size={16} />, color: 'text-[#8B6B4A]' },
];

export function Overview() {
    const events = useRealtimeFeed();
    const [visitors, setVisitors] = useState(14_320);

    useEffect(() => {
        const timer = setInterval(() => {
            setVisitors((value) => value + Math.floor(Math.random() * 3));
        }, 6_000);

        return () => clearInterval(timer);
    }, []);

    return (
        <div className="space-y-6">
            <div>
                <h1 className="text-2xl font-bold text-[#1D1D1D]">Dashboard</h1>
                <p className="text-sm text-[#888] mt-1">Ringkasan aktivitas WALHI Jawa Barat</p>
            </div>

            <div className="grid grid-cols-2 lg:grid-cols-4 gap-4">
                <StatsCard label="Total Artikel" value="47" sub="+3 bulan ini" icon={<FileText size={18} />} accent="green" />
                <StatsCard label="Total Donasi" value="Rp 287jt" sub="Sejak Jan 2025" icon={<Heart size={18} />} accent="orange" />
                <StatsCard label="Pengunjung Bulan Ini" value={visitors.toLocaleString('id-ID')} sub="Realtime counter" icon={<TrendingUp size={18} />} accent="moss" />
                <StatsCard label="Kampanye Aktif" value="5" sub="3 donasi, 2 event" icon={<Users size={18} />} accent="brown" />
            </div>

            <div className="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <div className="lg:col-span-2 bg-white border border-[#ddd] rounded-lg p-5">
                    <div className="flex items-center justify-between mb-4">
                        <div>
                            <h2 className="font-bold text-[#1D1D1D] text-sm">Tren Donasi</h2>
                            <p className="text-xs text-[#888]">12 bulan terakhir</p>
                        </div>
                    </div>
                    <DonationChart />
                </div>

                <div className="bg-white border border-[#ddd] rounded-lg p-5 flex flex-col" style={{ minHeight: 320 }}>
                    <LiveFeed events={events} />
                </div>
            </div>

            <div className="bg-white border border-[#ddd] rounded-lg p-5">
                <h2 className="font-bold text-[#1D1D1D] text-sm mb-4">Akses Cepat</h2>
                <div className="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-3">
                    {quickLinks.map((link) => (
                        <Link key={link.path} to={link.path} className="flex flex-col items-center gap-2 p-4 rounded-lg border border-[#eee] hover:border-[#256D4A] hover:bg-[#f4faf6] transition-colors group">
                            <span className={link.color}>{link.icon}</span>
                            <span className="text-xs font-medium text-[#444] group-hover:text-[#256D4A] text-center">{link.label}</span>
                            <ArrowRight size={10} className="text-[#ccc] group-hover:text-[#256D4A]" />
                        </Link>
                    ))}
                </div>
            </div>

            <div className="grid grid-cols-1 md:grid-cols-3 gap-4">
                <SectionCard
                    title="Publikasi"
                    items={[
                        { label: 'Siaran Pers', path: '/admin/siaran-pers' },
                        { label: 'Infografis', path: '/admin/infografis' },
                        { label: 'Kertas Posisi', path: '/admin/kertas-posisi' },
                        { label: 'E-Newsletter', path: '/admin/newsletter' },
                        { label: 'Buletin Bumi', path: '/admin/buletin-bumi' },
                        { label: 'Jurnal', path: '/admin/jurnal' },
                        { label: 'Laporan Tahunan', path: '/admin/laporan-tahunan' },
                    ]}
                />
                <SectionCard
                    title="Dukung Kami"
                    items={[
                        { label: 'Donasi Publik', path: '/admin/donasi' },
                        { label: 'Pekan Rakyat', path: '/admin/pekan-rakyat' },
                    ]}
                />
                <SectionCard
                    title="Tentang Kami"
                    items={[
                        { label: 'Sejarah', path: '/admin/tentang/sejarah' },
                        { label: 'Visi & Misi', path: '/admin/tentang/visi-misi' },
                        { label: 'Dewan Nasional', path: '/admin/tentang/dewan-nasional' },
                        { label: 'Eksekutif Nasional', path: '/admin/tentang/eksekutif-nasional' },
                        { label: 'Eksekutif Daerah', path: '/admin/tentang/eksekutif-daerah' },
                        { label: 'Kontak', path: '/admin/tentang/kontak' },
                    ]}
                />
            </div>
        </div>
    );
}

function SectionCard({ title, items }: { title: string; items: Array<{ label: string; path: string }> }) {
    return (
        <div className="bg-white border border-[#ddd] rounded-lg p-5">
            <h3 className="font-bold text-[#1D1D1D] text-sm mb-3">{title}</h3>
            <ul className="space-y-1">
                {items.map((item) => {
                    return (
                        <li key={item.path}>
                            <Link to={item.path} className="flex items-center gap-2 text-xs text-[#666] hover:text-[#256D4A] transition-colors py-0.5 group">
                                <span className="w-1 h-1 rounded-full bg-[#ddd] group-hover:bg-[#256D4A] transition-colors" />
                                {item.label}
                            </Link>
                        </li>
                    );
                })}
            </ul>
        </div>
    );
}