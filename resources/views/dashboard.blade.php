<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Welcome Card -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 text-gray-900">
                    <div class="flex justify-between items-center">
                        <div>
                            <h3 class="text-lg font-medium text-gray-900">
                                Welcome, {{ Auth::user()->name }}!
                            </h3>
                            <p class="mt-1 text-sm text-gray-600">
                                Manage your IT support tickets here.
                            </p>
                        </div>
                        @if(Auth::user()->is_admin ?? false)
                            <a href="/admin" 
                               class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                Admin Panel
                            </a>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <!-- Create Ticket Card -->
                <a href="{{ route('tickets.create') }}" 
                   class="bg-white overflow-hidden shadow-sm sm:rounded-lg hover:shadow-md transition-shadow">
                    <div class="p-6 border-l-4 border-green-500">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-green-100 rounded-lg p-3">
                                <svg class="h-6 w-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <h3 class="text-lg font-medium text-gray-900">Submit New Ticket</h3>
                                <p class="mt-1 text-sm text-gray-600">
                                    Report a new IT issue or request assistance
                                </p>
                            </div>
                        </div>
                    </div>
                </a>

                <!-- View Tickets Card -->
                <a href="{{ route('tickets.index') }}" 
                   class="bg-white overflow-hidden shadow-sm sm:rounded-lg hover:shadow-md transition-shadow">
                    <div class="p-6 border-l-4 border-blue-500">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-blue-100 rounded-lg p-3">
                                <svg class="h-6 w-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <h3 class="text-lg font-medium text-gray-900">View My Tickets</h3>
                                <p class="mt-1 text-sm text-gray-600">
                                    Check status of your existing tickets
                                </p>
                            </div>
                        </div>
                    </div>
                </a>
            </div>

            <!-- Recent Tickets (if any) -->
            @php
                $recentTickets = Auth::user()->tickets()->latest()->take(5)->get();
            @endphp
            
            @if($recentTickets->count() > 0)
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Recent Tickets</h3>
                    <div class="space-y-3">
                        @foreach($recentTickets as $ticket)
                        <a href="{{ route('tickets.show', $ticket) }}" 
                           class="block p-4 border border-gray-200 rounded-lg hover:bg-gray-50">
                            <div class="flex justify-between items-center">
                                <div>
                                    <h4 class="font-medium text-gray-900">{{ $ticket->title }}</h4>
                                    <p class="text-sm text-gray-600 mt-1">
                                        #{{ $ticket->id }} • {{ $ticket->created_at->diffForHumans() }}
                                    </p>
                                </div>
                                <div class="flex items-center space-x-2">
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full 
                                        @if($ticket->status === 'open') bg-green-100 text-green-800
                                        @elseif($ticket->status === 'in_progress') bg-yellow-100 text-yellow-800
                                        @else bg-gray-100 text-gray-800 @endif">
                                        {{ str_replace('_', ' ', ucfirst($ticket->status)) }}
                                    </span>
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full 
                                        @if($ticket->priority === 'high') bg-red-100 text-red-800
                                        @elseif($ticket->priority === 'medium') bg-yellow-100 text-yellow-800
                                        @else bg-gray-100 text-gray-800 @endif">
                                        {{ ucfirst($ticket->priority) }}
                                    </span>
                                </div>
                            </div>
                        </a>
                        @endforeach
                    </div>
                    @if(Auth::user()->tickets()->count() > 5)
                    <div class="mt-4 text-center">
                        <a href="{{ route('tickets.index') }}" 
                           class="text-blue-600 hover:text-blue-800 font-medium">
                            View All Tickets →
                        </a>
                    </div>
                    @endif
                </div>
            </div>
            @else
            <!-- No tickets yet -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-center">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-gray-900">No tickets yet</h3>
                    <p class="mt-1 text-sm text-gray-500">Get started by creating your first support ticket.</p>
                    <div class="mt-6">
                        <a href="{{ route('tickets.create') }}" 
                           class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            Create First Ticket
                        </a>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
</x-app-layout>