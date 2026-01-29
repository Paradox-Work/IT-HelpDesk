<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'IT Help Desk') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-gray-900 antialiased">
        <!-- Navigation -->
        <nav class="bg-white shadow-sm">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex items-center">
                        <!-- Logo -->
                        <div class="shrink-0">
                            <a href="/" class="text-xl font-bold text-blue-600">
                                IT Support Desk
                            </a>
                        </div>
                        
                        <!-- Navigation Links -->
                        <div class="hidden sm:ml-6 sm:flex sm:space-x-8">
                            <a href="/" class="border-b-2 border-blue-600 text-gray-900 inline-flex items-center px-1 pt-1 text-sm font-medium">
                                Home
                            </a>
                            <a href="/tickets" class="border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 inline-flex items-center px-1 pt-1 text-sm font-medium">
                                My Tickets
                            </a>
                            <a href="/knowledge-base" class="border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 inline-flex items-center px-1 pt-1 text-sm font-medium">
                                Knowledge Base
                            </a>
                        </div>
                    </div>

                    <!-- Auth Links -->
                    <div class="hidden sm:flex sm:items-center">
                        @if (Route::has('login'))
                            @auth
                                <a href="{{ url('/dashboard') }}" class="text-sm text-gray-700 hover:text-gray-900">
                                    Dashboard
                                </a>
                            @else
                                <a href="{{ route('login') }}" class="text-sm text-gray-700 hover:text-gray-900">
                                    Log in
                                </a>
                                @if (Route::has('register'))
                                    <a href="{{ route('register') }}" class="ml-6 text-sm text-white bg-blue-600 hover:bg-blue-700 px-4 py-2 rounded-md">
                                        Register
                                    </a>
                                @endif
                            @endauth
                        @endif
                    </div>
                </div>
            </div>
        </nav>

        <!-- Hero Section -->
        <div class="bg-gradient-to-r from-blue-50 to-indigo-50 py-16">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
                <h1 class="text-4xl md:text-5xl font-bold text-gray-900 mb-4">
                    IT Support & Help Desk System
                </h1>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto mb-8">
                    Streamline your technical support requests, track issues, and get solutions faster with our help desk platform.
                </p>
                <div class="flex flex-col sm:flex-row justify-center gap-4">
                    <a href="{{ route('login') }}" class="inline-flex justify-center items-center px-6 py-3 bg-blue-600 border border-transparent rounded-md font-semibold text-white uppercase tracking-widest hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition">
                        Submit a Ticket
                    </a>
                </div>
            </div>
        </div>
        
        <br>
        
            <!-- How It Works -->
            <div class="mb-12">
                <h2 class="text-3xl font-bold text-gray-900 text-center mb-8">How It Works</h2>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <div class="text-center">
                        <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <span class="text-2xl font-bold text-blue-600">1</span>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-900 mb-3">Submit Ticket</h3>
                        <p class="text-gray-600">Describe your issue and attach any relevant files or screenshots.</p>
                    </div>
                    
                    <div class="text-center">
                        <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <span class="text-2xl font-bold text-blue-600">2</span>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-900 mb-3">Track Progress</h3>
                        <p class="text-gray-600">Monitor your ticket status and communicate with support agents.</p>
                    </div>
                    
                    <div class="text-center">
                        <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <span class="text-2xl font-bold text-blue-600">3</span>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-900 mb-3">Get Solution</h3>
                        <p class="text-gray-600">Receive solutions, workarounds, or scheduled fixes.</p>
                    </div>
                </div>
            </div>

        <!-- Footer -->
        <footer class="bg-gray-800 text-white py-8">       
                <div class="border-t border-gray-700 mt-8 pt-8 text-center text-gray-400">
                    <p>&copy; {{ date('Y') }} IT Support Desk. All rights reserved.</p>
                </div>
            </div>
        </footer>
    </body>
</html>