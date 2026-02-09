<?php

namespace App\Filament\Widgets;

use App\Models\Deadline;
use App\Models\Ticket;
use App\Models\TicketReply;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Carbon;

class TicketStats extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        $today = Carbon::now()->startOfDay();

        return [
            Stat::make('Total Tickets', Ticket::count())
                ->description('All tickets in the system')
                ->color('gray'),
            Stat::make('Open Tickets', Ticket::where('status', 'open')->count())
                ->description('Awaiting action')
                ->color('success'),
            Stat::make('In Progress', Ticket::where('status', 'in_progress')->count())
                ->description('Being worked on')
                ->color('warning'),
            Stat::make('Closed Tickets', Ticket::where('status', 'closed')->count())
                ->description('Resolved')
                ->color('gray'),
            Stat::make('Deadlines', Deadline::count())
                ->description('Tracked deadlines')
                ->color('info'),
            Stat::make('Replies Today', TicketReply::where('created_at', '>=', $today)->count())
                ->description('Messages since midnight')
                ->color('primary'),
        ];
    }
}
