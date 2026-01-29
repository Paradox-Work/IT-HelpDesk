<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Ticket;
use App\Models\User;

class TicketSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */

public function run(): void
{
    // Get first user, or create one if none exist
    $user = User::first() ?: User::factory()->create([
        'name' => 'Admin User',
        'email' => 'admin@example.com',
        'password' => bcrypt('password'),
    ]);

    Ticket::create([
        'user_id' => $user->id,
        'title' => 'Test ticket',
        'description' => 'This is a test.',
        'status' => 'open',
        'priority' => 'medium',
    ]);
}

}