<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title inertia>{{ config('app.name', 'Laravel') }}</title>

    <!-- Open Graph / Social Meta -->
    <meta property="og:type" content="website">
    <meta property="og:title" content="Ahmed Wael | Software Engineer & Full-Stack Developer">
    <meta property="og:description" content="Software Engineer and Full-Stack Developer building scalable web applications, reliable APIs, and modern user experiences.">
    <meta property="og:image" content="{{ asset('images/logo.png') }}">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta name="twitter:card" content="summary_large_image">

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="/images/logo.png">

    <!-- Prevent theme & locale flash before Vue mounts -->
    <script>
        (function() {
            try {
                var stored = localStorage.getItem('portfolio-theme');
                var theme = (stored === 'light' || stored === 'dark') ?
                    stored :
                    (window.matchMedia('(prefers-color-scheme: light)').matches ? 'light' : 'dark');
                document.documentElement.setAttribute('data-theme', theme);
            } catch (e) {
                document.documentElement.setAttribute('data-theme', 'dark');
            }

            try {
                var locale = localStorage.getItem('portfolio-locale');
                if (locale === 'ar' || locale === 'en') {
                    document.documentElement.setAttribute('lang', locale);
                    document.documentElement.setAttribute('dir', locale === 'ar' ? 'rtl' : 'ltr');
                }
            } catch (e) {}
        })();
    </script>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700|cairo:400,500,600,700&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @routes
    @vite(['resources/js/app.js', "resources/js/Pages/{$page['component']}.vue"])
    @inertiaHead
</head>

<body class="font-sans antialiased">
    @inertia
</body>

</html>
