<?php

namespace App\Filament\Resources\Tickets\Tables;

use Filament\Tables\Columns\TextColumn;
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
