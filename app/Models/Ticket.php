<?php

namespace App\Models;
use App\Models\TicketReply;

use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function assignedAdmin()
    {
        return $this->belongsTo(User::class, 'assigned_admin_id');
    }

    public function replies() {
    return $this->hasMany(TicketReply::class);
}

    public function latestReply()
    {
        return $this->hasOne(TicketReply::class)->latestOfMany();
    }

    public function deadlines()
    {
        return $this->hasMany(Deadline::class);
    }

}
