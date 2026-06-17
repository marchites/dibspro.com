<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>@yield('title', 'DibsPro - Temukan Rumah Impianmu')</title>

<meta name="description" content="@yield('meta_description', 'DibsPro adalah platform properti untuk mencari rumah, apartemen, tanah, dan simulasi KPR.')">
<meta name="keywords" content="properti, rumah dijual, apartemen, tanah, KPR, DibsPro">
<meta name="robots" content="index, follow">
<meta name="author" content="Astrobyte Indonesia">

<link rel="canonical" href="{{ url()->current() }}">

{{-- Open Graph --}}
<meta property="og:type" content="website">
<meta property="og:title" content="@yield('title', 'DibsPro - Temukan Rumah Impianmu')">
<meta property="og:description" content="@yield('meta_description', 'Temukan rumah impianmu bersama DibsPro.')">
<meta property="og:url" content="{{ url()->current() }}">
<meta property="og:image" content="{{ asset('assets/images/og-cover.jpg') }}">

{{-- Schema --}}
<script type="application/ld+json">
{!! json_encode([
    '@context' => 'https://schema.org',
    '@type' => 'RealEstateAgent',
    'name' => 'DibsPro',
    'url' => 'https://dibspro.com',
], JSON_UNESCAPED_SLASHES|JSON_PRETTY_PRINT) !!}
</script>