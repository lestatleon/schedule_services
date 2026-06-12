<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Appointment extends Model
{
    use HasFactory;

    protected $fillable = [
        'uid',
        'tenant_id',
        'branch_id',
        'customer_id',
        'date',
        'time',
        'duration',
    ];

    protected function casts(): array
    {
        return [
            'date' => 'date:Y-m-d',
            'duration' => 'integer',
        ];
    }

    protected static function booted(): void
    {
        static::creating(function (self $appointment): void {
            if (blank($appointment->uid)) {
                $appointment->uid = (string) Str::uuid();
            }
        });
    }

    public function getRouteKeyName(): string
    {
        return 'uid';
    }

    public function tenant(): BelongsTo
    {
        return $this->belongsTo(Tenant::class);
    }

    public function branch(): BelongsTo
    {
        return $this->belongsTo(Branch::class);
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

}
