<?php

namespace App\Filament\Resources\Tickets;

use App\Filament\Resources\Tickets\Pages\CreateTicket;
use App\Filament\Resources\Tickets\Pages\EditTicket;
use App\Filament\Resources\Tickets\Pages\ListTickets;
use App\Filament\Resources\Tickets\Schemas\TicketForm;
use App\Filament\Resources\Tickets\Tables\TicketsTable;
use App\Models\Ticket;
use BackedEnum;
use UnitEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class TicketResource extends Resource
{
    protected static ?string $model = Ticket::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'title';

    protected static string|UnitEnum|null $navigationGroup = 'Tickets';

    public static function form(Schema $schema): Schema
    {
        return $schema->components(TicketForm::getFields());
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns(TicketsTable::getColumns())
            ->filters(TicketsTable::getFilters())
            ->actions(TicketsTable::getActions())
            ->bulkActions(TicketsTable::getBulkActions());
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListTickets::route('/'),
            'edit' => EditTicket::route('/{record}/edit'),
            'conversation' => Pages\Conversation::route('/{record}/conversation'),
        ];
    }

    public static function canCreate(): bool
    {
        return false;
    }
}
