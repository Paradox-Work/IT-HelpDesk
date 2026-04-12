<x-filament::page>
    <div class="space-y-5">
        <div class="flex flex-col gap-3 md:flex-row md:items-center md:justify-between">
            <div>
                <h2 class="text-xl font-semibold text-gray-950 dark:text-white">Deadline calendar</h2>
                <p class="text-sm text-gray-500 dark:text-gray-400">Track upcoming ticket commitments without leaving the admin panel.</p>
            </div>

            <x-filament::button tag="a" href="{{ \App\Filament\Resources\Deadlines\DeadlineResource::getUrl('create') }}">
                New deadline
            </x-filament::button>
        </div>

        <div class="grid gap-4 md:grid-cols-3">
            <div class="rounded-2xl border border-gray-200 bg-white p-4 shadow-sm dark:border-white/10 dark:bg-white/5">
                <p class="text-xs font-semibold uppercase tracking-[0.2em] text-gray-500 dark:text-gray-400">Total events</p>
                <p class="mt-2 text-2xl font-semibold text-gray-950 dark:text-white">{{ count($events) }}</p>
            </div>
            <div class="rounded-2xl border border-gray-200 bg-white p-4 shadow-sm dark:border-white/10 dark:bg-white/5">
                <p class="text-xs font-semibold uppercase tracking-[0.2em] text-gray-500 dark:text-gray-400">Active work</p>
                <p class="mt-2 text-2xl font-semibold text-gray-950 dark:text-white">{{ collect($events)->where('extendedProps.status', '!=', 'completed')->count() }}</p>
            </div>
            <div class="rounded-2xl border border-gray-200 bg-white p-4 shadow-sm dark:border-white/10 dark:bg-white/5">
                <p class="text-xs font-semibold uppercase tracking-[0.2em] text-gray-500 dark:text-gray-400">Completed</p>
                <p class="mt-2 text-2xl font-semibold text-gray-950 dark:text-white">{{ collect($events)->where('extendedProps.status', 'completed')->count() }}</p>
            </div>
        </div>

        <div class="overflow-hidden rounded-3xl border border-gray-200 bg-white shadow-sm dark:border-white/10 dark:bg-[#111827]">
            <div class="border-b border-gray-200 px-5 py-4 dark:border-white/10">
                <div class="flex flex-col gap-3 md:flex-row md:items-center md:justify-between">
                    <p class="text-sm text-gray-500 dark:text-gray-400">Month view only, with each day acting like a clear planning square instead of a timeline.</p>
                    <div class="flex flex-wrap gap-2 text-xs font-medium">
                        <span class="rounded-full bg-amber-100 px-3 py-1 text-amber-900 dark:bg-amber-500/15 dark:text-amber-200">Pending</span>
                        <span class="rounded-full bg-sky-100 px-3 py-1 text-sky-900 dark:bg-sky-500/15 dark:text-sky-200">In Progress</span>
                        <span class="rounded-full bg-emerald-100 px-3 py-1 text-emerald-900 dark:bg-emerald-500/15 dark:text-emerald-200">Completed</span>
                        <span class="rounded-full bg-rose-100 px-3 py-1 text-rose-900 dark:bg-rose-500/15 dark:text-rose-200">Overdue</span>
                    </div>
                </div>
            </div>
            <div id="deadline-calendar" class="filament-deadline-calendar p-4 md:p-6"></div>
        </div>
    </div>

    <style>
        .filament-deadline-calendar {
            overflow: hidden;
        }

        .filament-deadline-calendar .fc {
            --fc-border-color: rgba(148, 163, 184, 0.24);
            --fc-today-bg-color: rgba(245, 158, 11, 0.08);
            --fc-page-bg-color: transparent;
            --fc-neutral-bg-color: transparent;
            --fc-list-event-hover-bg-color: rgba(245, 158, 11, 0.08);
        }

        .filament-deadline-calendar .fc-media-screen {
            min-height: 0;
        }

        .filament-deadline-calendar .fc-scrollgrid,
        .filament-deadline-calendar .fc-theme-standard td,
        .filament-deadline-calendar .fc-theme-standard th {
            border-color: var(--fc-border-color);
        }

        .filament-deadline-calendar .fc-toolbar {
            gap: 0.75rem;
            flex-wrap: wrap;
            margin-bottom: 1rem;
        }

        .filament-deadline-calendar .fc-toolbar-title {
            font-size: 1.2rem;
            font-weight: 700;
        }

        .filament-deadline-calendar .fc-button {
            border-radius: 9999px;
            border: 0;
            box-shadow: none;
            padding: 0.55rem 0.9rem;
            background: #111827;
        }

        .filament-deadline-calendar .fc-button-primary:not(:disabled).fc-button-active,
        .filament-deadline-calendar .fc-button-primary:not(:disabled):active,
        .filament-deadline-calendar .fc-button:hover {
            background: #d97706;
        }

        .filament-deadline-calendar .fc-col-header-cell {
            background: rgba(15, 23, 42, 0.04);
            padding-block: 0.35rem;
        }

        .filament-deadline-calendar .fc-col-header-cell-cushion {
            padding: 0.5rem 0.25rem;
            font-size: 0.78rem;
            font-weight: 700;
            letter-spacing: 0.04em;
            text-transform: uppercase;
        }

        .filament-deadline-calendar .fc-daygrid-day-frame {
            min-height: 8.5rem;
            padding: 0.35rem;
        }

        .filament-deadline-calendar .fc-daygrid-day-top {
            justify-content: flex-end;
            margin-bottom: 0.25rem;
        }

        .filament-deadline-calendar .fc-daygrid-day-number {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 2rem;
            height: 2rem;
            border-radius: 9999px;
            font-size: 0.85rem;
            font-weight: 700;
            color: rgb(15 23 42);
        }

        .filament-deadline-calendar .fc-day-today .fc-daygrid-day-number {
            background: #d97706;
            color: white;
        }

        .filament-deadline-calendar .fc-daygrid-day-events {
            margin: 0;
        }

        .filament-deadline-calendar .fc-daygrid-more-link {
            margin-top: 0.35rem;
            font-size: 0.72rem;
            font-weight: 700;
            color: #d97706;
        }

        .filament-deadline-calendar .fc-daygrid-event-harness {
            margin: 0 0 0.35rem;
        }

        .filament-deadline-calendar .fc-daygrid-event {
            border: 0;
            border-radius: 1rem;
            padding: 0;
            overflow: hidden;
            box-shadow: none;
        }

        .filament-deadline-calendar .fc-event-main {
            overflow: hidden;
        }

        .filament-deadline-calendar .calendar-event-card {
            display: block;
            min-width: 0;
            padding: 0.6rem 0.7rem;
            border-radius: 1rem;
            backdrop-filter: blur(4px);
        }

        .filament-deadline-calendar .calendar-event-title,
        .filament-deadline-calendar .calendar-event-meta {
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .filament-deadline-calendar .calendar-event-title {
            font-size: 0.78rem;
            font-weight: 700;
            line-height: 1.2;
        }

        .filament-deadline-calendar .calendar-event-meta {
            margin-top: 0.2rem;
            font-size: 0.7rem;
            opacity: 0.85;
        }

        @media (max-width: 768px) {
            .filament-deadline-calendar .fc-header-toolbar {
                align-items: flex-start;
            }

            .filament-deadline-calendar .fc-toolbar-chunk {
                display: flex;
                flex-wrap: wrap;
                gap: 0.5rem;
            }

            .filament-deadline-calendar .fc-daygrid-day-frame {
                min-height: 6.5rem;
            }

            .filament-deadline-calendar .calendar-event-card {
                padding: 0.4rem 0.5rem;
            }

            .filament-deadline-calendar .calendar-event-meta {
                display: none;
            }
        }
    </style>

    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/index.global.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const el = document.getElementById('deadline-calendar');

            if (! el) {
                return;
            }

            const calendar = new FullCalendar.Calendar(el, {
                initialView: 'dayGridMonth',
                height: 'auto',
                expandRows: true,
                fixedWeekCount: false,
                showNonCurrentDates: true,
                dayMaxEventRows: 3,
                displayEventTime: false,
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: ''
                },
                events: @json($events),
                eventClick(info) {
                    if (info.event.url) {
                        info.jsEvent.preventDefault();
                        window.location.href = info.event.url;
                    }
                },
                eventContent(info) {
                    const wrapper = document.createElement('div');
                    wrapper.className = 'calendar-event-card';

                    const title = document.createElement('div');
                    title.className = 'calendar-event-title';
                    title.textContent = info.event.title;

                    const meta = document.createElement('div');
                    meta.className = 'calendar-event-meta';
                    meta.textContent = info.event.extendedProps.ticket || info.event.extendedProps.status || '';

                    wrapper.appendChild(title);

                    if (meta.textContent) {
                        wrapper.appendChild(meta);
                    }

                    return { domNodes: [wrapper] };
                }
            });

            calendar.render();
        });
    </script>
</x-filament::page>
