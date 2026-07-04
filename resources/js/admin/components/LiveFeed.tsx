import { useEffect, useRef } from 'react';
import { BookOpen, DollarSign, LogIn, MessageSquare, Send, TrendingUp } from 'lucide-react';
import type { FeedEvent } from '../hooks/useRealtimeFeed';
import { cn } from './ui/utils';

const iconMap: Record<FeedEvent['type'], React.ReactNode> = {
    donation: <DollarSign size={13} className="text-[#256D4A]" />,
    comment: <MessageSquare size={13} className="text-[#5C8D59]" />,
    pageview: <TrendingUp size={13} className="text-[#8B6B4A]" />,
    submission: <Send size={13} className="text-[#D95C3F]" />,
    publish: <BookOpen size={13} className="text-[#256D4A]" />,
    login: <LogIn size={13} className="text-[#888]" />,
};

const bgMap: Record<FeedEvent['type'], string> = {
    donation: 'bg-[#eaf4ee]',
    comment: 'bg-[#f0f5f0]',
    pageview: 'bg-[#f5f0ea]',
    submission: 'bg-[#fdf0ee]',
    publish: 'bg-[#eaf4ee]',
    login: 'bg-[#f5f5f5]',
};

function relativeTime(date: Date) {
    const diff = Math.floor((Date.now() - date.getTime()) / 1000);

    if (diff < 60) {
        return `${diff} detik lalu`;
    }

    if (diff < 3600) {
        return `${Math.floor(diff / 60)}m lalu`;
    }

    return `${Math.floor(diff / 3600)}j lalu`;
}

export function LiveFeed({ events }: { events: FeedEvent[] }) {
    const scrollRef = useRef<HTMLDivElement>(null);

    useEffect(() => {
        if (scrollRef.current) {
            scrollRef.current.scrollTop = 0;
        }
    }, [events.length]);

    return (
        <div className="flex flex-col h-full">
            <div className="flex items-center gap-2 mb-3">
                <span className="relative flex h-2 w-2">
                    <span className="animate-ping absolute inline-flex h-full w-full rounded-full bg-[#256D4A] opacity-75" />
                    <span className="relative inline-flex rounded-full h-2 w-2 bg-[#256D4A]" />
                </span>
                <span className="text-xs font-semibold text-[#1D1D1D] uppercase tracking-wide">Live Aktivitas</span>
            </div>
            <div ref={scrollRef} className="flex-1 overflow-y-auto space-y-2 pr-1">
                {events.map((event) => (
                    <div key={event.id} className={cn('flex items-start gap-2.5 p-2.5 rounded-lg border border-transparent', bgMap[event.type])}>
                        <div className="mt-0.5 shrink-0">{iconMap[event.type]}</div>
                        <div className="min-w-0 flex-1">
                            <div className="text-xs font-semibold text-[#1D1D1D] leading-snug">{event.message}</div>
                            <div className="text-xs text-[#666] truncate">{event.detail}</div>
                        </div>
                        <div className="text-[10px] text-[#aaa] shrink-0 mt-0.5">{relativeTime(event.timestamp)}</div>
                    </div>
                ))}
            </div>
        </div>
    );
}