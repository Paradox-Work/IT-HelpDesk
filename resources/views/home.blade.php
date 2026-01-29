<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            IT Help Desk
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h1 class="text-3xl font-bold mb-4">IT Help Desk</h1>
                    <p class="mb-6">Submit and track IT support tickets.</p>
                    
                    @auth
                        <p>Welcome back! Go to your <a href="{{ route('dashboard') }}" class="text-blue-600 hover:underline">dashboard</a> to manage tickets.</p>
                    @else
                        <div class="space-x-4">
                            <a href="{{ route('login') }}" class="bg-blue-600 text-white px-6 py-3 rounded-md hover:bg-blue-700">
                                Login
                            </a>
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="bg-green-600 text-white px-6 py-3 rounded-md hover:bg-green-700">
                                    Register
                                </a>
                            @endif
                        </div>
                    @endauth
                </div>
            </div>
        </div>
    </div>
</x-app-layout>