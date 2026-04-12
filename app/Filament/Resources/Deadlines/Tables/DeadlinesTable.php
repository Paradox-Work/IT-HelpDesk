<?php

namespace App\Filament\Resources\Deadlines\Tables;

use App\Models\Deadline;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Builder;

class DeadlinesTable
{
    public static function getColumns(): array
    {
        return [
            TextColumn::make('title')
                ->label('Deadline')
                ->searchable()
                ->sortable()
                ->description(fn (Deadline $record) => $record->description ? str($record->description)->limit(60) : null),

            TextColumn::make('ticket.title')
                ->label('Ticket')
                ->searchable()
                ->sortable(),

            TextColumn::make('start_at')
                ->label('Starts')
                ->dateTime()
                ->sortable(),

            TextColumn::make('end_at')
                ->label('Ends')
                ->since()
                ->placeholder('None')
                ->sortable()
                ->toggleable(),

            IconColumn::make('all_day')
                ->boolean()
                ->label('All Day')
                ->toggleable(isToggledHiddenByDefault: true),

            TextColumn::make('status')
                ->badge()
                ->formatStateUsing(fn (string $state) => Deadline::STATUS_OPTIONS[$state] ?? str($state)->headline()->toString())
                ->color(fn (Deadline $record) => $record->status_color)
                ->sortable(),

            TextColumn::make('user.name')
                ->label('Created By')
                ->sortable()
                ->toggleable(isToggledHiddenByDefault: true),
        ];
    }

    public static function getFilters(): array
    {
        return [
            SelectFilter::make('status')
                ->options(Deadline::STATUS_OPTIONS)
                ->multiple(),

            Filter::make('open_only')
                ->label('Active deadlines')
                ->query(fn (Builder $query) => $query->whereNotIn('status', ['completed', 'cancelled'])),

            Filter::make('overdue')
                ->query(fn (Builder $query) => $query
                    ->where('status', '!=', 'completed')
                    ->whereNotNull('end_at')
                    ->where('end_at', '<', now())),
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
