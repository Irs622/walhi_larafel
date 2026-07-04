import { useState } from 'react';
import { useLocation } from 'react-router-dom';
import { Bell, Search, User } from 'lucide-react';

const breadcrumbMap: Record<string, string> = {
    '/admin': 'Dashboard',
    '/admin/blog': 'Blog',
    '/admin/regulasi': 'Regulasi',
    '/admin/siaran-pers': 'Publikasi › Siaran Pers',
    '/admin/infografis': 'Publikasi › Infografis',
    '/admin/kertas-posisi': 'Publikasi › Kertas Posisi',
    '/admin/newsletter': 'Publikasi › E-Newsletter',
    '/admin/buletin-bumi': 'Publikasi › Buletin Bumi',
    '/admin/jurnal': 'Publikasi › Jurnal Tanah Air',
    '/admin/laporan-tahunan': 'Publikasi › Laporan Tahunan',
    '/admin/donasi': 'Dukung Kami › Donasi Publik',
    '/admin/pekan-rakyat': 'Dukung Kami › Pekan Rakyat',
    '/admin/tentang/sejarah': 'Tentang Kami › Sejarah',
    '/admin/tentang/visi-misi': 'Tentang Kami › Visi & Misi',
    '/admin/tentang/dewan-nasional': 'Tentang Kami › Dewan Nasional',
    '/admin/tentang/eksekutif-nasional': 'Tentang Kami › Eksekutif Nasional',
    '/admin/tentang/eksekutif-daerah': 'Tentang Kami › Eksekutif Daerah',
    '/admin/tentang/kontak': 'Tentang Kami › Kontak',
};

export function Topbar({ notifCount }: { notifCount: number }) {
    const location = useLocation();
    const crumb = breadcrumbMap[location.pathname] ?? 'Admin';
    const [showNotif, setShowNotif] = useState(false);

    const now = new Date();
    const dateStr = now.toLocaleDateString('id-ID', { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' });

    return (
        <header className="h-14 bg-[#F4F1EA] border-b border-[#ddd] flex items-center px-6 gap-4 shrink-0">
            <div className="flex-1">
                <div className="text-xs text-[#888]">WALHI Jawa Barat Admin</div>
                <div className="text-sm font-semibold text-[#1D1D1D]">{crumb}</div>
            </div>

            <div className="text-xs text-[#888] hidden md:block">{dateStr}</div>

            <div className="flex items-center gap-2 ml-4">
                <button className="p-2 rounded hover:bg-[#e8e5de] transition-colors text-[#666]">
                    <Search size={16} />
                </button>

                <div className="relative">
                    <button onClick={() => setShowNotif((value) => !value)} className="p-2 rounded hover:bg-[#e8e5de] transition-colors text-[#666] relative">
                        <Bell size={16} />
                        {notifCount > 0 && <span className="absolute top-1 right-1 w-2 h-2 rounded-full bg-[#D95C3F]" />}
                    </button>
                    {showNotif && (
                        <div className="absolute right-0 top-10 w-64 bg-white border border-[#ddd] rounded shadow-lg z-50 p-3 text-xs">
                            <p className="font-semibold text-[#1D1D1D] mb-2">Notifikasi</p>
                            <p className="text-[#666]">{notifCount} aktivitas baru dalam sesi ini. Lihat Live Feed di Dashboard.</p>
                        </div>
                    )}
                </div>

                <div className="flex items-center gap-2 pl-2 border-l border-[#ddd]">
                    <div className="w-7 h-7 rounded-full bg-[#256D4A] flex items-center justify-center">
                        <User size={14} className="text-white" />
                    </div>
                    <div className="hidden sm:block">
                        <div className="text-xs font-semibold text-[#1D1D1D]">Admin</div>
                        <div className="text-[10px] text-[#888]">Super Admin</div>
                    </div>
                </div>
            </div>
        </header>
    );
}