<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Deadline extends Model
{
    public const STATUS_OPTIONS = [
        'pending' => 'Pending',
        'in_progress' => 'In Progress',
        'completed' => 'Completed',
        'cancelled' => 'Cancelled',
    ];

    public const STATUS_COLORS = [
        'pending' => 'warning',
        'in_progress' => 'info',
        'completed' => 'success',
        'cancelled' => 'gray',
    ];

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

    public function ticket(): BelongsTo
    {
        return $this->belongsTo(Ticket::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function getStatusLabelAttribute(): string
    {
        return self::STATUS_OPTIONS[$this->status] ?? str($this->status)->headline()->toString();
    }

    public function getStatusColorAttribute(): string
    {
        if ($this->status === 'completed') {
            return 'success';
        }

        if ($this->status === 'cancelled') {
            return 'gray';
        }

        if ($this->end_at && $this->end_at->isPast()) {
            return 'danger';
        }

        if ($this->start_at && $this->start_at->isToday()) {
            return 'warning';
        }

        return self::STATUS_COLORS[$this->status] ?? 'info';
    }
}
