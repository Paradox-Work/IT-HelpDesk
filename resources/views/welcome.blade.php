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
                    <a href="/knowledge-base" class="inline-flex justify-center items-center px-6 py-3 bg-white border border-gray-300 rounded-md font-semibold text-gray-700 uppercase tracking-widest hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition">
                        Browse Solutions
                    </a>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <!-- Quick Stats -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-12">
                <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200 text-center">
                    <div class="text-3xl font-bold text-blue-600 mb-2">24/7</div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Support Available</h3>
                    <p class="text-gray-600">Round-the-clock technical assistance</p>
                </div>
                
                <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200 text-center">
                    <div class="text-3xl font-bold text-green-600 mb-2">≤ 4h</div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Average Response Time</h3>
                    <p class="text-gray-600">Quick resolution for urgent issues</p>
                </div>
                
                <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200 text-center">
                    <div class="text-3xl font-bold text-purple-600 mb-2">95%</div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Satisfaction Rate</h3>
                    <p class="text-gray-600">Happy users and resolved tickets</p>
                </div>
            </div>

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

            <!-- Common Issues -->
            <div class="bg-gray-50 rounded-xl p-8 mb-12">
                <h2 class="text-3xl font-bold text-gray-900 text-center mb-8">Common Issues</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="bg-white p-6 rounded-lg shadow-sm">
                        <div class="flex items-center mb-4">
                            <div class="w-10 h-10 bg-red-100 rounded-full flex items-center justify-center mr-4">
                                <svg class="w-5 h-5 text-red-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                                </svg>
                            </div>
                            <h3 class="text-lg font-semibold text-gray-900">System Access</h3>
                        </div>
                        <p class="text-gray-600">Password resets, account lockouts, and permission issues.</p>
                    </div>
                    
                    <div class="bg-white p-6 rounded-lg shadow-sm">
                        <div class="flex items-center mb-4">
                            <div class="w-10 h-10 bg-yellow-100 rounded-full flex items-center justify-center mr-4">
                                <svg class="w-5 h-5 text-yellow-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M2.166 4.999A11.954 11.954 0 0010 1.944 11.954 11.954 0 0017.834 5c.11.65.166 1.32.166 2.001 0 5.225-3.34 9.67-8 11.317C5.34 16.67 2 12.225 2 7c0-.682.057-1.35.166-2.001zm11.541 3.708a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                </svg>
                            </div>
                            <h3 class="text-lg font-semibold text-gray-900">Software Issues</h3>
                        </div>
                        <p class="text-gray-600">Application crashes, installation problems, and updates.</p>
                    </div>
                </div>
            </div>

            <!-- CTA Section -->
            <div class="text-center bg-gradient-to-r from-blue-600 to-indigo-600 rounded-xl p-8 text-white">
                <h2 class="text-3xl font-bold mb-4">Need Immediate Assistance?</h2>
                <p class="text-xl mb-6 max-w-2xl mx-auto">Our support team is ready to help you resolve any technical issues.</p>
                <a href="tel:+15551234567" class="inline-flex items-center px-6 py-3 bg-white text-blue-600 rounded-md font-semibold hover:bg-gray-100 transition">
                    <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z"/>
                    </svg>
                    Call Support: (555) 123-4567
                </a>
            </div>
        </div>

        <!-- Footer -->
        <footer class="bg-gray-800 text-white py-8">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                    <div>
                        <h3 class="text-lg font-semibold mb-4">IT Support Desk</h3>
                        <p class="text-gray-400">Providing technical support solutions for your business needs.</p>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold mb-4">Quick Links</h3>
                        <ul class="space-y-2">
                            <li><a href="/tickets" class="text-gray-400 hover:text-white">My Tickets</a></li>
                            <li><a href="/knowledge-base" class="text-gray-400 hover:text-white">Knowledge Base</a></li>
                            <li><a href="/status" class="text-gray-400 hover:text-white">System Status</a></li>
                        </ul>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold mb-4">Contact</h3>
                        <ul class="space-y-2 text-gray-400">
                            <li>support@example.com</li>
                            <li>(555) 123-4567</li>
                            <li>Mon-Fri: 8AM-6PM</li>
                        </ul>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold mb-4">Emergency</h3>
                        <p class="text-gray-400">For critical system outages, use the emergency hotline.</p>
                        <a href="tel:+15551119999" class="inline-block mt-2 text-red-400 hover:text-red-300">
                            Emergency: (555) 111-9999
                        </a>
                    </div>
                </div>
                <div class="border-t border-gray-700 mt-8 pt-8 text-center text-gray-400">
                    <p>&copy; {{ date('Y') }} IT Support Desk. All rights reserved.</p>
                </div>
            </div>
        </footer>
    </body>
</html>