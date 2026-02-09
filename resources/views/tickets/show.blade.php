<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                    Support Ticket
                </h2>
                <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">
                    #{{ $ticket->id }} • {{ $ticket->title }}
                </p>
            </div>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="mx-auto max-w-6xl px-4 sm:px-6 lg:px-8">
            <!-- Success/Error Messages -->
            @if(session('success'))
                <div class="mb-6 rounded-lg border border-green-200 bg-green-50 p-4">
                    <div class="flex items-center">
                        <svg class="h-5 w-5 text-green-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <p class="text-green-800">{{ session('success') }}</p>
                    </div>
                </div>
            @endif

            @if(session('error'))
                <div class="mb-6 rounded-lg border border-red-200 bg-red-50 p-4">
                    <div class="flex items-center">
                        <svg class="h-5 w-5 text-red-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <p class="text-red-800">{{ session('error') }}</p>
                    </div>
                </div>
            @endif

            <!-- Ticket Info Card -->
            <div class="mb-6 overflow-hidden rounded-lg border border-gray-200 bg-white shadow-sm">
                <div class="border-b border-gray-100 bg-white px-6 py-4">
                    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                        <div class="space-y-1">
                            <h1 class="text-2xl font-semibold text-gray-900">
                                {{ $ticket->title }}
                            </h1>
                            <div class="flex items-center gap-2 text-sm text-gray-600">
                                <span>Ticket #{{ $ticket->id }}</span>
                                <span class="text-gray-400">•</span>
                                <span>Created {{ $ticket->created_at->diffForHumans() }}</span>
                            </div>
                        </div>
                        
                        <div class="flex flex-wrap gap-2">
                            <span class="inline-flex items-center rounded-md px-3 py-1.5 text-sm font-medium
                                @if($ticket->status === 'open') bg-blue-100 text-blue-800
                                @elseif($ticket->status === 'in_progress') bg-amber-100 text-amber-800
                                @else bg-gray-100 text-gray-800 @endif">
                                {{ str_replace('_', ' ', ucfirst($ticket->status)) }}
                            </span>
                            <span class="inline-flex items-center rounded-md px-3 py-1.5 text-sm font-medium
                                @if($ticket->priority === 'high') bg-red-100 text-red-800
                                @elseif($ticket->priority === 'medium') bg-yellow-100 text-yellow-800
                                @else bg-gray-100 text-gray-800 @endif">
                                {{ ucfirst($ticket->priority) }} Priority
                            </span>
                        </div>
                    </div>
                </div>

                <div class="px-6 py-6">
                    <!-- Description Section -->
                    <div class="mb-8">
                        <h3 class="mb-3 text-sm font-medium uppercase tracking-wide text-gray-500">
                            Description
                        </h3>
                        <div class="rounded-md border border-gray-200 bg-gray-50 p-4">
                            <p class="whitespace-pre-line text-gray-700">
                                {{ $ticket->description }}
                            </p>
                        </div>
                    </div>

                    <!-- Original Attachment -->
                    @if($ticket->attachment)
                        <div class="mb-8">
                            <h3 class="mb-3 text-sm font-medium uppercase tracking-wide text-gray-500">
                                Original Attachment
                            </h3>
                            <a href="{{ Storage::url($ticket->attachment) }}"
                               target="_blank"
                               class="inline-flex items-center gap-2 rounded-lg border border-gray-200 bg-white px-4 py-3 hover:bg-gray-50">
                                <svg class="h-5 w-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"></path>
                                </svg>
                                <span class="text-sm font-medium text-gray-700">
                                    View Original Attachment
                                </span>
                            </a>
                        </div>
                    @endif

                    <!-- Assigned Admin -->
                    @if($ticket->assignedAdmin)
                        <div class="mb-8">
                            <h3 class="mb-3 text-sm font-medium uppercase tracking-wide text-gray-500">
                                Assigned To
                            </h3>
                            <div class="inline-flex items-center gap-3 rounded-lg border border-gray-200 bg-white px-4 py-3">
                                <div class="h-8 w-8 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 font-medium">
                                    {{ substr($ticket->assignedAdmin->name, 0, 1) }}
                                </div>
                                <span class="font-medium text-gray-700">
                                    {{ $ticket->assignedAdmin->name }}
                                </span>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Conversation Section -->
            <div class="grid gap-6 lg:grid-cols-3">
                <!-- Messages -->
                <div class="lg:col-span-2">
                    <div class="mb-4 flex items-center justify-between">
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900">
                                Conversation
                            </h3>
                            <p class="text-sm text-gray-600">
                                Updates automatically
                            </p>
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="h-2 w-2 rounded-full bg-green-500 animate-pulse"></span>
                            <span class="text-xs font-medium text-green-700">
                                Live
                            </span>
                        </div>
                    </div>

                    <div id="ticket-replies" 
                         class="space-y-4 rounded-lg border border-gray-200 bg-white p-4"
                         style="max-height: 500px; overflow-y: auto;">
                        @include('tickets.partials.replies', ['ticket' => $ticket])
                    </div>
                </div>

                <!-- Reply Form -->
                <div>
                    <div class="rounded-lg border border-gray-200 bg-white p-5">
                        <h4 class="mb-4 text-lg font-semibold text-gray-900">
                            Send Reply
                        </h4>
                        <form id="ticket-reply-form" method="POST" action="{{ route('tickets.replies.store', $ticket) }}" enctype="multipart/form-data" class="space-y-4">
                            @csrf
                            <div>
                                <label class="mb-2 block text-sm font-medium text-gray-700">
                                    Message
                                </label>
                                <textarea name="message"
                                          rows="4"
                                          required
                                          class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm focus:border-blue-500 focus:ring-blue-500"
                                          placeholder="Type your reply...">{{ old('message') }}</textarea>
                                @error('message')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label class="mb-2 block text-sm font-medium text-gray-700">
                                    Attachment (optional)
                                </label>
                                <input type="file" 
                                       name="attachment" 
                                       class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm file:mr-4 file:rounded-md file:border-0 file:bg-gray-100 file:px-4 file:py-2 file:text-sm file:font-medium file:text-gray-700 hover:file:bg-gray-200"
                                       accept="image/*,.pdf,.doc,.docx,.txt">
                                @error('attachment')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            <button type="submit" 
                                    id="ticket-reply-send"
                                    class="flex w-full items-center justify-center gap-2 rounded-md bg-blue-600 px-5 py-3 text-base font-semibold text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                                </svg>
                                Send Message
                            </button>
                            <input type="submit" value="Send" id="ticket-reply-send-fallback" class="w-full rounded-md border border-gray-300 bg-white px-5 py-3 text-base font-semibold text-gray-700 hover:bg-gray-50">
                        </form>
                    </div>

                    <!-- Actions -->
                    <div class="mt-4 space-y-3">
                        @if($ticket->status !== 'closed')
                            <a href="{{ route('tickets.edit', $ticket) }}" 
                               class="flex w-full items-center justify-center gap-2 rounded-md border border-gray-300 bg-white px-5 py-3 text-base font-semibold text-gray-700 hover:bg-gray-50">
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                </svg>
                                Edit Ticket
                            </a>
                        @endif
                        
                        <a href="{{ route('tickets.index') }}" 
                           class="flex w-full items-center justify-center gap-2 rounded-md border border-gray-300 bg-white px-5 py-3 text-base font-semibold text-gray-700 hover:bg-gray-50">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                            </svg>
                            Back to Tickets
                        </a>
                        
                        @if(Auth::user()->is_admin ?? false)
                            <a href="/admin/tickets/{{ $ticket->id }}/edit" 
                               class="flex w-full items-center justify-center gap-2 rounded-md border border-gray-300 bg-white px-5 py-3 text-base font-semibold text-gray-700 hover:bg-gray-50">
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2"></path>
                                </svg>
                                Admin View
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Lightbox for images -->
    <div id="image-lightbox" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/90 p-4">
        <button type="button" 
                class="absolute right-4 top-4 rounded-full bg-white/10 p-2 text-white hover:bg-white/20"
                onclick="closeLightbox()">
            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
        </button>
        <img id="image-lightbox-img" class="max-h-[85vh] max-w-full rounded object-contain" alt="Preview">
    </div>

    <script>
        // Auto-refresh conversation
        function refreshConversation() {
            const container = document.getElementById('ticket-replies');
            if (!container) return;

            fetch(@json(route('tickets.replies.poll', $ticket)), {
                headers: { 'X-Requested-With': 'XMLHttpRequest' },
            })
            .then(res => res.ok ? res.text() : null)
            .then(html => {
                if (html) {
                    container.innerHTML = html;
                    container.scrollTop = container.scrollHeight;
                    attachLightboxListeners();
                }
            })
            .catch(() => {});
        }

        // Lightbox functionality
        function openLightbox(src) {
            const lightbox = document.getElementById('image-lightbox');
            const lightboxImg = document.getElementById('image-lightbox-img');
            lightboxImg.src = src;
            lightbox.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }

        function closeLightbox() {
            const lightbox = document.getElementById('image-lightbox');
            lightbox.classList.add('hidden');
            document.body.style.overflow = 'auto';
        }

        function attachLightboxListeners() {
            document.querySelectorAll('[data-lightbox-src]').forEach(button => {
                button.addEventListener('click', () => {
                    openLightbox(button.dataset.lightboxSrc);
                });
            });
        }

        // Initial setup
        document.addEventListener('DOMContentLoaded', () => {
            // Start auto-refresh
            setInterval(refreshConversation, 5000);
            
            // Attach initial lightbox listeners
            attachLightboxListeners();
            
            // Close lightbox on ESC
            document.addEventListener('keydown', (e) => {
                if (e.key === 'Escape') closeLightbox();
            });
            
            // Close lightbox on background click
            document.getElementById('image-lightbox')?.addEventListener('click', (e) => {
                if (e.target.id === 'image-lightbox') closeLightbox();
            });
            
            // Prevent double-submit on slow reload
            const replyForm = document.getElementById('ticket-reply-form');
            if (replyForm) {
                replyForm.addEventListener('submit', () => {
                    replyForm.querySelectorAll('button[type="submit"], input[type="submit"]').forEach((btn) => {
                        btn.setAttribute('disabled', 'disabled');
                        if (btn.tagName === 'BUTTON') btn.textContent = 'Sending...';
                        if (btn.tagName === 'INPUT') btn.value = 'Sending...';
                    });
                });
            }

            // Auto-scroll to bottom
            const container = document.getElementById('ticket-replies');
            if (container) {
                container.scrollTop = container.scrollHeight;
            }
        });
    </script>

    <style>
        /* Custom scrollbar */
        #ticket-replies {
            scrollbar-width: thin;
            scrollbar-color: #d1d5db transparent;
        }
        
        #ticket-replies::-webkit-scrollbar {
            width: 6px;
        }
        
        #ticket-replies::-webkit-scrollbar-track {
            background: #f9fafb;
        }
        
        #ticket-replies::-webkit-scrollbar-thumb {
            background-color: #d1d5db;
            border-radius: 3px;
        }
        
        #ticket-replies::-webkit-scrollbar-thumb:hover {
            background-color: #9ca3af;
        }
    </style>
</x-app-layout>
