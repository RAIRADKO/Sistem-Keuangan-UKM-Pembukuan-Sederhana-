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
     * Get contacts for this store
     */
    public function contacts(): HasMany
    {
        return $this->hasMany(Contact::class);
    }

    /**
     * Get debts for this store
     */
    public function debts(): HasMany
    {
        return $this->hasMany(Debt::class);
    }

    /**
     * Get product categories for this store
     */
    public function productCategories(): HasMany
    {
        return $this->hasMany(ProductCategory::class);
    }

    /**
     * Get products for this store
     */
    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
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
     * Get managers of this store
     */
    public function managers(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'store_user')
            ->wherePivot('role', 'manager')
            ->withTimestamps();
    }

    /**
     * Get kasirs of this store
     */
    public function kasirs(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'store_user')
            ->wherePivot('role', 'kasir')
            ->withTimestamps();
    }

    /**
     * Get staff of this store (legacy - returns kasirs)
     */
    public function staff(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'store_user')
            ->wherePivot('role', 'kasir')
            ->withTimestamps();
    }

    /**
     * Get user's role in this store
     */
    public function getUserRole(User $user): ?string
    {
        $pivot = $this->users()->where('user_id', $user->id)->first();
        return $pivot ? $pivot->pivot->role : null;
    }

    /**
     * Get total outstanding payables (hutang)
     */
    public function getTotalPayablesAttribute(): float
    {
        return $this->debts()
            ->where('type', 'payable')
            ->whereIn('status', ['unpaid', 'partial'])
            ->sum(\DB::raw('total_amount - paid_amount'));
    }

    /**
     * Get total outstanding receivables (piutang)
     */
    public function getTotalReceivablesAttribute(): float
    {
        return $this->debts()
            ->where('type', 'receivable')
            ->whereIn('status', ['unpaid', 'partial'])
            ->sum(\DB::raw('total_amount - paid_amount'));
    }

    /**
     * Get products with low stock
     */
    public function getLowStockProductsAttribute()
    {
        return $this->products()
            ->active()
            ->lowStock()
            ->get();
    }
}
