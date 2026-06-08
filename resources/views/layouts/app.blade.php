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
            .my-main-layout {
                display: flex;
                flex-direction: column;
                height: 100vh; 
                overflow: hidden;
            }

            .my-sticky-navbar {
                position: sticky;
                top: 0;
                z-index: 1020;
                width: 100%;
                flex-shrink: 0; 
            }

            .my-dashboard-body { 
                display: flex; 
                flex-grow: 1;
                align-items: stretch;
                overflow: hidden; 
            }
            
            .my-sidebar { 
                width: 250px; 
                background-color: rgb(93, 79, 112) !important; 
                padding-top: 10px;
                flex-shrink: 0;
                display: flex;
                flex-direction: column;
                overflow-y: auto; 
            }
            
            .my-content-area { 
                flex-grow: 1; 
                background-color: #f1f3f6; 
                display: flex;
                flex-direction: column;
                overflow-y: auto; 
                height: 100%;
            }
            
            .nav-link-custom { 
                display: flex; 
                align-items: center; 
                padding: 14px 24px !important; 
                color: rgba(255, 255, 255, 0.85) !important; 
                text-decoration: none !important; 
                font-size: 15px;
                font-weight: 500;
                transition: all 0.2s ease;
                border-left: 4px solid transparent;
            }
            
            .nav-link-custom:hover, .nav-link-custom.active { 
                background-color: rgba(255, 255, 255, 0.1) !important; 
                color: #ffffff !important; 
                border-left: 4px solid #ffffff !important; 
            }

            .nav-link-custom i {
                width: 24px;
                font-size: 16px;
                text-align: center;
            }
        </style>
    </head>
    <body class="font-sans antialiased">
        
        <div class="my-main-layout">

            <div class="my-sticky-navbar shadow-sm">
                @include('layouts.navigation') 
            </div>

            <div class="my-dashboard-body">

                {{-- Sidebar Area --}}
                <div class="my-sidebar">
                    <div class="list-group list-group-flush bg-transparent">
                        
                        {{-- Student List --}}
                        <a href="{{ route('student') }}" class="nav-link-custom {{ request()->routeIs('student') ? 'active' : '' }}">
                            <i class="fa-solid fas fa-book-reader me-2"></i>
                            <span>Student List</span>
                        </a>
                        
                        {{-- Teacher List --}}
                        <a href="{{ route('teacher') }}" class="nav-link-custom {{ request()->routeIs('teacher') ? 'active' : '' }}">
                            <i class="fa-solid fas fa-chalkboard-teacher me-2"></i>
                            <span>Teacher List</span>
                        </a>
                        
                        {{-- Course --}}
                        <a href="{{ route('course') }}" class="nav-link-custom {{ request()->routeIs('course') ? 'active' : '' }}">
                            <i class="fa-solid fa-circle-check me-2"></i>
                            <span>Course</span>
                        </a>

                        {{-- User List (Admin Only) --}}
                        @if(auth()->check() && auth()->user()->role_id == 1)
                            <a href="{{ route('user') }}" class="nav-link-custom {{ request()->routeIs('user') ? 'active' : '' }}">
                                <i class="fa-solid fa-users me-2"></i>
                                <span>User List</span>
                            </a>
                        @endif
                        
                    </div>
                </div>

                {{-- Main Content Area --}}
                <div class="my-content-area">
                    
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
        </div> 

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    </body>
</html>