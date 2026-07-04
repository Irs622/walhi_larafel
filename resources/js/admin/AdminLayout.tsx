import { useState } from 'react';
import { AdminRouter } from './AdminRouter';
import { Sidebar } from './components/Sidebar';
import { Topbar } from './components/Topbar';
import { useRealtimeFeed } from './hooks/useRealtimeFeed';

export function AdminLayout() {
    const [collapsed, setCollapsed] = useState(false);
    const events = useRealtimeFeed();

    return (
        <div className="flex h-screen bg-[#F4F1EA] overflow-hidden" style={{ fontFamily: 'Inter, sans-serif' }}>
            <Sidebar collapsed={collapsed} onToggle={() => setCollapsed((value) => !value)} />
            <div className="flex flex-col flex-1 min-w-0 overflow-hidden">
                <Topbar
                    notifCount={events.filter((event) => {
                        const age = Date.now() - event.timestamp.getTime();
                        return age < 60_000;
                    }).length}
                />
                <main className="flex-1 overflow-y-auto p-6">
                    <AdminRouter />
                </main>
            </div>
        </div>
    );
}