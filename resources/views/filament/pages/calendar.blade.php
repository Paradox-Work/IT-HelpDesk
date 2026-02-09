<x-filament::page>
    <div class="flex items-center justify-between gap-4">
        <h2 class="text-lg font-semibold">Deadlines Calendar</h2>
        <x-filament::button tag="a" href="{{ \App\Filament\Resources\Deadlines\DeadlineResource::getUrl('create') }}">
            New Deadline
        </x-filament::button>
    </div>

    <div id="deadline-calendar" class="mt-4 rounded-xl border border-gray-200 bg-white p-4"></div>

    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/index.global.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const el = document.getElementById('deadline-calendar');
            if (!el) return;

            const calendar = new FullCalendar.Calendar(el, {
                initialView: 'dayGridMonth',
                height: 'auto',
                nowIndicator: true,
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay'
                },
                events: @json($events),
                eventClick(info) {
                    if (info.event.url) {
                        info.jsEvent.preventDefault();
                        window.location.href = info.event.url;
                    }
                }
            });

            calendar.render();
        });
    </script>
</x-filament::page>
