<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <link rel="icon" href="{{ asset('images/favi.png') }}" type="image/png">
        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Google Fonts: Hind Siliguri -->
<link href="https://fonts.googleapis.com/css2?family=Hind+Siliguri:wght@400;600;700&display=swap" rel="stylesheet">

        <!-- Scripts -->
           {{-- <script src="https://cdn.tailwindcss.com"></script>  --}}
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body style="font-family:Hind Siliguri" class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @isset($header)
                <header class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <!-- Page Content -->
            <main>
               @yield('content')
            </main>
        </div>


        {{-- Our footer credit --}}
        @include('partials.footer_credit')  


        <script>
        document.addEventListener('mousemove', function(e) {
        document.querySelectorAll('.quiz-card').forEach(card => {
            const rect = card.getBoundingClientRect();
            const x = e.clientX - rect.left;
            const y = e.clientY - rect.top;
            card.style.setProperty('--mouse-x', `${x}px`);
            card.style.setProperty('--mouse-y', `${y}px`);
        });
        });
        </script>
        <style>
        .quiz-card::before {
        content: '';
        pointer-events: none;
        position: absolute;
        left: 0; top: 0; width: 100%; height: 100%;
        background: radial-gradient(circle at var(--mouse-x, 50%) var(--mouse-y, 50%), rgba(96,165,250,0.15) 0%, transparent 80%);
        opacity: 1; transition: opacity .3s;
        }
        .quiz-card:active::before, .quiz-card:focus-within::before { opacity: 0; }
        </style>
        <script src="//unpkg.com/alpinejs" defer></script>

    </body>
</html>
