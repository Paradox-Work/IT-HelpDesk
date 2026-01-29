<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // ===== ADD THESE RELATIONSHIPS =====
    
    // Tickets created by this user
    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }

    // Tickets assigned to this user (if admin)
    public function assignedTickets()
    {
        return $this->hasMany(Ticket::class, 'assigned_admin_id');
    }

    // Replies/comments by this user
    public function ticketReplies()
    {
        return $this->hasMany(TicketReply::class);
    }

    

    }