import { Navigate, useLocation } from 'react-router-dom';
import { ContentManager } from './pages/ContentManager';
import { DonasiManager } from './pages/DonasiManager';
import { Overview } from './pages/Overview';
import { PekanRakyatManager } from './pages/PekanRakyatManager';

export function AdminRouter() {
    const location = useLocation();
    const pathname = location.pathname.replace(/\/$/, '');

    if (pathname === '/admin') {
        return <Overview />;
    }

    if (pathname === '/admin/blog') {
        return <ContentManager category="blog" pageTitle="Blog" description="Kelola artikel dan tulisan di halaman Blog." />;
    }

    if (pathname === '/admin/regulasi') {
        return <ContentManager category="regulasi" pageTitle="Regulasi" description="Kelola dokumen peraturan dan regulasi lingkungan." />;
    }

    if (pathname === '/admin/siaran-pers') {
        return <ContentManager category="siaran-pers" pageTitle="Siaran Pers" description="Kelola siaran pers dan rilis media WALHI Jabar." />;
    }

    if (pathname === '/admin/infografis') {
        return <ContentManager category="infografis" pageTitle="Infografis" description="Kelola infografis dan visualisasi data lingkungan." />;
    }

    if (pathname === '/admin/kertas-posisi') {
        return <ContentManager category="kertas-posisi" pageTitle="Kertas Posisi" description="Kelola dokumen posisi kebijakan WALHI Jabar." />;
    }

    if (pathname === '/admin/newsletter') {
        return <ContentManager category="newsletter" pageTitle="E-Newsletter" description="Kelola edisi E-Newsletter WALHI Jabar." />;
    }

    if (pathname === '/admin/buletin-bumi') {
        return <ContentManager category="buletin-bumi" pageTitle="Buletin Bumi" description="Kelola edisi Buletin Bumi." />;
    }

    if (pathname === '/admin/jurnal') {
        return <ContentManager category="jurnal" pageTitle="Jurnal Tanah Air" description="Kelola edisi Jurnal Tanah Air." />;
    }

    if (pathname === '/admin/laporan-tahunan') {
        return <ContentManager category="laporan-tahunan" pageTitle="Laporan Tahunan" description="Kelola laporan tahunan organisasi." />;
    }

    if (pathname === '/admin/donasi') {
        return <DonasiManager />;
    }

    if (pathname === '/admin/pekan-rakyat') {
        return <PekanRakyatManager />;
    }

    if (pathname === '/admin/tentang/sejarah') {
        return <ContentManager category="sejarah" pageTitle="Sejarah" description="Kelola halaman Sejarah organisasi." />;
    }

    if (pathname === '/admin/tentang/visi-misi') {
        return <ContentManager category="visi-misi" pageTitle="Visi & Misi" description="Kelola konten Visi dan Misi." />;
    }

    if (pathname === '/admin/tentang/dewan-nasional') {
        return <ContentManager category="dewan-nasional" pageTitle="Dewan Nasional" description="Kelola data anggota Dewan Nasional." />;
    }

    if (pathname === '/admin/tentang/eksekutif-nasional') {
        return <ContentManager category="eksekutif-nasional" pageTitle="Eksekutif Nasional" description="Kelola data Eksekutif Nasional." />;
    }

    if (pathname === '/admin/tentang/eksekutif-daerah') {
        return <ContentManager category="eksekutif-daerah" pageTitle="Eksekutif Daerah" description="Kelola data Eksekutif Daerah." />;
    }

    if (pathname === '/admin/tentang/kontak') {
        return <ContentManager category="kontak" pageTitle="Kontak" description="Kelola informasi kontak organisasi." />;
    }

    return <Navigate to="/admin" replace />;
}