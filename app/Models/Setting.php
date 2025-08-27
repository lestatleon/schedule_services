<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id','timezone','reminder_offsets','email_provider_config','sms_provider_config'
    ];

    protected $casts = [
        'reminder_offsets'     => 'array',
        'email_provider_config' => 'array',
        'sms_provider_config'   => 'array',
    ];

    public function user() { return $this->belongsTo(User::class); }
}
