import { StrictMode } from 'react';
import { createRoot } from 'react-dom/client';
import { BrowserRouter } from 'react-router-dom';
import { AdminLayout } from './admin/AdminLayout';

const container = document.getElementById('admin-app');

if (container) {
    createRoot(container).render(
        <StrictMode>
            <BrowserRouter>
                <AdminLayout />
            </BrowserRouter>
        </StrictMode>,
    );
}