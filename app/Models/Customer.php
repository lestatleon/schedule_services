<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Customer extends Model
{
    use HasFactory;

    protected $fillable = [
        'uid',
        'tenant_id',
        'name',
        'email',
        'phone',
        'mobile',
        'isWhatsapp',
    ];

    protected function casts(): array
    {
        return [
            'isWhatsapp' => 'boolean',
        ];
    }

    protected static function booted(): void
    {
        static::creating(function (self $customer): void {
            if (blank($customer->uid)) {
                $customer->uid = (string) Str::uuid();
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
}
