<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Chesta Academy') }}</title>
    
    <!-- Favicon -->
    <link rel="icon" href="{{ asset('images/favi.png') }}" type="image/png">
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    
    <!-- Tailwind Elements -->
    <script src="https://cdn.jsdelivr.net/npm/@tabler/icons@1.74.0/icons-react/dist/index.umd.min.js"></script>
     @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        .auth-container {
            background: linear-gradient(135deg, rgba(255,255,255,0.98) 0%, rgba(255,255,255,0.99) 100%);
            backdrop-filter: blur(8px);
        }
        .gradient-bg {
            background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 50%, #a855f7 100%);
        }
    </style>
</head>
<body class="font-sans antialiased bg-gray-50">
    <div class="min-h-screen flex flex-col lg:flex-row">
        <!-- Brand/Motivation Section (Left) -->
        <div class="lg:w-1/2 gradient-bg flex items-center justify-center p-8 text-white">
            <div class="max-w-md text-center lg:text-left">
                <a href="/" class="inline-block mb-8">
                    <x-application-logo class="w-16 h-16 text-white" />
                </a>
                
                <h1 class="text-3xl font-bold mb-4">Welcome to <br>Chesta Academy</h1>
                
                <div class="bg-white/10 p-6 rounded-xl mb-8">
                    <p class="text-lg italic mb-2">"Education is the passport to the future..."</p>
                    <p class="text-sm">- Malcolm X</p>
                </div>
                
                <div class="hidden lg:block space-y-4">
                    <div class="flex items-center space-x-3">
                        <div class="w-8 h-8 bg-white/20 rounded-full flex items-center justify-center">
                            <i class="ti ti-certificate"></i>
                        </div>
                        <p>Industry-recognized certifications</p>
                    </div>
                    <div class="flex items-center space-x-3">
                        <div class="w-8 h-8 bg-white/20 rounded-full flex items-center justify-center">
                            <i class="ti ti-device-laptop"></i>
                        </div>
                        <p>Interactive learning experience</p>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Auth Content Section (Right) -->
        <div class="lg:w-1/2 flex items-center justify-center p-6 sm:p-12">
            <div class="w-full max-w-md">
                <!-- $slot content container -->
                <div class="auth-container rounded-xl shadow-lg border border-gray-100 overflow-hidden">
                    {{ $slot }}
                </div>
                
                <!-- Footer Links -->
                <div class="mt-6 text-center text-sm text-gray-600">
                    © {{ date('Y') }} Chesta Academy
                    <span class="mx-2">•</span>
                    <a href="#" class="text-indigo-600 hover:underline">Terms</a>
                    <span class="mx-2">•</span>
                    <a href="#" class="text-indigo-600 hover:underline">Privacy</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Rotating Motivational Quotes -->
    <script>
        const quotes = [
            {
                text: "And say, 'My Lord, increase me in knowledge.'",
                author: "Qur'an 20:114"
            },
            {
                text: "When a person dies, all his deeds end except three: a continuing charity, beneficial knowledge, and a child who prays for him.",
                author: "Hadith - Sahih Muslim"
            },
            {
                text: "Whoever takes a path in search of knowledge, Allah will make the path to Paradise easy for him.",
                author: "Hadith - Sahih Muslim"
            },
            {
                text: "Are those who know equal to those who do not know?",
                author: "Qur'an 39:9"
            },
            {
                text: "The best of you are those who learn the Qur'an and teach it.",
                author: "Hadith - Sahih al-Bukhari"
            },

            {
                text: "Your education is a dress rehearsal for a life that is yours to lead.",
                author: "Nora Ephron"
            }
        ];
        
        function rotateQuote() {
            const quoteBox = document.querySelector('.bg-white\\/10 p');
            const authorBox = document.querySelector('.bg-white\\/10 p + p');
            const randomQuote = quotes[Math.floor(Math.random() * quotes.length)];
            
            quoteBox.textContent = `"${randomQuote.text}"`;
            authorBox.textContent = `- ${randomQuote.author}`;
        }
        
        // Rotate every 10 seconds
        setInterval(rotateQuote, 10000);
    </script>
</body>
</html>