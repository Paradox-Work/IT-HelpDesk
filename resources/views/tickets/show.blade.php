<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Ticket #{{ $ticket->id }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    @if(session('success'))
                        <div class="mb-4 p-4 bg-green-100 text-green-700 rounded-md">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="mb-4 p-4 bg-red-100 text-red-700 rounded-md">
                            {{ session('error') }}
                        </div>
                    @endif

                    <!-- Ticket Header -->
                    <div class="flex justify-between items-start mb-6">
                        <div>
                            <h2 class="text-2xl font-bold text-gray-800">{{ $ticket->title }}</h2>
                            <p class="text-sm text-gray-500 mt-1">
                                Ticket #{{ $ticket->id }} • Created {{ $ticket->created_at->diffForHumans() }}
                            </p>
                        </div>
                        <div class="flex space-x-2">
                            <span class="px-3 py-1 text-sm font-semibold rounded-full 
                                @if($ticket->status === 'open') bg-green-100 text-green-800
                                @elseif($ticket->status === 'in_progress') bg-yellow-100 text-yellow-800
                                @else bg-gray-100 text-gray-800 @endif">
                                {{ str_replace('_', ' ', ucfirst($ticket->status)) }}
                            </span>
                            <span class="px-3 py-1 text-sm font-semibold rounded-full 
                                @if($ticket->priority === 'high') bg-red-100 text-red-800
                                @elseif($ticket->priority === 'medium') bg-yellow-100 text-yellow-800
                                @else bg-gray-100 text-gray-800 @endif">
                                {{ ucfirst($ticket->priority) }}
                            </span>
                        </div>
                    </div>

                    <!-- Ticket Description -->
                    <div class="mb-8 p-4 bg-gray-50 rounded-lg">
                        <h3 class="font-medium text-gray-700 mb-2">Description</h3>
                        <p class="text-gray-800 whitespace-pre-line">{{ $ticket->description }}</p>
                    </div>

                    <!-- Assigned Admin (if any) -->
                    @if($ticket->assignedAdmin)
                    <div class="mb-6">
                        <h3 class="font-medium text-gray-700 mb-2">Assigned To</h3>
                        <div class="flex items-center">
                            <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center mr-2">
                                <span class="text-blue-600 font-medium">{{ substr($ticket->assignedAdmin->name, 0, 1) }}</span>
                            </div>
                            <span>{{ $ticket->assignedAdmin->name }}</span>
                        </div>
                    </div>
                    @endif

                    <!-- Replies/Comments Section -->
                    <div class="mb-8">
                        <h3 class="font-medium text-gray-700 mb-4">Comments ({{ $ticket->replies->count() }})</h3>
                        
                        @if($ticket->replies->isEmpty())
                            <p class="text-gray-500 text-center py-4">No comments yet.</p>
                        @else
                            <div class="space-y-4">
                                @foreach($ticket->replies->sortBy('created_at') as $reply)
                                <div class="border-l-4 border-blue-500 pl-4 py-2">
                                    <div class="flex justify-between items-start mb-1">
                                        <span class="font-medium">{{ $reply->user->name }}</span>
                                        <span class="text-sm text-gray-500">{{ $reply->created_at->diffForHumans() }}</span>
                                    </div>
                                    <p class="text-gray-700">{{ $reply->message }}</p>
                                    @if($reply->attachment)
                                    <div class="mt-2">
                                        <a href="{{ Storage::url($reply->attachment) }}" 
                                           target="_blank"
                                           class="text-sm text-blue-600 hover:text-blue-800 flex items-center">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"></path>
                                            </svg>
                                            View Attachment
                                        </a>
                                    </div>
                                    @endif
                                </div>
                                @endforeach
                            </div>
                        @endif
                    </div>

                    <!-- Actions -->
                    <div class="flex justify-between items-center pt-6 border-t">
                        <a href="{{ route('tickets.index') }}" 
                           class="text-blue-600 hover:text-blue-800 font-medium">
                            ← Back to Tickets
                        </a>
                        
                        <div class="flex space-x-3">
                            @if($ticket->status !== 'closed')
                                <a href="{{ route('tickets.edit', $ticket) }}" 
                                   class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700">
                                    Edit Ticket
                                </a>
                            @endif
                            
                            @if(Auth::user()->is_admin ?? false)
                                <a href="/admin/tickets/{{ $ticket->id }}/edit" 
                                   class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                                    Admin View
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>