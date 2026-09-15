# Frontend Architecture & Design System Guide

This document outlines the visual identity, design tokens, template hierarchy, client-side interactivity, and asset pipeline for the **WALHI Jawa Barat** web platform. AI coding agents modifying views or stylesheets must strictly follow these rules to preserve design coherence and security integrity.

---

## 1. Visual Identity & Neo-Brutalist Design Philosophy

The WALHI Jawa Barat frontend follows a distinct **Neo-Brutalist** aesthetic reflecting the grassroots environmental activism domain:
- **High Contrast & Sharp Borders**: High contrast between paper backgrounds and ink blacks; sharp rectangular borders (typically `border-2 border-[#1D1D1D]` or `border-4 border-[#256D4A]`).
- **No Soft Skeuomorphism**: Avoid generic soft dropshadows (`shadow-lg`), heavy border radii (`rounded-full` or `rounded-2xl` on structural cards), or generic corporate pastel palettes.
- **Editorial Punch**: Bold uppercase titles, strong badge callouts, clean grid alignment, and prominent action banners.

### Core Color Palette Tokens (`brand.*`)
All colors are configured in [tailwind.config.js](file:///Users/mac/Downloads/walhi_larafel/tailwind.config.js):

| Token | Hex Value | Semantic Usage |
| :--- | :--- | :--- |
| `brand.cream` | `#F4F1EA` | Primary page background (warm off-white/paper texture) |
| `brand.dark` | `#1D1D1D` | Primary ink text, heavy dark section blocks, high-contrast borders |
| `brand.green` | `#256D4A` | WALHI forest green: primary brand identity, active tabs, action buttons |
| `brand.green-light` | `#5C8D59` | Secondary green: badges, hover accents, success highlights |
| `brand.orange` | `#D95C3F` | Urgency alert: campaign highlights, petition CTA, error notices |
| `brand.brown` | `#8B6B4A` | Earth brown: secondary category badges, historical/archive tags |

---

## 2. Typography System

The typography system pairs an expressive geometric sans-serif for headlines with a highly legible humanist sans-serif for narrative copy:

### Hierarchy & Fonts
1. **Headlines & Display (`font-heading`, `font-label`, `font-oswald`)**:
   - **Font**: `Aspekta` (loaded locally via `/assets/fonts/webfonts/font-face.css`).
   - **Styling**: Uppercase, bold/extrabold (`font-bold` / `font-extrabold`), tight tracking (`tracking-wide` or `tracking-tight`), compact leading (`leading-none` to `leading-tight`).
   - **Usage**: Page titles (`h1`), section banners (`h2`), card headers (`h3`, `h4`), metadata tags, button labels.
2. **Body & Narrative (`font-sans`)**:
   - **Font**: `Montserrat` (loaded via Google Fonts with local fallback).
   - **Styling**: Standard sentence case, regular/medium weights (`font-normal` / `font-medium`), relaxed line height (`leading-relaxed` or `leading-loose`).
   - **Usage**: Article paragraphs, form inputs, lists, administrative tables.

---

## 3. Blade Layout & Template Hierarchy

Views are located in `resources/views/` and organized into two primary interfaces:

```text
resources/views/
├── layouts/
│   ├── admin.blade.php           # Admin panel shell (sidebar, topbar, anti-indexing shield)
│   ├── app.blade.php             # Authenticated user fallback layout
│   ├── guest.blade.php           # Guest authentication container (/portal-jabar)
│   └── navigation.blade.php      # Top nav bar component
├── partials/
│   ├── seo-meta.blade.php        # Dynamic meta, OpenGraph, and Twitter tags
│   ├── site-header.blade.php     # Public header, navigation menu, emergency alert
│   └── site-footer.blade.php     # Organization details, newsletter widget, social links
├── admin/                        # Admin views (dashboard, content CRUD, comments, subscribers)
├── errors/                       # Branded error pages (403, 404, 419, 500)
├── welcome.blade.php             # Homepage with emergency campaign hero & issue grid
├── blog.blade.php                # Articles & publications listing
├── content-detail.blade.php      # Unified long-form reading view
├── donasi.blade.php              # Public donation & crowdfunding interface
├── regulasi.blade.php            # Environmental policy & legal database
└── tentang-kami.blade.php        # Organization history, structure, & executive board
```

### Layout Conventions
- **Public Views**: Public pages include [partials/seo-meta.blade.php](file:///Users/mac/Downloads/walhi_larafel/resources/views/partials/seo-meta.blade.php), [partials/site-header.blade.php](file:///Users/mac/Downloads/walhi_larafel/resources/views/partials/site-header.blade.php), and [partials/site-footer.blade.php](file:///Users/mac/Downloads/walhi_larafel/resources/views/partials/site-footer.blade.php).
- **Admin Layout**: All views in `admin/` extend `layouts.admin` (`@extends('layouts.admin')`).
  - Includes robots meta tags: `<meta name="robots" content="noindex, nofollow, noarchive, nosnippet">` to shield admin routes from web scrapers and crawlers.
  - Generates dynamic breadcrumbs from route names via `$breadcrumbMap`.

---

## 4. Client-side Interactivity & Alpine.js Conventions

Interactivity is intentionally lightweight and server-driven:
- **Alpine.js (v3.x)**: Used for declarative state management (mobile drawer toggle, dropdown menus, tab switching, and accordion toggles).
  - Bootstrapped globally in [resources/js/app.js](file:///Users/mac/Downloads/walhi_larafel/resources/js/app.js) (`window.Alpine = Alpine; Alpine.start();`).
  - Use `x-data="{ open: false }"` and `x-cloak` to avoid UI flicker during hydration.
- **Icons**: Lucide icons are used across the administrative dashboard.
  - Loaded via CDN with Subresource Integrity (SRI) hash and CSP Nonce:
    ```html
    <script nonce="{{ Vite::cspNonce() }}" src="https://unpkg.com/lucide@0.460.0/dist/umd/lucide.min.js" integrity="..." crossorigin="anonymous"></script>
    ```
  - Initialized on DOM ready via `lucide.createIcons()`.

---

## 5. Security & CSP Nonce Discipline

Under SEC-005, WALHI Jawa Barat enforces Content Security Policy (CSP) headers with a per-request cryptographically secure nonce generated in `SecurityHeaders` middleware:

1. **Mandatory Nonce on All `<script>` Tags**:
   Every `<script>` tag in Blade templates must include the dynamic nonce:
   ```blade
   <script nonce="{{ Vite::cspNonce() }}">
       // Inline script logic
   </script>
   ```
2. **Never Inject Raw External Scripts Without Integrity or Nonce**:
   Third-party CDN scripts must include `nonce="{{ Vite::cspNonce() }}"` and an SRI `integrity` attribute.
3. **Phase B Roadmap (Technical Debt)**:
   Avoid creating new inline HTML event handlers (`onclick="..."`, `onchange="..."`). Instead:
   - Prefer Alpine.js directives (`x-on:click="..."` or `@click="..."`).
   - Or attach event listeners in nonced scripts via `document.addEventListener(...)`.

---

## 6. Asset Build Pipeline (Vite)

- **Config**: [vite.config.js](file:///Users/mac/Downloads/walhi_larafel/vite.config.js) uses `laravel-vite-plugin` with entrypoints:
  - `resources/css/app.css`
  - `resources/js/app.js`
- **Commands**:
  ```bash
  npm run dev     # Starts local Vite development server with Hot Module Replacement (HMR)
  npm run build   # Compiles and minifies assets to public/build/ for production
  ```
- **In Blade**:
  ```blade
  @vite(['resources/css/app.css', 'resources/js/app.js'])
  ```
