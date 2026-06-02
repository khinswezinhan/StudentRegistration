<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <style>
            .my-dashboard-wrapper { 
                display: flex; 
                min-height: 100vh; 
                align-items: stretch;
            }
            
            .my-sidebar { 
                width: 260px; 
                background-color: rgb(93, 79, 112) !important; 
                padding-top: 20px; 
                flex-shrink: 0;
                display: flex;
                flex-direction: column;
            }
            
            .my-content-area { 
                flex-grow: 1; 
                background-color: #f1f3f6; 
                display: flex;
                flex-direction: column;
            }
            
            .nav-link-custom { 
                display: flex; 
                align-items: center; 
                justify-content: space-between; 
                padding: 12px 25px; 
                color: rgba(255, 255, 255, 0.8); 
                text-decoration: none; 
                transition: all 0.2s ease;
            }
            
            .nav-link-custom:hover, .nav-link-custom.active { 
                background-color: rgba(255, 255, 255, 0.1); 
                color: #ffffff; 
                border-left: 4px solid #ffffff; 
            }
        </style>
    </head>
    <body class="font-sans antialiased">
        
        <div class="my-dashboard-wrapper">

            <div class="my-sidebar">
                <div class="list-group list-group-flush bg-transparent">
                    
                    <a href="{{ route('dashboard') }}" class="nav-link-custom {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                        <div><i class="fa-solid fa-gauge me-2"></i> Dashboard</div>
                    </a>
                    
                    <a href="{{ route('student') }}" class="nav-link-custom {{ request()->routeIs('student') ? 'active' : '' }}">
                        <div><i class="fa-solid fas fa-book-reader me-2"></i> Student List</div>
                    </a>
                    
                    <a href="{{ route('teacher') }}" class="nav-link-custom {{ request()->routeIs('teacher') ? 'active' : '' }}">
                        <div><i class="fa-solid fas fa-chalkboard-teacher me-2"></i> Teacher List</div>
                    </a>
                    
                    <a href="{{ route('course') }}" class="nav-link-custom {{ request()->routeIs('course') ? 'active' : '' }}">
                        <div><i class="fa-solid fa-circle-check me-2"></i> Course</div>
                    </a>

                    <a href="{{ route('course') }}" class="nav-link-custom {{ request()->routeIs('course') ? 'active' : '' }}">
                        <div><i class="fa-solid fa-circle-check me-2"></i> User List</div>
                    </a>

                </div>
            </div>

            <div class="my-content-area">
                
                @include('layouts.navigation') 

                @isset($header)
                    <header class="bg-white shadow-sm">
                        <div class="max-w-7xl mx-auto py-4 px-4 sm:px-6 lg:px-8">
                            {{ $header }}
                        </div>
                    </header>
                @endisset

                <main class="p-4 flex-grow-1">
                    {{ $slot }}
                </main>

            </div>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    </body>
</html>