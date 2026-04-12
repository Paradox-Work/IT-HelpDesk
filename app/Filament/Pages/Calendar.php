<?php

namespace App\Filament\Pages;

use App\Filament\Resources\Deadlines\DeadlineResource;
use App\Models\Deadline;
use BackedEnum;
use UnitEnum;
use Filament\Pages\Page;
use Filament\Support\Icons\Heroicon;

class Calendar extends Page
{
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedCalendarDays;

    protected static ?string $navigationLabel = 'Calendar';

    protected static string|UnitEnum|null $navigationGroup = 'Tickets';

    protected string $view = 'filament.pages.calendar';

    public function getViewData(): array
    {
        $events = Deadline::with('ticket')
            ->orderBy('start_at')
            ->get()
            ->map(function (Deadline $deadline) {
                $color = match ($deadline->status) {
                    'completed' => '#16a34a',
                    'cancelled' => '#6b7280',
                    'in_progress' => '#0284c7',
                    default => ($deadline->end_at && $deadline->end_at->isPast() ? '#dc2626' : '#d97706'),
                };

                return [
                    'id' => $deadline->id,
                    'title' => $deadline->title,
                    'start' => optional($deadline->start_at)->toIso8601String(),
                    'end' => optional($deadline->end_at)->toIso8601String(),
                    'allDay' => (bool) $deadline->all_day,
                    'url' => DeadlineResource::getUrl('edit', ['record' => $deadline]),
                    'backgroundColor' => $color,
                    'borderColor' => $color,
                    'textColor' => '#ffffff',
                    'extendedProps' => [
                        'status' => $deadline->status,
                        'ticket' => $deadline->ticket?->title,
                    ],
                ];
            })
            ->values();

        return [
            'events' => $events,
        ];
    }
}
