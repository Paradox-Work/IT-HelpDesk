<?php

namespace App\Filament\Resources\Tickets\Schemas;

use App\Models\Ticket;
use App\Models\User;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Select;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;

class TicketForm
{
    public static function getFields(): array
    {
        return [
            Section::make('Ticket details')
                ->schema([
                    Grid::make(2)->schema([
                        TextInput::make('title')
                            ->required()
                            ->maxLength(255)
                            ->label('Ticket title')
                            ->placeholder('Printer offline in room 204'),

                        Select::make('priority')
                            ->required()
                            ->label('Priority')
                            ->options(Ticket::PRIORITY_OPTIONS)
                            ->default('medium')
                            ->native(false),
                    ]),

                    Textarea::make('description')
                        ->required()
                        ->label('Description')
                        ->rows(6)
                        ->columnSpanFull()
                        ->placeholder('Summarize the issue, what has been tried, and how urgent it feels.'),

                    FileUpload::make('attachment')
                        ->label('Attachment')
                        ->image()
                        ->disk('public')
                        ->directory('ticket-attachments')
                        ->maxSize(5120)
                        ->nullable()
                        ->visible(fn ($record) => $record === null),

                    Placeholder::make('attachment_view')
                        ->label('Attachment')
                        ->content(function ($record) {
                            if (! $record || ! $record->attachment) {
                                return 'No attachment uploaded';
                            }

                            $url = \Illuminate\Support\Facades\Storage::url($record->attachment);

                            return new \Illuminate\Support\HtmlString('<a href="' . e($url) . '" target="_blank" class="text-primary-600 underline">Open attachment</a>');
                        })
                        ->visible(fn ($record) => $record !== null),
                ]),

            Section::make('Workflow')
                ->schema([
                    Grid::make(3)->schema([
                        Placeholder::make('requester')
                            ->label('Requester')
                            ->content(fn ($record) => $record?->user?->name ?? 'Customer ticket'),

                        Select::make('status')
                            ->required()
                            ->label('Status')
                            ->options(Ticket::STATUS_OPTIONS)
                            ->default('open')
                            ->native(false),

                        Select::make('assigned_admin_id')
                            ->label('Assigned admin')
                            ->options(fn () => User::query()->where('is_admin', true)->orderBy('name')->pluck('name', 'id')->all())
                            ->searchable()
                            ->preload()
                            ->nullable()
                            ->native(false)
                            ->helperText('Leave blank if this ticket still needs an owner.'),
                    ]),

                    Placeholder::make('upcoming_deadline')
                        ->label('Next deadline')
                        ->content(function ($record) {
                            $startAt = $record?->upcomingDeadline?->start_at;

                            return $startAt ? $startAt->format('M j, Y g:i A') : 'No deadline scheduled';
                        })
                        ->visible(fn ($record) => $record !== null),
                ]),
        ];
    }
}
