<?php

namespace App\Filament\Resources\Deadlines\Schemas;

use App\Models\Deadline;
use App\Models\Ticket;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;

class DeadlineForm
{
    public static function getFields(): array
    {
        return [
            Section::make('Deadline details')
                ->schema([
                    Grid::make(2)->schema([
                        TextInput::make('title')
                            ->required()
                            ->maxLength(255)
                            ->label('Deadline title')
                            ->default(function () {
                                $ticketId = request()->integer('ticket_id');
                                $ticket = $ticketId ? Ticket::find($ticketId) : null;

                                return $ticket ? 'Follow up: ' . str($ticket->title)->limit(60, '') : null;
                            })
                            ->placeholder('Follow up with requester'),

                        Select::make('ticket_id')
                            ->relationship('ticket', 'title')
                            ->searchable()
                            ->preload()
                            ->required()
                            ->label('Related ticket')
                            ->default(request()->integer('ticket_id') ?: null)
                            ->native(false)
                            ->live()
                            ->afterStateUpdated(function ($state, $set, $get) {
                                if (! $state) {
                                    return;
                                }

                                $ticket = Ticket::find($state);

                                if (! $ticket) {
                                    return;
                                }

                                if (blank($get('title'))) {
                                    $set('title', 'Follow up: ' . str($ticket->title)->limit(60, ''));
                                }

                                $currentStart = $get('start_at');

                                if (! $currentStart || $currentStart < $ticket->created_at) {
                                    $set('start_at', $ticket->created_at);
                                }
                            }),
                    ]),

                    Textarea::make('description')
                        ->label('Notes')
                        ->rows(4)
                        ->columnSpanFull()
                        ->placeholder('What needs to happen by this deadline?'),
                ]),

            Section::make('Schedule')
                ->schema([
                    Grid::make(3)->schema([
                        Toggle::make('all_day')
                            ->label('All day')
                            ->default(false)
                            ->live(),

                        Select::make('status')
                            ->required()
                            ->options(Deadline::STATUS_OPTIONS)
                            ->default('pending')
                            ->native(false),

                        Placeholder::make('ticket_created_at')
                            ->label('Ticket created')
                            ->content(fn ($get) => optional(Ticket::find($get('ticket_id')))?->created_at?->format('M j, Y g:i A') ?? 'Pick a ticket'),
                    ]),

                    DateTimePicker::make('start_at')
                        ->required()
                        ->label('Starts at')
                        ->seconds(false)
                        ->default(function ($get) {
                            $ticketId = $get('ticket_id') ?: request()->integer('ticket_id');
                            return optional($ticketId ? Ticket::find($ticketId) : null)?->created_at;
                        })
                        ->minDate(fn ($get) => optional(Ticket::find($get('ticket_id')))->created_at),

                    DateTimePicker::make('end_at')
                        ->label('Ends at')
                        ->seconds(false)
                        ->minDate(fn ($get) => $get('start_at') ?: optional(Ticket::find($get('ticket_id')))->created_at)
                        ->helperText('Leave empty for a single-point reminder or milestone.'),
                ]),
        ];
    }
}
