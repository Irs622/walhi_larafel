import { Area, AreaChart, CartesianGrid, ResponsiveContainer, Tooltip, XAxis, YAxis } from 'recharts';

const data = [
    { month: "Agt '24", amount: 12_500_000 },
    { month: "Sep '24", amount: 18_200_000 },
    { month: "Okt '24", amount: 14_800_000 },
    { month: "Nov '24", amount: 22_000_000 },
    { month: "Des '24", amount: 31_500_000 },
    { month: "Jan '25", amount: 19_300_000 },
    { month: "Feb '25", amount: 16_700_000 },
    { month: "Mar '25", amount: 24_100_000 },
    { month: "Apr '25", amount: 27_800_000 },
    { month: "Mei '25", amount: 33_200_000 },
    { month: "Jun '25", amount: 29_400_000 },
    { month: "Jul '25", amount: 38_900_000 },
];

function formatRp(value: number) {
    if (value >= 1_000_000) {
        return `Rp ${(value / 1_000_000).toFixed(0)}jt`;
    }

    return `Rp ${value.toLocaleString('id-ID')}`;
}

export function DonationChart() {
    return (
        <ResponsiveContainer width="100%" height={200}>
            <AreaChart data={data} margin={{ top: 5, right: 10, left: 0, bottom: 5 }}>
                <defs>
                    <linearGradient id="donGrad" x1="0" y1="0" x2="0" y2="1">
                        <stop offset="5%" stopColor="#256D4A" stopOpacity={0.3} />
                        <stop offset="95%" stopColor="#256D4A" stopOpacity={0} />
                    </linearGradient>
                </defs>
                <CartesianGrid strokeDasharray="3 3" stroke="#eee" />
                <XAxis dataKey="month" tick={{ fontSize: 10, fill: '#888' }} tickLine={false} axisLine={false} />
                <YAxis tickFormatter={(value: number) => formatRp(value)} tick={{ fontSize: 10, fill: '#888' }} tickLine={false} axisLine={false} width={60} />
                <Tooltip
                    formatter={(value: number) => [value.toLocaleString('id-ID', { style: 'currency', currency: 'IDR', maximumFractionDigits: 0 }), 'Donasi']}
                    contentStyle={{ fontSize: 12, borderColor: '#ddd' }}
                />
                <Area type="monotone" dataKey="amount" stroke="#256D4A" strokeWidth={2} fill="url(#donGrad)" />
            </AreaChart>
        </ResponsiveContainer>
    );
}