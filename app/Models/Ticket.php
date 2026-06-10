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
        'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function facility()
    {
        return $this->belongsTo(Facility::class);
    }

    public static function generateCode()
    {
        return 'REQ'.now()->format('Ymd').'-'.strtoupper(str()->random(4));
    }
}
