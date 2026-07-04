import { useState } from 'react';
import { Calendar, Clock, MapPin, Users } from 'lucide-react';
import { ContentEditor } from '../components/ContentEditor';
import { ContentTable } from '../components/ContentTable';
import { StatsCard } from '../components/StatsCard';
import type { ContentItem } from '../hooks/useLocalStore';
import { useLocalStore } from '../hooks/useLocalStore';

const upcomingEvents = [
    { name: 'Pekan Rakyat Lingkungan Hidup 2025', date: '15–20 Agt 2025', location: 'Bandung', registered: 342 },
    { name: 'Workshop Pemantauan Kualitas Air', date: '5 Agt 2025', location: 'Cirebon', registered: 48 },
    { name: 'Aksi Bersih Sungai Cikapundung', date: '27 Jul 2025', location: 'Bandung', registered: 91 },
];

export function PekanRakyatManager() {
    const { items, add, update, remove } = useLocalStore('pekan-rakyat');
    const [editorOpen, setEditorOpen] = useState(false);
    const [editItem, setEditItem] = useState<ContentItem | null>(null);

    return (
        <div className="space-y-6">
            <div>
                <h1 className="text-2xl font-bold text-[#1D1D1D]">Pekan Rakyat Lingkungan Hidup</h1>
                <p className="text-sm text-[#888] mt-1">Manajemen event dan pendaftaran peserta</p>
            </div>

            <div className="grid grid-cols-2 lg:grid-cols-4 gap-4">
                <StatsCard label="Event Aktif" value="3" sub="Bulan ini" icon={<Calendar size={18} />} accent="green" />
                <StatsCard label="Total Peserta" value="481" sub="Terdaftar" icon={<Users size={18} />} accent="moss" />
                <StatsCard label="Lokasi" value="5" sub="Kota di Jabar" icon={<MapPin size={18} />} accent="brown" />
                <StatsCard label="Event Mendatang" value="2" sub="dalam 7 hari" icon={<Clock size={18} />} accent="orange" />
            </div>

            <div className="bg-white border border-[#ddd] rounded-lg p-5">
                <h2 className="font-bold text-[#1D1D1D] text-sm mb-4">Event Mendatang</h2>
                <div className="space-y-3">
                    {upcomingEvents.map((event, index) => (
                        <div key={index} className="flex items-center justify-between gap-4 p-3 rounded-lg bg-[#f9f8f5] border border-[#eee]">
                            <div className="flex items-start gap-3">
                                <div className="w-8 h-8 rounded-lg bg-[#256D4A] flex items-center justify-center shrink-0">
                                    <Calendar size={14} className="text-white" />
                                </div>
                                <div>
                                    <p className="text-sm font-semibold text-[#1D1D1D]">{event.name}</p>
                                    <p className="text-xs text-[#888]">
                                        {event.date} · {event.location}
                                    </p>
                                </div>
                            </div>
                            <div className="text-right shrink-0">
                                <p className="text-sm font-bold text-[#256D4A]">{event.registered}</p>
                                <p className="text-[10px] text-[#888]">peserta</p>
                            </div>
                        </div>
                    ))}
                </div>
            </div>

            <div>
                <h2 className="font-bold text-[#1D1D1D] text-base mb-4">Semua Event</h2>
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
                    pageTitle="Event"
                />
            </div>

            <ContentEditor open={editorOpen} onClose={() => setEditorOpen(false)} item={editItem} onSave={(data) => (editItem ? update(editItem.id, data) : add(data))} pageTitle="Event" />
        </div>
    );
}