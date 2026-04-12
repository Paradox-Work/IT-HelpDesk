<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Ticket extends Model
{
    protected $guarded = [];

    public const STATUS_OPTIONS = [
        'open' => 'Open',
        'in_progress' => 'In Progress',
        'closed' => 'Closed',
    ];

    public const STATUS_COLORS = [
        'open' => 'info',
        'in_progress' => 'warning',
        'closed' => 'success',
    ];

    public const PRIORITY_OPTIONS = [
        'low' => 'Low',
        'medium' => 'Medium',
        'high' => 'High',
    ];

    public const PRIORITY_COLORS = [
        'low' => 'gray',
        'medium' => 'warning',
        'high' => 'danger',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function assignedAdmin(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_admin_id');
    }

    public function replies(): HasMany
    {
        return $this->hasMany(TicketReply::class);
    }

    public function latestReply(): HasOne
    {
        return $this->hasOne(TicketReply::class)->latestOfMany();
    }

    public function deadlines(): HasMany
    {
        return $this->hasMany(Deadline::class)->orderBy('start_at');
    }

    public function getStatusLabelAttribute(): string
    {
        return self::STATUS_OPTIONS[$this->status] ?? str($this->status)->headline()->toString();
    }

    public function getPriorityLabelAttribute(): string
    {
        return self::PRIORITY_OPTIONS[$this->priority] ?? str($this->priority)->headline()->toString();
    }

    public function getStatusColorAttribute(): string
    {
        return self::STATUS_COLORS[$this->status] ?? 'gray';
    }

    public function getPriorityColorAttribute(): string
    {
        return self::PRIORITY_COLORS[$this->priority] ?? 'gray';
    }

    public function getUpcomingDeadlineAttribute(): ?Deadline
    {
        $deadlines = $this->relationLoaded('deadlines')
            ? $this->deadlines
            : $this->deadlines()->get();

        return $deadlines
            ->where('status', '!=', 'completed')
            ->sortBy('start_at')
            ->first();
    }
}
