<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Appointment extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id','client_id','start_at','end_at','duration_minutes',
        'status','service','location','notes',
    ];

    protected $casts = [
        'start_at' => 'datetime',
        'end_at'   => 'datetime',
    ];

    public const STATUS_PENDING   = 'pending';
    public const STATUS_CONFIRMED = 'confirmed';
    public const STATUS_CANCELLED = 'cancelled';

    public function user()   { return $this->belongsTo(User::class); }
    public function client() { return $this->belongsTo(Client::class); }
    public function notifications() { return $this->hasMany(Notification::class); }

    /** Scope: rango de fechas UTC */
    public function scopeBetween(Builder $q, $from, $to): Builder {
        return $q->where('start_at', '>=', $from)->where('end_at', '<=', $to);
    }

    /** Scope: del día (UTC) */
    /*public function scopeForDay(Builder $q, \DateTimeInterface $day): Builder {
        $start = (clone $day)->setTime(0,0,0);
        $end   = (clone $day)->setTime(23,59,59);
        return $this->scopeBetween($q, $start, $end);
    }*/

    /** Comprobación de choque simple (no crea constraint en DB) */
    public static function overlapsExists(int $userId, \DateTimeInterface $start, \DateTimeInterface $end, ?int $ignoreId = null): bool {
        return static::where('user_id', $userId)
            ->when($ignoreId, fn($q) => $q->where('id', '!=', $ignoreId))
            ->where(function ($q) use ($start, $end) {
                $q->whereBetween('start_at', [$start, $end])
                  ->orWhereBetween('end_at', [$start, $end])
                  ->orWhere(function ($q2) use ($start, $end) {
                      $q2->where('start_at', '<=', $start)->where('end_at', '>=', $end);
                  });
            })->exists();
    }
}
