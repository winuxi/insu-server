<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="keywords" content="{{ appName() }}">
    <title>@yield('title', appName() . ' - ' . seoTitle())</title>

    <meta name="keywords" content="{{ seoKeywords() }}">
    <meta name="description" content="{{ seoDescription() }}">
    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ appFavicon() }}">

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap"
        rel="stylesheet">


    <script src="{{ asset('js/tailwind.js') }}"></script>

    @vite(['resources/css/landing.css', 'resources/js/landing.js'])

    @stack('head')
</head>

<body class="@yield('body-class', 'bg-slate-50')">
    <!-- Navigation -->
    @include('layouts.navigation')

    <!-- Main Content -->
    <main>
        @yield('content')
    </main>

    <!-- Footer -->
    @include('layouts.footer')

    @stack('scripts')
</body>

</html>
