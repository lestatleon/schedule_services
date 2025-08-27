<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;

    protected $fillable = [
        'appointment_id','channel','type','scheduled_at','sent_at','status','meta'
    ];

    protected $casts = [
        'scheduled_at' => 'datetime',
        'sent_at'      => 'datetime',
        'meta'         => 'array',
    ];

    public function appointment() { return $this->belongsTo(Appointment::class); }
}
