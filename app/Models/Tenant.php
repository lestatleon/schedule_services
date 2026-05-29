<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Tenant extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'uid',
        'name',
        'plan',
    ];

    protected static function booted(): void
    {
        static::creating(function (self $tenant): void {
            if (blank($tenant->uid)) {
                $tenant->uid = (string) Str::uuid();
            }
        });
    }

    public function getRouteKeyName(): string
    {
        return 'uid';
    }

    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    public function customers(): HasMany
    {
        return $this->hasMany(Customer::class);
    }

    public function branches(): HasMany
    {
        return $this->hasMany(Branch::class);
    }
}
