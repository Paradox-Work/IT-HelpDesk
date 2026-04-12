<x-filament::page>
    @php
        $ticket = $record;
        $deadlines = $ticket->deadlines->sortBy('start_at');
    @endphp

    <div class="mx-auto grid w-full max-w-7xl gap-6 xl:grid-cols-[minmax(0,2fr)_24rem]">
        <div class="space-y-6">
            <x-filament::section>
                <x-slot name="heading">
                    <div class="flex flex-col gap-3 sm:flex-row sm:items-start sm:justify-between">
                        <div class="space-y-1">
                            <h2 class="text-xl font-semibold text-gray-950 dark:text-white">
                                Ticket #{{ $ticket->id }}: {{ $ticket->title }}
                            </h2>
                            <p class="text-sm text-gray-500 dark:text-gray-400">
                                Submitted by {{ $ticket->user?->name ?? 'Unknown user' }} on {{ $ticket->created_at->format('M j, Y g:i A') }}
                            </p>
                        </div>

                        <div class="flex flex-wrap items-center gap-2">
                            <x-filament::badge :color="$ticket->status_color">
                                {{ $ticket->status_label }}
                            </x-filament::badge>

                            <x-filament::badge :color="$ticket->priority_color">
                                {{ $ticket->priority_label }}
                            </x-filament::badge>
                        </div>
                    </div>
                </x-slot>

                <div class="space-y-4">
                    <div class="grid gap-4 md:grid-cols-3">
                        <div class="rounded-2xl border border-gray-200 bg-gray-50 p-4 dark:border-white/10 dark:bg-white/5">
                            <p class="text-xs font-semibold uppercase tracking-[0.2em] text-gray-500 dark:text-gray-400">Assigned admin</p>
                            <p class="mt-2 text-sm font-medium text-gray-900 dark:text-white">
                                {{ $ticket->assignedAdmin?->name ?? 'Unassigned' }}
                            </p>
                        </div>

                        <div class="rounded-2xl border border-gray-200 bg-gray-50 p-4 dark:border-white/10 dark:bg-white/5">
                            <p class="text-xs font-semibold uppercase tracking-[0.2em] text-gray-500 dark:text-gray-400">Next deadline</p>
                            <p class="mt-2 text-sm font-medium text-gray-900 dark:text-white">
                                {{ $ticket->upcomingDeadline?->start_at?->format('M j, Y g:i A') ?? 'None scheduled' }}
                            </p>
                        </div>

                        <div class="rounded-2xl border border-gray-200 bg-gray-50 p-4 dark:border-white/10 dark:bg-white/5">
                            <p class="text-xs font-semibold uppercase tracking-[0.2em] text-gray-500 dark:text-gray-400">Replies</p>
                            <p class="mt-2 text-sm font-medium text-gray-900 dark:text-white">
                                {{ $ticket->replies->count() }} total messages
                            </p>
                        </div>
                    </div>

                    <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm dark:border-white/10 dark:bg-white/5">
                        <p class="text-xs font-semibold uppercase tracking-[0.2em] text-gray-500 dark:text-gray-400">Issue description</p>
                        <p class="mt-3 whitespace-pre-line text-sm leading-6 text-gray-700 dark:text-gray-300">{{ $ticket->description }}</p>

                        @if ($ticket->attachment)
                            <div class="mt-4">
                                <a href="{{ Storage::url($ticket->attachment) }}" target="_blank" class="text-sm font-medium text-primary-600 hover:underline">
                                    Open original attachment
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            </x-filament::section>

            <x-filament::section>
                <x-slot name="heading">
                    <div class="flex items-center justify-between gap-3">
                        <div>
                            <h3 class="text-base font-semibold text-gray-950 dark:text-white">Conversation</h3>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Recent customer and admin updates in one place.</p>
                        </div>
                    </div>
                </x-slot>

                <div id="ticket-replies" class="max-h-[36rem] overflow-y-auto rounded-2xl border border-gray-200 bg-white p-5 shadow-sm dark:border-white/10 dark:bg-white/5">
                    @include('tickets.partials.replies', ['ticket' => $ticket, 'isFilament' => true])
                </div>
            </x-filament::section>

            <x-filament::section>
                <x-slot name="heading">
                    <div>
                        <h3 class="text-base font-semibold text-gray-950 dark:text-white">Reply</h3>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Send a response without leaving the ticket.</p>
                    </div>
                </x-slot>

                <form wire:submit="sendMessage" class="space-y-4">
                    <div>
                        <label for="ticket-message" class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">Message</label>
                        <textarea
                            id="ticket-message"
                            wire:model.defer="message"
                            rows="6"
                            class="block w-full rounded-xl border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 dark:border-white/10 dark:bg-gray-900 dark:text-white"
                            placeholder="Write the next update, ask for missing details, or confirm the fix."
                        ></textarea>
                        @error('message')
                            <p class="mt-2 text-sm text-danger-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="ticket-attachment" class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">Attachment</label>
                        <input
                            id="ticket-attachment"
                            type="file"
                            wire:model="attachment"
                            class="block w-full rounded-xl border border-gray-300 bg-white px-3 py-2 text-sm text-gray-700 file:mr-4 file:rounded-lg file:border-0 file:bg-gray-100 file:px-3 file:py-2 file:font-medium hover:file:bg-gray-200 dark:border-white/10 dark:bg-gray-900 dark:text-gray-200 dark:file:bg-white/10"
                        />
                        @error('attachment')
                            <p class="mt-2 text-sm text-danger-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex justify-end">
                        <x-filament::button type="submit" icon="heroicon-m-paper-airplane">
                            Send reply
                        </x-filament::button>
                    </div>
                </form>
            </x-filament::section>
        </div>

        <div class="space-y-6">
            <x-filament::section>
                <x-slot name="heading">
                    <div>
                        <h3 class="text-base font-semibold text-gray-950 dark:text-white">Ticket management</h3>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Keep ownership and status updated here.</p>
                    </div>
                </x-slot>

                <form wire:submit="saveTicketDetails" class="space-y-4">
                    <div>
                        <label for="ticket-status" class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">Status</label>
                        <select
                            id="ticket-status"
                            wire:model.defer="status"
                            class="block w-full rounded-xl border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 dark:border-white/10 dark:bg-gray-900 dark:text-white"
                        >
                            @foreach (\App\Models\Ticket::STATUS_OPTIONS as $value => $label)
                                <option value="{{ $value }}">{{ $label }}</option>
                            @endforeach
                        </select>
                        @error('status')
                            <p class="mt-2 text-sm text-danger-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="ticket-admin" class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">Assigned admin</label>
                        <select
                            id="ticket-admin"
                            wire:model.defer="assignedAdminId"
                            class="block w-full rounded-xl border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 dark:border-white/10 dark:bg-gray-900 dark:text-white"
                        >
                            <option value="">Unassigned</option>
                            @foreach ($this->admins as $id => $name)
                                <option value="{{ $id }}">{{ $name }}</option>
                            @endforeach
                        </select>
                        @error('assignedAdminId')
                            <p class="mt-2 text-sm text-danger-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <x-filament::button type="submit" color="gray" class="w-full">
                        Save ticket details
                    </x-filament::button>
                </form>
            </x-filament::section>

            <x-filament::section>
                <x-slot name="heading">
                    <div class="flex items-center justify-between gap-3">
                        <div>
                            <h3 class="text-base font-semibold text-gray-950 dark:text-white">Deadlines</h3>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Plan follow-ups and delivery checkpoints.</p>
                        </div>

                        <x-filament::button
                            size="sm"
                            color="gray"
                            tag="a"
                            href="{{ \App\Filament\Resources\Deadlines\DeadlineResource::getUrl('create', ['ticket_id' => $ticket->id]) }}"
                        >
                            Add deadline
                        </x-filament::button>
                    </div>
                </x-slot>

                @if ($deadlines->isEmpty())
                    <div class="rounded-2xl border border-dashed border-gray-300 p-5 text-sm text-gray-500 dark:border-white/10 dark:text-gray-400">
                        No deadlines scheduled yet for this ticket.
                    </div>
                @else
                    <div class="space-y-3">
                        @foreach ($deadlines as $deadline)
                            <a
                                href="{{ \App\Filament\Resources\Deadlines\DeadlineResource::getUrl('edit', ['record' => $deadline]) }}"
                                class="block rounded-2xl border border-gray-200 bg-white p-4 transition hover:border-primary-300 hover:shadow-sm dark:border-white/10 dark:bg-white/5"
                            >
                                <div class="flex items-start justify-between gap-3">
                                    <div>
                                        <p class="font-medium text-gray-950 dark:text-white">{{ $deadline->title }}</p>
                                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                                            {{ $deadline->start_at?->format('M j, Y g:i A') ?? 'No start date' }}
                                            @if ($deadline->end_at)
                                                to {{ $deadline->end_at->format('M j, Y g:i A') }}
                                            @endif
                                        </p>
                                    </div>

                                    <x-filament::badge :color="$deadline->status_color">
                                        {{ $deadline->status_label }}
                                    </x-filament::badge>
                                </div>

                                @if ($deadline->description)
                                    <p class="mt-3 text-sm text-gray-600 dark:text-gray-300">{{ \Illuminate\Support\Str::limit($deadline->description, 90) }}</p>
                                @endif
                            </a>
                        @endforeach
                    </div>
                @endif
            </x-filament::section>
        </div>
    </div>

    @push('scripts')
        <script>
            function scrollToBottom() {
                const container = document.getElementById('ticket-replies');

                if (container) {
                    container.scrollTop = container.scrollHeight;
                }
            }

            document.addEventListener('DOMContentLoaded', scrollToBottom);

            document.addEventListener('livewire:initialized', () => {
                Livewire.on('messageSent', () => {
                    setTimeout(scrollToBottom, 100);
                });
            });
        </script>
    @endpush
</x-filament::page>
