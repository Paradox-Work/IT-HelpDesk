<?php

namespace App\Filament\Resources\TicketReplies\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Select;

class TicketReplyForm
{
    public static function getFields(): array
    {
        return [
            // Auto-assign logged-in user (hidden)
           TextInput::make('user_id')
                    ->default(fn () => auth()->id())
                    ->hidden()
                    ->label('Created By'),

            // Ticket selection
            Select::make('ticket_id')
                ->required()
                ->relationship('ticket', 'title')
                ->searchable()
                ->label('Ticket'),

            // Message
            Textarea::make('message')
                ->required()
                ->columnSpanFull()
                ->label('Message'),

            // Optional attachment
            TextInput::make('attachment')
                ->nullable()
                ->label('Attachment'),
        ];
    }
}
