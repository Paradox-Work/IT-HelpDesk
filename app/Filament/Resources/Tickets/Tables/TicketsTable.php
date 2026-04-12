<?php

namespace App\Filament\Resources\Tickets\Tables;

use App\Filament\Resources\Deadlines\DeadlineResource;
use App\Filament\Resources\Tickets\TicketResource;
use Filament\Tables\Columns\TextColumn;
use Filament\Actions\Action;
use Filament\Actions\EditAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;

class TicketsTable
{
    public static function getColumns(): array
    {
        return [
            TextColumn::make('id')
                ->label('#')
                ->sortable(),

            TextColumn::make('title')
                ->label('Ticket')
                ->searchable()
                ->sortable(),

            TextColumn::make('user.name')
                ->label('Requester'),

            TextColumn::make('assignedAdmin.name')
                ->label('Assigned admin')
                ->placeholder('Unassigned'),

            TextColumn::make('priority')
                ->label('Priority')
                ->sortable(),

            TextColumn::make('status')
                ->label('Status')
                ->sortable(),

            TextColumn::make('created_at')
                ->label('Created')
                ->dateTime()
                ->sortable()
                ->toggleable(isToggledHiddenByDefault: true),

            TextColumn::make('updated_at')
                ->label('Updated')
                ->dateTime()
                ->sortable()
                ->toggleable(isToggledHiddenByDefault: true),
        ];
    }

    public static function getFilters(): array
    {
        return [
            SelectFilter::make('status')
                ->options([
                    'open' => 'Open',
                    'in_progress' => 'In Progress',
                    'closed' => 'Closed',
                ])
                ->multiple(),

            SelectFilter::make('priority')
                ->options([
                    'low' => 'Low',
                    'medium' => 'Medium',
                    'high' => 'High',
                ])
                ->multiple(),

            Filter::make('unassigned')
                ->query(fn (Builder $query) => $query->whereNull('assigned_admin_id')),
        ];
    }

    public static function getActions(): array
    {
        return [
            Action::make('conversation')
                ->label('Conversation')
                ->icon('heroicon-m-chat-bubble-left-right')
                ->url(fn ($record) => TicketResource::getUrl('conversation', ['record' => $record])),
            Action::make('deadline')
                ->label('Add deadline')
                ->icon('heroicon-m-calendar-days')
                ->color('gray')
                ->url(fn ($record) => DeadlineResource::getUrl('create', ['ticket_id' => $record->id])),
            EditAction::make(),
        ];
    }

    public static function getBulkActions(): array
    {
        return [
            BulkActionGroup::make([
                DeleteBulkAction::make(),
            ]),
        ];
    }
}
