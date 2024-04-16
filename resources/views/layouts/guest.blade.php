<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="icon" href="{{ asset('images/maix.png') }}" type="image/x-icon">
    <link rel="shortcut icon" href="{{ asset('images/maix.png') }}" type="image/x-icon">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans text-gray-900 antialiased">
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 {{-- bg-gray-100 dark:bg-gray-900 --}} bg-fondo bg-no-repeat bg-cover">
        <div>
            <a href="/">
                <x-application-logo class=" h-20 fill-current text-gray-500" />
            </a>
        </div>
        {{-- flex flex-col items-center justify-center px-6 py-8 mx-auto md:h-screen lg:py-0 --}}
        <div class="px-5 w-full sm:max-w-md">
            <div class="shadow-[0px_0px_6px_5px_rgba(255,255,255,1)] mt-6 px-6 py-4 bg-[#E6A930] dark:bg-gray-800  overflow-hidden rounded-lg">
                {{ $slot }}
            </div>
        </div>
    </div>
</body>

</html>