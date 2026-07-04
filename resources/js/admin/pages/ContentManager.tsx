import { useState } from 'react';
import { ContentEditor } from '../components/ContentEditor';
import { ContentTable } from '../components/ContentTable';
import type { ContentItem } from '../hooks/useLocalStore';
import { useLocalStore } from '../hooks/useLocalStore';

type Props = {
    category: string;
    pageTitle: string;
    description?: string;
};

export function ContentManager({ category, pageTitle, description }: Props) {
    const { items, add, update, remove } = useLocalStore(category);
    const [editorOpen, setEditorOpen] = useState(false);
    const [editItem, setEditItem] = useState<ContentItem | null>(null);

    function handleAdd() {
        setEditItem(null);
        setEditorOpen(true);
    }

    function handleEdit(item: ContentItem) {
        setEditItem(item);
        setEditorOpen(true);
    }

    function handleSave(data: Omit<ContentItem, 'id' | 'createdAt' | 'updatedAt' | 'category'>) {
        if (editItem) {
            update(editItem.id, data);
            return;
        }

        add(data);
    }

    function handleToggleStatus(item: ContentItem) {
        const next = item.status === 'published' ? 'archived' : 'published';
        update(item.id, { status: next });
    }

    return (
        <div className="space-y-5">
            <div>
                <h1 className="text-2xl font-bold text-[#1D1D1D]">{pageTitle}</h1>
                {description && <p className="text-sm text-[#888] mt-1">{description}</p>}
                <div className="flex gap-4 mt-3 text-xs text-[#888]">
                    <span>
                        Total: <strong className="text-[#1D1D1D]">{items.length}</strong>
                    </span>
                    <span>
                        Terbit: <strong className="text-[#256D4A]">{items.filter((item) => item.status === 'published').length}</strong>
                    </span>
                    <span>
                        Draf: <strong className="text-[#8B6B4A]">{items.filter((item) => item.status === 'draft').length}</strong>
                    </span>
                    <span>
                        Arsip: <strong className="text-[#888]">{items.filter((item) => item.status === 'archived').length}</strong>
                    </span>
                </div>
            </div>

            <ContentTable items={items} onAdd={handleAdd} onEdit={handleEdit} onDelete={remove} onToggleStatus={handleToggleStatus} pageTitle={pageTitle} />

            <ContentEditor open={editorOpen} onClose={() => setEditorOpen(false)} item={editItem} onSave={handleSave} pageTitle={pageTitle} />
        </div>
    );
}