<?php

namespace App\Filament\Resources\Tickets\Pages;

use App\Filament\Resources\Tickets\TicketResource;
use App\Models\Ticket;
use App\Models\TicketReply;
use App\Models\User;
use Filament\Notifications\Notification;
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
    public string $status = 'open';
    public ?int $assignedAdminId = null;

    public function mount(Ticket $record): void
    {
        $this->record = $record->load(['user', 'replies.user', 'assignedAdmin', 'deadlines']);
        $this->status = $this->record->status;
        $this->assignedAdminId = $this->record->assigned_admin_id;
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
        $this->record->load(['user', 'replies.user', 'assignedAdmin', 'deadlines']);
        $this->dispatch('messageSent');

        Notification::make()
            ->title('Reply sent')
            ->success()
            ->send();
    }

    public function saveTicketDetails(): void
    {
        $this->validate([
            'status' => ['required', 'in:' . implode(',', array_keys(Ticket::STATUS_OPTIONS))],
            'assignedAdminId' => ['nullable', 'exists:users,id'],
        ]);

        if ($this->assignedAdminId && ! User::whereKey($this->assignedAdminId)->where('is_admin', true)->exists()) {
            $this->addError('assignedAdminId', 'Please choose a valid admin.');

            return;
        }

        $this->record->update([
            'status' => $this->status,
            'assigned_admin_id' => $this->assignedAdminId,
        ]);

        $this->record->load(['user', 'replies.user', 'assignedAdmin', 'deadlines']);

        Notification::make()
            ->title('Ticket updated')
            ->success()
            ->send();
    }

    public function getAdminsProperty()
    {
        return User::query()
            ->where('is_admin', true)
            ->orderBy('name')
            ->pluck('name', 'id');
    }
}
