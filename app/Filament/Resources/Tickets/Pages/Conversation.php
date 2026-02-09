<?php

namespace App\Filament\Resources\Tickets\Pages;

use App\Filament\Resources\Tickets\TicketResource;
use App\Models\TicketReply;
use App\Models\Ticket;
use Filament\Resources\Pages\Page;
use Livewire\WithFileUploads;

class Conversation extends Page
{
    use WithFileUploads;

    protected static string $resource = TicketResource::class;

    protected string $view = 'filament.resources.tickets.pages.conversation';

    public Ticket $record;
    public string $message = '';
    public $attachment = null;

    public function mount(Ticket $record): void
    {
        $this->record = $record->load(['replies.user', 'assignedAdmin']);
    }

    public function sendMessage(): void
    {
        $this->validate([
            'message' => ['required', 'string'],
            'attachment' => ['nullable', 'file', 'max:5120'],
        ]);

        $attachmentPath = null;
        if ($this->attachment) {
            $attachmentPath = $this->attachment->store('ticket-replies', 'public');
        }

        TicketReply::create([
            'ticket_id' => $this->record->id,
            'user_id' => auth()->id(),
            'message' => $this->message,
            'attachment' => $attachmentPath,
        ]);

        $this->message = '';
        $this->attachment = null;
        $this->record->load(['replies.user', 'assignedAdmin']);
    }
}
