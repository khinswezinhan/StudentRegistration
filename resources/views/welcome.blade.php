<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />

        @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
            @vite(['resources/css/app.css', 'resources/js/app.js'])
        @else
            <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
        @endif

        <style>
            body {
                font-family: 'Instrument Sans', sans-serif;
                background-image: url('/image/welcome.jpg') !important; 
                background-size: cover !important;
                background-position: center !important;
                background-repeat: no-repeat !important;
                background-attachment: fixed !important;
            }

            .bg-overlay {
                background-color: rgba(0, 0, 0, 0.45);
            }
            
            .btn-purple-md {
                color: #1b1b18 !important;
                background-color: rgb(225, 215, 240) !important;
                border: 1px solid rgb(225, 215, 240) !important;
                font-size: 0.95rem !important;
                font-weight: 600 !important;
                padding: 0.6rem 1.4rem !important;
                border-radius: 6px !important;
                transition: all 0.2s ease-in-out;
                display: inline-flex;
                align-items: center;
                justify-content: center;
                text-decoration: none !important;
                white-space: nowrap;
            }
            .btn-purple-md:hover {
                background-color: rgb(240, 235, 250) !important;
                border-color: rgb(240, 235, 250) !important;
                box-shadow: 0 4px 15px rgba(255, 255, 255, 0.2);
            }

            .btn-purple-outline-md {
                color: #ffffff !important;
                border: 1px solid rgba(255, 255, 255, 0.8) !important;
                background-color: rgba(255, 255, 255, 0.15) !important;
                font-size: 0.95rem !important;
                font-weight: 600 !important;
                padding: 0.6rem 1.4rem !important;
                border-radius: 6px !important;
                transition: all 0.2s ease-in-out;
                display: inline-flex;
                align-items: center;
                justify-content: center;
                text-decoration: none !important;
                white-space: nowrap;
                backdrop-filter: blur(4px);
            }
            .btn-purple-outline-md:hover {
                background-color: rgba(255, 255, 255, 0.25) !important;
                border-color: #ffffff !important;
            }

            .btn-header-register {
                color: #ffffff !important;
                border: 1.5px solid rgba(255, 255, 255, 0.8) !important;
                background-color: rgba(255, 255, 255, 0.18) !important;
                font-size: 0.95rem !important;
                font-weight: 600 !important;
                padding: 0.6rem 1.4rem !important;
                border-radius: 12px !important; 
                margin-left: 1.5rem !important; 
                transition: all 0.2s ease-in-out;
                display: inline-flex;
                align-items: center;
                justify-content: center;
                text-decoration: none !important;
                backdrop-filter: blur(4px);
            }
            .btn-header-register:hover {
                background-color: rgba(255, 255, 255, 0.28) !important;
                border-color: #ffffff !important;
            }

            h1.text-welcome {
                margin-bottom: 4rem !important; 
            }
        </style>
    </head>
    <body class="text-white flex min-h-screen flex-col justify-between p-6 bg-overlay">
        
        <header class="w-full flex justify-end py-2 z-10">
            @if (Route::has('login'))
                <nav class="flex flex-row items-center justify-end">
                    @auth
                        <a href="{{ url('/dashboard') }}" class="px-4 py-1.5 rounded-md text-sm font-medium btn-purple-outline-md">
                            Dashboard
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="text-white hover:text-gray-200 text-sm font-semibold tracking-wide transition-colors text-decoration-none" style="display: inline-block;">
                            Log in
                        </a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="btn-header-register">
                                Register
                            </a>
                        @endif
                    @endauth
                </nav>
            @endif
        </header>

        <main class="w-full max-w-2xl mx-auto text-center flex flex-col items-center justify-center my-auto py-8 z-10">
            
            <div class="mb-6 flex justify-center">
                <svg class="h-14 w-14 text-white opacity-95" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4.26 10.147a60.438 60.438 0 0 0-.491 6.347A48.62 48.62 0 0 1 12 20.904a48.62 48.62 0 0 1 8.232-4.41 60.46 60.46 0 0 0-.491-6.347m-15.482 0a50.636 50.636 0 0 0-2.658-.813A5.906 5.906 0 0 1 12 3.453a5.906 5.906 0 0 1 7.715 5.881c-.88.243-1.766.513-2.658.813m-15.482 0A50.71 50.71 0 0 1 12 13.489a50.702 50.702 0 0 1 7.74-3.342M12 13.49v6.287" />
                </svg>
            </div>

            <h1 class="text-3xl sm:text-4xl font-bold tracking-tight text-white text-welcome px-2 drop-shadow-lg">
                Welcome to Student Management System
            </h1>

            <div class="flex flex-row gap-4 justify-center items-center w-full px-4">
                @auth
                    <a href="{{ url('/dashboard') }}" class="btn-purple-md">
                        Go to Dashboard
                    </a>
                @else
                    <a href="{{ route('login') }}" class="btn-purple-md">
                        Get Started
                    </a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="btn-purple-outline-md">
                            Create Account
                        </a>
                    @endif
                @endauth
            </div>
        </main>

        <footer class="w-full text-center py-4 text-xs text-gray-300 z-10">
            &copy; 2026 Laravel. All rights reserved.
        </footer>

    </body>
</html>