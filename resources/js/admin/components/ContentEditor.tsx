import { useEffect } from 'react';
import * as Dialog from '@radix-ui/react-dialog';
import { useForm } from 'react-hook-form';
import { X } from 'lucide-react';
import type { ContentItem, ContentStatus } from '../hooks/useLocalStore';

type FormData = {
    title: string;
    slug: string;
    body: string;
    tags: string;
    status: ContentStatus;
    imageUrl: string;
    publishDate: string;
};

type Props = {
    open: boolean;
    onClose: () => void;
    item: ContentItem | null;
    onSave: (data: Omit<ContentItem, 'id' | 'createdAt' | 'updatedAt' | 'category'>) => void;
    pageTitle: string;
};

function toSlug(value: string) {
    return value.toLowerCase().replace(/[^a-z0-9]+/g, '-').replace(/(^-|-$)/g, '');
}

export function ContentEditor({ open, onClose, item, onSave, pageTitle }: Props) {
    const { register, handleSubmit, reset, watch, setValue, formState: { errors } } = useForm<FormData>({
        defaultValues: { status: 'draft', publishDate: new Date().toISOString().slice(0, 10) },
    });

    const titleValue = watch('title');

    useEffect(() => {
        if (item) {
            reset({
                title: item.title,
                slug: item.slug,
                body: item.body,
                tags: item.tags,
                status: item.status,
                imageUrl: item.imageUrl,
                publishDate: item.publishDate,
            });
        } else {
            reset({ title: '', slug: '', body: '', tags: '', status: 'draft', imageUrl: '', publishDate: new Date().toISOString().slice(0, 10) });
        }
    }, [item, open, reset]);

    useEffect(() => {
        if (!item && titleValue) {
            setValue('slug', toSlug(titleValue));
        }
    }, [item, setValue, titleValue]);

    function submit(data: FormData) {
        onSave(data);
        onClose();
    }

    return (
        <Dialog.Root open={open} onOpenChange={(value) => !value && onClose()}>
            <Dialog.Portal>
                <Dialog.Overlay className="fixed inset-0 bg-black/50 z-50 backdrop-blur-sm" />
                <Dialog.Content className="fixed left-1/2 top-1/2 -translate-x-1/2 -translate-y-1/2 w-full max-w-2xl max-h-[90vh] overflow-y-auto z-50 bg-white rounded-xl shadow-2xl">
                    <div className="flex items-center justify-between px-6 py-4 border-b border-[#ddd] sticky top-0 bg-white z-10">
                        <Dialog.Title className="font-bold text-[#1D1D1D]">{item ? `Edit ${pageTitle}` : `Tambah ${pageTitle}`}</Dialog.Title>
                        <button onClick={onClose} className="p-1.5 rounded hover:bg-[#f0ede8] transition-colors">
                            <X size={16} />
                        </button>
                    </div>

                    <form onSubmit={handleSubmit(submit)} className="p-6 space-y-4">
                        <div>
                            <label className="block text-xs font-semibold text-[#555] mb-1.5 uppercase tracking-wide">Judul *</label>
                            <input {...register('title', { required: 'Judul wajib diisi' })} className="w-full px-3 py-2 border border-[#ddd] rounded text-sm focus:outline-none focus:border-[#256D4A]" placeholder="Masukkan judul..." />
                            {errors.title && <p className="text-xs text-[#D95C3F] mt-1">{errors.title.message}</p>}
                        </div>

                        <div>
                            <label className="block text-xs font-semibold text-[#555] mb-1.5 uppercase tracking-wide">Slug URL</label>
                            <input {...register('slug')} className="w-full px-3 py-2 border border-[#ddd] rounded text-sm font-mono text-[#666] focus:outline-none focus:border-[#256D4A]" placeholder="slug-otomatis" />
                        </div>

                        <div className="grid grid-cols-2 gap-4">
                            <div>
                                <label className="block text-xs font-semibold text-[#555] mb-1.5 uppercase tracking-wide">Status</label>
                                <select {...register('status')} className="w-full px-3 py-2 border border-[#ddd] rounded text-sm focus:outline-none focus:border-[#256D4A] bg-white">
                                    <option value="draft">Draf</option>
                                    <option value="published">Terbit</option>
                                    <option value="archived">Arsip</option>
                                </select>
                            </div>
                            <div>
                                <label className="block text-xs font-semibold text-[#555] mb-1.5 uppercase tracking-wide">Tanggal Terbit</label>
                                <input type="date" {...register('publishDate')} className="w-full px-3 py-2 border border-[#ddd] rounded text-sm focus:outline-none focus:border-[#256D4A]" />
                            </div>
                        </div>

                        <div>
                            <label className="block text-xs font-semibold text-[#555] mb-1.5 uppercase tracking-wide">URL Gambar Utama</label>
                            <input {...register('imageUrl')} className="w-full px-3 py-2 border border-[#ddd] rounded text-sm focus:outline-none focus:border-[#256D4A]" placeholder="https://..." />
                        </div>

                        <div>
                            <label className="block text-xs font-semibold text-[#555] mb-1.5 uppercase tracking-wide">Tag (pisah dengan koma)</label>
                            <input {...register('tags')} className="w-full px-3 py-2 border border-[#ddd] rounded text-sm focus:outline-none focus:border-[#256D4A]" placeholder="lingkungan, air, hutan" />
                        </div>

                        <div>
                            <label className="block text-xs font-semibold text-[#555] mb-1.5 uppercase tracking-wide">Konten / Deskripsi</label>
                            <textarea {...register('body')} rows={8} className="w-full px-3 py-2 border border-[#ddd] rounded text-sm focus:outline-none focus:border-[#256D4A] resize-y" placeholder="Tulis konten di sini..." />
                        </div>

                        <div className="flex justify-end gap-3 pt-2">
                            <button type="button" onClick={onClose} className="px-4 py-2 text-sm border border-[#ddd] rounded hover:bg-[#f0ede8] transition-colors">
                                Batal
                            </button>
                            <button type="submit" className="px-5 py-2 text-sm bg-[#256D4A] text-white font-semibold rounded hover:bg-[#1e5a3d] transition-colors">
                                {item ? 'Simpan Perubahan' : 'Terbitkan'}
                            </button>
                        </div>
                    </form>
                </Dialog.Content>
            </Dialog.Portal>
        </Dialog.Root>
    );
}