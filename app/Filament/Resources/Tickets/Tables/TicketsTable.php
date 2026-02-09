<?php

namespace App\Filament\Resources\Tickets\Tables;

use Filament\Tables\Columns\TextColumn;
use Filament\Actions\Action;
use Filament\Actions\EditAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;

class TicketsTable
{
    public static function getColumns(): array
    {
        return [
            TextColumn::make('title')
                ->searchable()
                ->sortable(),

            TextColumn::make('user.name')
                ->label('Created By')
                ->sortable(),

            TextColumn::make('assignedAdmin.name')
                ->label('Assigned To')
                ->sortable()
                ->toggleable(isToggledHiddenByDefault: true),

            TextColumn::make('priority')
                ->badge()
                ->sortable(),

            TextColumn::make('status')
                ->badge()
                ->sortable(),

            TextColumn::make('created_at')
                ->dateTime()
                ->sortable(),

            TextColumn::make('updated_at')
                ->dateTime()
                ->sortable()
                ->toggleable(isToggledHiddenByDefault: true),

            TextColumn::make('latestReply.created_at')
                ->label('Last Message')
                ->since()
                ->sortable()
                ->toggleable(isToggledHiddenByDefault: true),

            TextColumn::make('latestReply.user_id')
                ->label('New')
                ->badge()
                ->formatStateUsing(fn ($state, $record) => $record && $record->latestReply && ! $record->latestReply->user?->is_admin ? '1' : null)
                ->color('danger')
                ->visible(fn ($record) => $record && $record->latestReply && ! $record->latestReply->user?->is_admin),
        ];
    }

    public static function getFilters(): array
    {
        return [
            // Define filters here, or leave empty
        ];
    }

    public static function getActions(): array
    {
        return [
            Action::make('conversation')
                ->label('Conversation')
                ->url(fn ($record) => \App\Filament\Resources\Tickets\TicketResource::getUrl('conversation', ['record' => $record])),
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
