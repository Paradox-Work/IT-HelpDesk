@php
    $replies = $ticket->replies->sortBy('created_at');
@endphp

@if($replies->isEmpty())
    <div class="flex h-64 flex-col items-center justify-center text-center">
        <div class="mb-3 rounded-full bg-gray-100 p-3">
            <svg class="h-6 w-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
            </svg>
        </div>
        <h3 class="mb-1 font-medium text-gray-700">No messages yet</h3>
        <p class="text-sm text-gray-500">Be the first to reply</p>
    </div>
@else
    <div class="space-y-4">
        @foreach($replies as $reply)
            @php
                $isMine = auth()->id() === $reply->user_id;
                $ext = $reply->attachment ? strtolower(pathinfo($reply->attachment, PATHINFO_EXTENSION)) : null;
                $isImage = $ext && in_array($ext, ['jpg','jpeg','png','gif','webp']);
            @endphp
            
            <div class="flex gap-3 {{ $isMine ? 'flex-row-reverse' : '' }}">
                <!-- Avatar -->
                <div class="shrink-0">
                    <div class="h-8 w-8 rounded-full overflow-hidden bg-gray-200 flex items-center justify-center">
                        <span class="text-xs font-medium text-gray-600">
                            {{ strtoupper(substr($reply->user->name, 0, 1)) }}
                        </span>
                    </div>
                </div>

                <!-- Message -->
                <div class="flex max-w-[75%] flex-col {{ $isMine ? 'items-end' : 'items-start' }}">
                    <!-- Header -->
                    <div class="mb-1 flex items-center gap-2">
                        <span class="text-xs font-medium text-gray-700">
                            {{ $reply->user->name }}
                        </span>
                        <span class="text-xs text-gray-500">
                            {{ $reply->created_at->format('g:i A') }}
                        </span>
                    </div>

                    <!-- Bubble -->
                    <div class="rounded-lg px-3 py-2
                        {{ $isMine ? 'bg-blue-100' : 'bg-gray-100' }}">
                        <!-- Text -->
                        <p class="text-sm text-gray-800 whitespace-pre-line">
                            {{ $reply->message }}
                        </p>

                        <!-- Attachment -->
                        @if($reply->attachment)
                            <div class="mt-2">
                                @if($isImage)
                                    <button type="button"
                                            class="overflow-hidden rounded border border-gray-200"
                                            data-lightbox="{{ Storage::url($reply->attachment) }}">
                                        <img src="{{ Storage::url($reply->attachment) }}"
                                             alt="Attachment"
                                             class="max-h-40 rounded object-cover"
                                             loading="lazy">
                                    </button>
                                @else
                                    <a href="{{ Storage::url($reply->attachment) }}"
                                       target="_blank"
                                       class="inline-flex items-center gap-1 text-sm text-blue-600 hover:text-blue-800">
                                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 13h6m-3-3v6m5 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                        </svg>
                                        View Attachment
                                    </a>
                                @endif
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endif