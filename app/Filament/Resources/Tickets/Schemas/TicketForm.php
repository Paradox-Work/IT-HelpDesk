<?php

namespace App\Filament\Resources\Tickets\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Placeholder;
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
                ->dehydrated(false)
                ->label('Created By'),

            TextInput::make('title')
                ->required()
                ->label('Ticket Title'),

            Textarea::make('description')
                ->required()
                ->label('Description')
                ->columnSpanFull(),

            FileUpload::make('attachment')
                ->label('Photo')
                ->image()
                ->disk('public')
                ->directory('ticket-attachments')
                ->maxSize(5120)
                ->nullable()
                ->visible(fn ($record) => $record === null),

            Placeholder::make('attachment_view')
                ->label('Photo')
                ->content(function ($record) {
                    if (! $record || ! $record->attachment) {
                        return 'No attachment';
                    }
                    $url = \Illuminate\Support\Facades\Storage::url($record->attachment);
                    return new \Illuminate\Support\HtmlString('<a href="' . e($url) . '" target="_blank" class="text-primary-600 underline">View attachment</a>');
                })
                ->visible(fn ($record) => $record !== null),

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
