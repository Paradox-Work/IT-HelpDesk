<?php

namespace Database\Seeders;

use App\Models\Deadline;
use App\Models\Ticket;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class DeadlineSeeder extends Seeder
{
    public function run(): void
    {
        $tickets = Ticket::with('user')->get();

        if ($tickets->isEmpty()) {
            $this->command->warn('No tickets found, skipping deadlines.');
            return;
        }

        $base = Carbon::now()->startOfDay()->addDays(1);

        foreach ($tickets as $index => $ticket) {
            $start = $base->copy()->addDays($index)->addHours(9);
            $end = $start->copy()->addHours(2);

            Deadline::create([
                'ticket_id' => $ticket->id,
                'user_id' => $ticket->assigned_admin_id ?? $ticket->user_id,
                'title' => $ticket->title . ' - Deadline',
                'description' => 'Follow up on ticket: ' . $ticket->title,
                'start_at' => $start,
                'end_at' => $end,
                'all_day' => false,
                'status' => 'pending',
            ]);
        }

        $this->command->info('Seeded: deadlines for tickets');
    }
}
