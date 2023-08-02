<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>@yield('title', 'Proposal Submission')</title>

        {{-- favicon --}}
        <link rel="shortcut icon" type="image/png" sizes="32x32" href="{{ asset('assets/img/favicon-uinsu.png') }}">
        <link rel="stylesheet" type="text/css" href="{{ url('css/style.css') }}">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        @livewireStyles

        {{-- jquery --}}
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.0/jquery.min.js"></script>

        {{-- flowbite --}}
        <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.5/flowbite.min.css" rel="stylesheet" />

        {{-- filepond --}}
        <link href="https://unpkg.com/filepond@^4/dist/filepond.css" rel="stylesheet" />
        
        @stack('styles')
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100">

            @include('partials.navbar')

            @include('partials.sidebar')

            <div class="p-4 sm:ml-64">

                <div class="pt-4 rounded-lg">
                    <div class="py-12">
                        @yield('breadcrumb')

                        @yield('content')
                    </div>
                </div>

                @include('partials.footer')

            </div>
        </div>

        @livewireScripts

        {{-- flowbite --}}
        <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.5/flowbite.min.js"></script>
        <script src="https://unpkg.com/flowbite@1.5.5/dist/flowbite.js"></script>

        {{-- filepond --}}
        <script src="https://unpkg.com/filepond@^4/dist/filepond.js"></script>
        
        @stack('scripts')
    </body>
</html>
