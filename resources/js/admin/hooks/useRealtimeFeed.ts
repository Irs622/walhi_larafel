import { useEffect, useState } from 'react';

export type FeedEvent = {
    id: string;
    type: 'donation' | 'comment' | 'pageview' | 'submission' | 'publish' | 'login';
    message: string;
    detail: string;
    timestamp: Date;
};

const eventTemplates: Omit<FeedEvent, 'id' | 'timestamp'>[] = [
    { type: 'donation', message: 'Donasi baru masuk', detail: 'Rp 250.000 dari Budi Santoso' },
    { type: 'donation', message: 'Donasi baru masuk', detail: 'Rp 500.000 dari Anonim' },
    { type: 'donation', message: 'Donasi baru masuk', detail: 'Rp 100.000 dari Siti Rahayu' },
    { type: 'comment', message: 'Komentar baru di Blog', detail: '"Artikel ini sangat informatif!" — Ahmad R.' },
    { type: 'comment', message: 'Komentar baru di Siaran Pers', detail: '"Terima kasih atas informasinya." — Dewi S.' },
    { type: 'pageview', message: 'Lonjakan pengunjung', detail: 'Halaman Laporan Tahunan +340 views' },
    { type: 'pageview', message: 'Trafik meningkat', detail: 'Blog "Krisis Air Citarum" sedang viral' },
    { type: 'submission', message: 'Form Kontak terkirim', detail: 'Dari: press@mediaindonesia.co.id' },
    { type: 'submission', message: 'Pendaftaran Pekan Rakyat', detail: '3 peserta baru mendaftar' },
    { type: 'publish', message: 'Artikel dipublikasikan', detail: '"Update Kasus Tambang Emas Pongkor"' },
    { type: 'login', message: 'Login admin baru', detail: 'admin@walhijabar.org dari Jakarta' },
];

function randomBetween(min: number, max: number) {
    return Math.floor(Math.random() * (max - min + 1)) + min;
}

export function useRealtimeFeed(maxEvents = 50) {
    const [events, setEvents] = useState<FeedEvent[]>(() => {
        const initial: FeedEvent[] = [];

        for (let index = 4; index >= 0; index -= 1) {
            const template = eventTemplates[randomBetween(0, eventTemplates.length - 1)];
            initial.push({
                ...template,
                id: `init-${index}`,
                timestamp: new Date(Date.now() - index * 60_000 * randomBetween(1, 5)),
            });
        }

        return initial;
    });

    useEffect(() => {
        function emit() {
            const template = eventTemplates[randomBetween(0, eventTemplates.length - 1)];
            const event: FeedEvent = {
                ...template,
                id: `${Date.now()}-${Math.random()}`,
                timestamp: new Date(),
            };

            setEvents((previous) => [event, ...previous].slice(0, maxEvents));
            scheduleNext();
        }

        let timer: ReturnType<typeof setTimeout>;

        function scheduleNext() {
            timer = setTimeout(emit, randomBetween(4_000, 9_000));
        }

        scheduleNext();

        return () => clearTimeout(timer);
    }, [maxEvents]);

    return events;
}