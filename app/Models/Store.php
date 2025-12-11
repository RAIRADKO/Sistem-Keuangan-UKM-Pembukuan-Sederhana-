<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Store extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'address',
        'business_type',
        'phone',
    ];

    /**
     * Get users associated with this store
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'store_user')
            ->withPivot('role')
            ->withTimestamps();
    }

    /**
     * Get accounts for this store
     */
    public function accounts(): HasMany
    {
        return $this->hasMany(Account::class);
    }

    /**
     * Get transactions for this store
     */
    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class);
    }

    /**
     * Get owners of this store
     */
    public function owners(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'store_user')
            ->wherePivot('role', 'owner')
            ->withTimestamps();
    }

    /**
     * Get staff of this store
     */
    public function staff(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'store_user')
            ->wherePivot('role', 'staff')
            ->withTimestamps();
    }
}
