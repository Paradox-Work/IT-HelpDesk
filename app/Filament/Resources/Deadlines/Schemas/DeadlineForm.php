<?php

namespace App\Filament\Resources\Deadlines\Schemas;

use App\Models\Ticket;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;

class DeadlineForm
{
    public static function getFields(): array
    {
        return [
            TextInput::make('title')
                ->required()
                ->label('Title'),

            Select::make('ticket_id')
                ->relationship('ticket', 'title')
                ->searchable()
                ->preload()
                ->required()
                ->label('Ticket')
                ->live()
                ->afterStateUpdated(function ($state, $set, $get) {
                    if (! $state) {
                        return;
                    }
                    $ticket = Ticket::find($state);
                    if (! $ticket) {
                        return;
                    }
                    $currentStart = $get('start_at');
                    if (! $currentStart || $currentStart < $ticket->created_at) {
                        $set('start_at', $ticket->created_at);
                    }
                }),

            Textarea::make('description')
                ->label('Notes')
                ->columnSpanFull(),

            Toggle::make('all_day')
                ->label('All Day')
                ->default(false),

            DateTimePicker::make('start_at')
                ->required()
                ->label('Start')
                ->minDate(fn ($get) => optional(Ticket::find($get('ticket_id')))->created_at),

            DateTimePicker::make('end_at')
                ->label('End'),

            // Status is managed by admins outside this form
        ];
    }
}
