<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Deadline extends Model
{
    protected $fillable = [
        'ticket_id',
        'user_id',
        'title',
        'description',
        'start_at',
        'end_at',
        'all_day',
        'status',
    ];

    protected $casts = [
        'start_at' => 'datetime',
        'end_at' => 'datetime',
        'all_day' => 'boolean',
    ];

    public function ticket()
    {
        return $this->belongsTo(Ticket::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
