<x-filament::page>
    @php
        $ticket = $record;
    @endphp

    <div class="mx-auto w-full max-w-6xl space-y-8">
        {{-- Ticket Header --}}
        <div class="flex flex-col gap-4 sm:flex-row sm:items-start sm:justify-between">
            <div class="space-y-1">
                <h2 class="text-xl font-semibold tracking-tight text-gray-950 dark:text-white">
                    Ticket #{{ $ticket->id }} — {{ $ticket->title }}
                </h2>
                <p class="text-sm text-gray-500 dark:text-gray-400">
                    Created {{ $ticket->created_at->diffForHumans() }}
                </p>
            </div>
            <div class="flex flex-wrap items-center gap-2">
                <x-filament::badge 
                    :color="match($ticket->status) {
                        'open' => 'success',
                        'in_progress' => 'warning',
                        default => 'gray'
                    }"
                    size="sm"
                    class="rounded-full px-3 py-1 text-xs font-semibold"
                >
                    {{ str_replace('_', ' ', ucfirst($ticket->status)) }}
                </x-filament::badge>
                
                <x-filament::badge 
                    :color="match($ticket->priority) {
                        'high' => 'danger',
                        'medium' => 'warning',
                        default => 'gray'
                    }"
                    size="sm"
                    class="rounded-full px-3 py-1 text-xs font-semibold"
                >
                    {{ ucfirst($ticket->priority) }}
                </x-filament::badge>
            </div>
        </div>

        {{-- Description Section --}}
        <x-filament::section>
            <x-slot name="heading">
                <h3 class="text-base font-semibold leading-6 text-gray-950 dark:text-white">
                    Description
                </h3>
            </x-slot>
            
            <div class="prose prose-sm max-w-none dark:prose-invert">
                <p class="whitespace-pre-line text-gray-700 dark:text-gray-300">
                    {{ $ticket->description }}
                </p>
            </div>
        </x-filament::section>

        {{-- Original Attachment --}}
        @if($ticket->attachment)
        <x-filament::section>
            <x-slot name="heading">
                <h3 class="text-base font-semibold leading-6 text-gray-950 dark:text-white">
                    Ticket Attachment
                </h3>
            </x-slot>
            
            <div class="flex items-center gap-2">
                <x-filament::icon-button 
                    icon="heroicon-o-paper-clip"
                    color="gray"
                    size="sm"
                />
                <a href="{{ Storage::url($ticket->attachment) }}"
                   target="_blank"
                   class="text-sm font-medium text-primary-600 hover:text-primary-500 dark:text-primary-400 dark:hover:text-primary-300">
                    View Attachment
                </a>
            </div>
        </x-filament::section>
        @endif

        {{-- Conversation Section --}}
        <x-filament::section>
            <x-slot name="heading">
                <div class="flex items-center justify-between">
                    <h3 class="text-base font-semibold leading-6 text-gray-950 dark:text-white">
                        Conversation
                    </h3>
                    <span class="text-xs font-medium text-gray-500 dark:text-gray-400">
                        Updates automatically
                    </span>
                </div>
            </x-slot>

            <div id="ticket-replies" 
                 class="space-y-6 rounded-xl border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-700 dark:bg-gray-900"
                 style="max-height: 520px; overflow-y: auto;">
                @include('tickets.partials.replies', ['ticket' => $ticket, 'isFilament' => true])
            </div>
        </x-filament::section>

        {{-- Reply Form --}}
        <x-filament::section>
            <x-slot name="heading">
                <h3 class="text-base font-semibold leading-6 text-gray-950 dark:text-white">
                    Send a message
                </h3>
            </x-slot>

            <form wire:submit.prevent="sendMessage" class="space-y-4">
                {{-- Message Input --}}
                <div>
                    <x-filament::input.wrapper>
                        <x-filament::input 
                            type="textarea"
                            wire:model.defer="message"
                            rows="4"
                            required
                            placeholder="Type your message here..."
                            class="resize-none"
                        />
                    </x-filament::input.wrapper>
                    @error('message') 
                        <p class="mt-1 text-sm text-danger-600">{{ $message }}</p> 
                    @enderror
                </div>

                {{-- Attachment --}}
                <div>
                    <label class="mb-1 block text-sm font-medium text-gray-700 dark:text-gray-300">
                        Attachment (optional)
                    </label>
                    <x-filament::input.wrapper>
                        <div class="flex items-center gap-2">
                            <input 
                                type="file" 
                                wire:model="attachment" 
                                class="flex-1 text-sm text-gray-900 file:mr-2 file:rounded-lg file:border-0 file:bg-gray-100 file:px-3 file:py-2 file:text-sm file:font-medium file:text-gray-700 hover:file:bg-gray-200 dark:text-gray-100 dark:file:bg-gray-800 dark:file:text-gray-300 dark:hover:file:bg-gray-700"
                            />
                            <x-filament::icon-button 
                                icon="heroicon-o-paper-clip"
                                color="gray"
                                size="sm"
                                type="button"
                                onclick="document.querySelector('input[type=file]').click()"
                            />
                        </div>
                    </x-filament::input.wrapper>
                    @error('attachment') 
                        <p class="mt-1 text-sm text-danger-600">{{ $message }}</p> 
                    @enderror
                </div>

                {{-- Submit Button --}}
                <div class="flex justify-end pt-2">
                    <x-filament::button 
                        type="submit" 
                        color="primary"
                        size="sm"
                        icon="heroicon-m-paper-airplane"
                        icon-position="after"
                    >
                        Send Message
                    </x-filament::button>
                </div>
            </form>
        </x-filament::section>
    </div>

    {{-- Live updates for conversation --}}
    @push('scripts')
    <script>
        // Auto-scroll to bottom of conversation
        function scrollToBottom() {
            const container = document.getElementById('ticket-replies');
            if (container) {
                container.scrollTop = container.scrollHeight;
            }
        }
        
        // Initial scroll
        document.addEventListener('DOMContentLoaded', scrollToBottom);
        
        // Livewire event listener for new messages
        Livewire.on('messageSent', () => {
            setTimeout(scrollToBottom, 100);
        });
    </script>
    @endpush
</x-filament::page>
