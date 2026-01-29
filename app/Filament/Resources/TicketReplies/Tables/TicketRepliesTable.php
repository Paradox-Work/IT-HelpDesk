<?php

namespace App\Filament\Resources\TicketReplies\Tables;

use Filament\Tables\Columns\TextColumn;
use Filament\Actions\EditAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;

class TicketRepliesTable
{
    public static function getColumns(): array
    {
        return [
            TextColumn::make('message')->searchable()->label('Message')->sortable(),
            TextColumn::make('user.name')->label('Created By')->sortable(),
            TextColumn::make('ticket.title')->label('Ticket')->sortable()->searchable(),
            TextColumn::make('created_at')->dateTime()->sortable(),
            TextColumn::make('updated_at')->dateTime()->sortable()->toggleable(isToggledHiddenByDefault: true),
        ];
    }

    public static function getFilters(): array
    {
        return [
            // Define any filters if you want, otherwise just return empty
        ];
    }

    public static function getActions(): array
    {
        return [
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
