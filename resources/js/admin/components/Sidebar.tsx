import { useState } from 'react';
import { NavLink, useLocation } from 'react-router-dom';
import {
    Building2,
    ChevronDown,
    ChevronRight,
    ExternalLink,
    FileText,
    Heart,
    LayoutDashboard,
    BookOpen,
    Newspaper,
    PanelLeft,
    PanelLeftClose,
} from 'lucide-react';
import { cn } from './ui/utils';

type NavItem = {
    label: string;
    path?: string;
    icon: React.ReactNode;
    children?: { label: string; path: string }[];
};

const nav: NavItem[] = [
    { label: 'Dashboard', path: '/admin', icon: <LayoutDashboard size={16} /> },
    { label: 'Blog', path: '/admin/blog', icon: <FileText size={16} /> },
    { label: 'Regulasi', path: '/admin/regulasi', icon: <BookOpen size={16} /> },
    {
        label: 'Publikasi',
        icon: <Newspaper size={16} />,
        children: [
            { label: 'Siaran Pers', path: '/admin/siaran-pers' },
            { label: 'Infografis', path: '/admin/infografis' },
            { label: 'Kertas Posisi', path: '/admin/kertas-posisi' },
            { label: 'E-Newsletter', path: '/admin/newsletter' },
            { label: 'Buletin Bumi', path: '/admin/buletin-bumi' },
            { label: 'Jurnal Tanah Air', path: '/admin/jurnal' },
            { label: 'Laporan Tahunan', path: '/admin/laporan-tahunan' },
        ],
    },
    {
        label: 'Dukung Kami',
        icon: <Heart size={16} />,
        children: [
            { label: 'Donasi Publik', path: '/admin/donasi' },
            { label: 'Pekan Rakyat', path: '/admin/pekan-rakyat' },
        ],
    },
    {
        label: 'Tentang Kami',
        icon: <Building2 size={16} />,
        children: [
            { label: 'Sejarah', path: '/admin/tentang/sejarah' },
            { label: 'Visi & Misi', path: '/admin/tentang/visi-misi' },
            { label: 'Dewan Nasional', path: '/admin/tentang/dewan-nasional' },
            { label: 'Eksekutif Nasional', path: '/admin/tentang/eksekutif-nasional' },
            { label: 'Eksekutif Daerah', path: '/admin/tentang/eksekutif-daerah' },
            { label: 'Kontak', path: '/admin/tentang/kontak' },
        ],
    },
];

export function Sidebar({ collapsed, onToggle }: { collapsed: boolean; onToggle: () => void }) {
    const location = useLocation();
    const [openGroups, setOpenGroups] = useState<string[]>(['Publikasi', 'Dukung Kami', 'Tentang Kami']);

    function toggle(label: string) {
        setOpenGroups((previous) => (previous.includes(label) ? previous.filter((item) => item !== label) : [...previous, label]));
    }

    function isGroupActive(children: { path: string }[]) {
        return children.some((child) => location.pathname.startsWith(child.path));
    }

    return (
        <aside className={cn('flex flex-col h-full bg-[#1D1D1D] border-r border-[#2a2a2a] transition-all duration-200 shrink-0', collapsed ? 'w-14' : 'w-56')}>
            <div className="flex items-center gap-3 px-3 py-4 border-b border-[#2a2a2a] min-h-[56px]">
                {!collapsed && (
                    <span className="text-[#F4F1EA] font-bold text-sm leading-tight tracking-wide uppercase">
                        WALHI Jabar<br />
                        <span className="text-[#256D4A] text-xs font-normal">Admin Panel</span>
                    </span>
                )}
                <button onClick={onToggle} className="ml-auto text-[#888] hover:text-[#F4F1EA] transition-colors">
                    {collapsed ? <PanelLeft size={16} /> : <PanelLeftClose size={16} />}
                </button>
            </div>

            <nav className="flex-1 overflow-y-auto py-3 space-y-0.5 px-2">
                {nav.map((item) => {
                    if (item.path) {
                        const exact = item.path === '/admin';
                        const active = exact ? location.pathname === '/admin' : location.pathname.startsWith(item.path);

                        return (
                            <NavLink
                                key={item.path}
                                to={item.path}
                                className={cn('flex items-center gap-2.5 px-2 py-2 rounded text-sm transition-colors', active ? 'bg-[#256D4A] text-white' : 'text-[#aaa] hover:text-[#F4F1EA] hover:bg-[#2a2a2a]')}
                                title={collapsed ? item.label : undefined}
                            >
                                <span className="shrink-0">{item.icon}</span>
                                {!collapsed && <span>{item.label}</span>}
                            </NavLink>
                        );
                    }

                    const open = openGroups.includes(item.label);
                    const groupActive = isGroupActive(item.children ?? []);

                    return (
                        <div key={item.label}>
                            <button
                                onClick={() => !collapsed && toggle(item.label)}
                                className={cn('w-full flex items-center gap-2.5 px-2 py-2 rounded text-sm transition-colors', groupActive ? 'text-[#5C8D59]' : 'text-[#aaa] hover:text-[#F4F1EA] hover:bg-[#2a2a2a]')}
                                title={collapsed ? item.label : undefined}
                            >
                                <span className="shrink-0">{item.icon}</span>
                                {!collapsed && (
                                    <>
                                        <span className="flex-1 text-left">{item.label}</span>
                                        {open ? <ChevronDown size={12} /> : <ChevronRight size={12} />}
                                    </>
                                )}
                            </button>

                            {!collapsed && open && (
                                <div className="ml-4 mt-0.5 space-y-0.5 border-l border-[#2a2a2a] pl-3">
                                    {item.children?.map((child) => {
                                        const active = location.pathname === child.path;

                                        return (
                                            <NavLink
                                                key={child.path}
                                                to={child.path}
                                                className={cn('block px-2 py-1.5 rounded text-xs transition-colors', active ? 'text-[#5C8D59] font-semibold' : 'text-[#888] hover:text-[#F4F1EA]')}
                                            >
                                                {child.label}
                                            </NavLink>
                                        );
                                    })}
                                </div>
                            )}
                        </div>
                    );
                })}
            </nav>

            {!collapsed && (
                <div className="px-4 py-3 border-t border-[#2a2a2a]">
                    <a href="/" target="_blank" rel="noopener noreferrer" className="flex items-center gap-2 text-xs text-[#666] hover:text-[#5C8D59] transition-colors">
                        <ExternalLink size={12} />
                        Lihat Website Publik
                    </a>
                </div>
            )}
        </aside>
    );
}