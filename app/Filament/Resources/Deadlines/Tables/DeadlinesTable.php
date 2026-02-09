<?php

namespace App\Filament\Resources\Deadlines\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;

class DeadlinesTable
{
    public static function getColumns(): array
    {
        return [
            TextColumn::make('title')
                ->searchable()
                ->sortable(),

            TextColumn::make('ticket.title')
                ->label('Ticket')
                ->searchable()
                ->sortable(),

            TextColumn::make('start_at')
                ->dateTime()
                ->sortable(),

            TextColumn::make('end_at')
                ->dateTime()
                ->sortable()
                ->toggleable(isToggledHiddenByDefault: true),

            IconColumn::make('all_day')
                ->boolean()
                ->label('All Day')
                ->toggleable(isToggledHiddenByDefault: true),

            TextColumn::make('status')
                ->badge()
                ->sortable(),

            TextColumn::make('user.name')
                ->label('Created By')
                ->sortable()
                ->toggleable(isToggledHiddenByDefault: true),
        ];
    }

    public static function getFilters(): array
    {
        return [];
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
