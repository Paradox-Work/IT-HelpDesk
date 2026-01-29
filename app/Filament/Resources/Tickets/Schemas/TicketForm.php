<?php

namespace App\Filament\Resources\Tickets\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Select;

class TicketForm
{
    public static function getFields(): array
    {
        return [
            // Auto-assign logged-in user (hidden)
            TextInput::make('user_id')
                ->default(fn () => auth()->id())
                ->hidden()
                ->label('Created By'),

            TextInput::make('title')
                ->required()
                ->label('Ticket Title'),

            Textarea::make('description')
                ->required()
                ->label('Description')
                ->columnSpanFull(),

            Select::make('priority')
                ->required()
                ->label('Priority')
                ->options([
                    'low' => 'Low',
                    'medium' => 'Medium',
                    'high' => 'High',
                ])
                ->default('medium'),

            Select::make('status')
                ->required()
                ->label('Status')
                ->options([
                    'open' => 'Open',
                    'in_progress' => 'In Progress',
                    'closed' => 'Closed',
                ])
                ->default('open'),

            Select::make('assigned_admin_id')
                ->label('Assigned To')
                ->relationship('assignedAdmin', 'name')
                ->searchable()
                ->nullable(),
        ];
    }
}
