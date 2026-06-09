<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    protected $fillable = [
        'user_id',
        'facility_id',
        'ticket_code',
        'event_name',
        'purpose',
        'note',
        'status',
        'approved_at',
        'checked_in_at',
        'completed_at',
        'cancelled_at',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function facility()
    {
        return $this->belongsTo(Facility::class);
    }

    public function generateCode()
    {
        $prefix = 'TKT-';
        $lastTicket = self::orderBy('ticket_code', 'desc')->first();

        if ($lastTicket) {
            $lastNumber = (int) substr($lastTicket->ticket_code, strlen($prefix));
            $newNumber = $lastNumber + 1;
        } else {
            $newNumber = 1;
        }

        return $prefix . str_pad($newNumber, 5, '0', STR_PAD_LEFT);
    }
}
