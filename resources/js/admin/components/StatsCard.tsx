import { cn } from './ui/utils';

type Props = {
    label: string;
    value: string | number;
    sub?: string;
    icon: React.ReactNode;
    accent?: 'green' | 'orange' | 'brown' | 'moss';
};

const accentMap = {
    green: 'bg-[#256D4A] text-white',
    orange: 'bg-[#D95C3F] text-white',
    brown: 'bg-[#8B6B4A] text-white',
    moss: 'bg-[#5C8D59] text-white',
};

export function StatsCard({ label, value, sub, icon, accent = 'green' }: Props) {
    return (
        <div className="bg-white border border-[#ddd] rounded-lg p-5 flex items-start gap-4">
            <div className={cn('w-10 h-10 rounded-lg flex items-center justify-center shrink-0', accentMap[accent])}>{icon}</div>
            <div className="min-w-0">
                <div className="text-xs text-[#888] uppercase tracking-wide mb-1">{label}</div>
                <div className="text-2xl font-bold text-[#1D1D1D] leading-tight">{value}</div>
                {sub && <div className="text-xs text-[#888] mt-0.5">{sub}</div>}
            </div>
        </div>
    );
}