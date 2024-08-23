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
    <script src="{{ asset('js/pdf.min.js') }}"></script>
    <script src="{{ asset('js/pdf.worker.min.js') }}"></script>
</head>

<body class="font-sans antialiased">
    <div class="min-h-screen bg-gray-100 dark:bg-gray-900">
        {{-- @include('layouts.navigation') --}}

        {{--
        <!-- Page Heading -->
        @if (isset($header))
        <header class="bg-white shadow dark:bg-gray-800">
            <div class="px-4 py-6 mx-auto max-w-7xl sm:px-6 lg:px-8">
                {{ $header }}
            </div>
        </header>
        @endif --}}



        <!-- Page Content -->
        <main>
            @include('layouts.navigation')
            @include('layouts.aside'/* , ['sucursal' => $sucursal] */)
            <div class="p-4 text-4xl sm:ml-64">
                <div class="py-12">
                    {{ $slot }}
                </div>
            </div>
        </main>
    </div>
    <livewire:general.ordenes.modal-ordenes>
</body>


</html>