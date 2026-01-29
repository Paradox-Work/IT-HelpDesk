<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class TicketSeeder extends Seeder
{
    public function run(): void
    {
        // Create Admin User
        $admin = User::updateOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Admin User',
                'password' => Hash::make('password'),
                'is_admin' => true,
            ]
        );

        // Create Regular User
        $user = User::updateOrCreate(
            ['email' => 'user@example.com'],
            [
                'name' => 'Regular User',
                'password' => Hash::make('password'),
                'is_admin' => false,
            ]
        );

        // Create tickets for regular user
        Ticket::create([
            'user_id' => $user->id,
            'title' => 'My computer won\'t turn on',
            'description' => 'I press the power button but nothing happens. The power cable is plugged in.',
            'status' => 'open',
            'priority' => 'high',
        ]);

        Ticket::create([
            'user_id' => $user->id,
            'title' => 'Need software installation',
            'description' => 'Can you install Adobe Photoshop on my work computer?',
            'status' => 'in_progress',
            'priority' => 'medium',
        ]);

        Ticket::create([
            'user_id' => $user->id,
            'title' => 'Printer not working',
            'description' => 'The office printer shows "paper jam" error but there\'s no paper stuck.',
            'status' => 'closed',
            'priority' => 'low',
        ]);

        // Create a ticket assigned to admin (for testing)
        Ticket::create([
            'user_id' => $user->id,
            'assigned_admin_id' => $admin->id,
            'title' => 'Network connection issue',
            'description' => 'Can\'t connect to WiFi in conference room.',
            'status' => 'open',
            'priority' => 'medium',
        ]);

        $this->command->info('Seeded:');
        $this->command->info('- Admin User: admin@example.com / password');
        $this->command->info('- Regular User: user@example.com / password');
        $this->command->info('- 4 sample tickets created');
    }
}