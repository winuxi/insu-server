<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Error') - {{ appName() ?? config('app.name') }}</title>
    <script src="{{ asset('js/tailwind.js') }}"></script>
</head>
<body class="min-h-screen bg-gradient-to-br from-sky-800 via-sky-600 to-sky-500 flex items-center justify-center p-4">
    <div class="max-w-md w-full text-center">
        <!-- Error Icon -->
        <div class="mb-8">
            <div class="w-32 h-32 mx-auto bg-white/10 backdrop-blur-sm rounded-full flex items-center justify-center border border-white/20">
                <span class="text-6xl">@yield('icon', '❌')</span>
            </div>
        </div>

        <!-- Error Code -->
        <div class="mb-4">
            <h1 class="text-8xl font-black text-white drop-shadow-lg">
                @yield('code', '000')
            </h1>
        </div>

        <!-- Error Title -->
        <div class="mb-6">
            <h2 class="text-3xl font-bold text-white">
                @yield('title', 'Error')
            </h2>
        </div>

        <!-- Error Message -->
        <div class="mb-8">
            <p class="text-white/90 text-lg leading-relaxed">
                @yield('message', 'Something went wrong.')
            </p>
        </div>

        <!-- Action Buttons -->
        <div class="space-y-4 sm:space-y-0 sm:space-x-4 sm:flex sm:justify-center">
            @yield('actions')
        </div>
    </div>
</body>
</html>
