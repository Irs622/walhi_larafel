<?php

namespace App\Enums;

enum ContentCategory: string
{
    // ── Publikasi / Berita ─────────────────────────────────────────
    case Blog          = 'blog';
    case SiaranPers    = 'siaran-pers';
    case Infografis    = 'infografis';
    case KertasPosisi  = 'kertas-posisi';

    // ── Dokumen Resmi ─────────────────────────────────────────────
    case Regulasi      = 'regulasi';
    case LaporanTahunan = 'laporan-tahunan';

    // ── Terbitan Berkala ──────────────────────────────────────────
    case Newsletter    = 'newsletter';
    case BuletinBumi   = 'buletin-bumi';
    case Jurnal        = 'jurnal';

    // ── Profil Organisasi ─────────────────────────────────────────
    case Sejarah           = 'sejarah';
    case VisiMisi          = 'visi-misi';
    case DewanNasional     = 'dewan-nasional';
    case EksekutifNasional = 'eksekutif-nasional';
    case EksekutifDaerah   = 'eksekutif-daerah';
    case Kontak            = 'kontak';

    // ── Kampanye & Event ──────────────────────────────────────────
    case Donasi          = 'donasi';
    case PekanRakyat     = 'pekan-rakyat';
    case KampanyeDarurat = 'kampanye-darurat';

    // ── Beranda ───────────────────────────────────────────────────
    case Statistik  = 'statistik';
    case IsuKritis  = 'isu-kritis';

    /**
     * Human-readable label in Indonesian.
     */
    public function label(): string
    {
        return match ($this) {
            self::Blog             => 'Blog',
            self::SiaranPers       => 'Siaran Pers',
            self::Infografis       => 'Infografis',
            self::KertasPosisi     => 'Kertas Posisi',
            self::Regulasi         => 'Regulasi',
            self::LaporanTahunan   => 'Laporan Tahunan',
            self::Newsletter       => 'E-Newsletter',
            self::BuletinBumi      => 'Buletin Bumi',
            self::Jurnal           => 'Jurnal Tanah Air',
            self::Sejarah          => 'Sejarah',
            self::VisiMisi         => 'Visi & Misi',
            self::DewanNasional    => 'Dewan Nasional',
            self::EksekutifNasional=> 'Eksekutif Nasional',
            self::EksekutifDaerah  => 'Eksekutif Daerah',
            self::Kontak           => 'Kontak',
            self::Donasi           => 'Kampanye Donasi',
            self::PekanRakyat      => 'Pekan Rakyat',
            self::KampanyeDarurat  => 'Kampanye Darurat',
            self::Statistik        => 'Statistik Utama',
            self::IsuKritis        => 'Isu Kritis',
        };
    }

    /**
     * Categories that represent publishable editorial content
     * (articles, reports, periodicals). Used for dashboard counts,
     * sitemaps, etc.
     *
     * @return self[]
     */
    public static function publishableCategories(): array
    {
        return [
            self::Blog,
            self::SiaranPers,
            self::Infografis,
            self::KertasPosisi,
            self::Regulasi,
            self::LaporanTahunan,
            self::Newsletter,
            self::BuletinBumi,
            self::Jurnal,
        ];
    }

    /**
     * Return the string values of publishable categories.
     * Useful for ->whereIn() Eloquent queries.
     *
     * @return string[]
     */
    public static function publishableCategoryValues(): array
    {
        return array_map(fn (self $c) => $c->value, self::publishableCategories());
    }

    /**
     * Categories that represent news/press content
     * (displayed on blog & detail pages).
     *
     * @return string[]
     */
    public static function newsValues(): array
    {
        return [self::Blog->value, self::SiaranPers->value];
    }
}
