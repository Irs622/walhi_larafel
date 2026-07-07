@php
    $seoTitle = $title ?? 'WALHI Jawa Barat - Advokasi Lingkungan & Keadilan Ekologis';
    $seoDesc = $description ?? 'Organisasi gerakan lingkungan hidup independen terbesar di Jawa Barat. Memperjuangkan keadilan ekologis, pendampingan hukum agraria, dan perlindungan hutan.';
    $seoImage = isset($image) && $image ? (str_starts_with($image, 'http') ? $image : asset($image)) : asset('assets/images/resources/logo-2-walhi.png');
    $seoUrl = url()->current();
@endphp
 
<!-- SEO Meta Tags -->
<title>{{ $seoTitle }}</title>
<meta name="description" content="{{ $seoDesc }}">
<meta name="robots" content="index, follow">
 
<!-- Open Graph / Facebook -->
<meta property="og:type" content="website">
<meta property="og:url" content="{{ $seoUrl }}">
<meta property="og:title" content="{{ $seoTitle }}">
<meta property="og:description" content="{{ $seoDesc }}">
<meta property="og:image" content="{{ $seoImage }}">
 
<!-- Twitter -->
<meta property="twitter:card" content="summary_large_image">
<meta property="twitter:url" content="{{ $seoUrl }}">
<meta property="twitter:title" content="{{ $seoTitle }}">
<meta property="twitter:description" content="{{ $seoDesc }}">
<meta property="twitter:image" content="{{ $seoImage }}">
