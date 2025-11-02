<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="@yield('meta_description', 'Skibidi Madness - A new story and adventures from the original series by FireStormX Studios')">
    <meta name="keywords" content="@yield('meta_keywords', 'Skibidi Toilet, Skibidi Madness, FireStormX Studios, Titan Cameraman, Titan Speakerman, Titan TV Man, G-Man, animation series')">
    <meta property="og:title" content="@yield('og_title', 'Skibidi Madness - Epic Multiverse Animation Series')">
    <meta property="og:description" content="@yield('og_description', 'New story and adventures featuring chaos, battles across multiple universes')">
    <meta property="og:image" content="@yield('og_image', asset('res/img/all-together.png'))">
    <meta property="og:type" content="website">
    <title>@yield('title', 'Skibidi Madness | FireStormX Studios')</title>
    <link rel="stylesheet" href="{{ asset('styles/main.css') }}">
    @yield('styles')
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400;500;700;900&family=Rajdhani:wght@300;400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>
    @yield('content')

    <script src="{{ asset('scripts/translations.js') }}"></script>
    @yield('scripts')
</body>
</html>
