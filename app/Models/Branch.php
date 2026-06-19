<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Branch extends Model
{
    use HasFactory;

    protected $fillable = [
        'uid',
        'tenant_id',
        'name',
        'default',
    ];

    protected static function booted(): void
    {
        static::creating(function (self $branch): void {
            if (blank($branch->uid)) {
                $branch->uid = (string) Str::uuid();
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
