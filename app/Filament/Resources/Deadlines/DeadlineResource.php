<?php

namespace App\Filament\Resources\Deadlines;

use App\Filament\Resources\Deadlines\Pages\CreateDeadline;
use App\Filament\Resources\Deadlines\Pages\EditDeadline;
use App\Filament\Resources\Deadlines\Pages\ListDeadlines;
use App\Filament\Resources\Deadlines\Schemas\DeadlineForm;
use App\Filament\Resources\Deadlines\Tables\DeadlinesTable;
use App\Models\Deadline;
use BackedEnum;
use UnitEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class DeadlineResource extends Resource
{
    protected static ?string $model = Deadline::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedCalendarDays;

    protected static ?string $navigationLabel = 'Deadlines';

    protected static ?string $recordTitleAttribute = 'title';

    protected static string|UnitEnum|null $navigationGroup = 'Tickets';

    public static function form(Schema $schema): Schema
    {
        return $schema->components(DeadlineForm::getFields());
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns(DeadlinesTable::getColumns())
            ->filters(DeadlinesTable::getFilters())
            ->actions(DeadlinesTable::getActions())
            ->bulkActions(DeadlinesTable::getBulkActions());
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListDeadlines::route('/'),
            'create' => CreateDeadline::route('/create'),
            'edit' => EditDeadline::route('/{record}/edit'),
        ];
    }
}
