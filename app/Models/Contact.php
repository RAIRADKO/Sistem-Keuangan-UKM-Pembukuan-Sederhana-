<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Contact extends Model
{
    use HasFactory;

    protected $fillable = [
        'store_id',
        'name',
        'type',
        'phone',
        'address',
        'notes',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Get the store that owns this contact
     */
    public function store(): BelongsTo
    {
        return $this->belongsTo(Store::class);
    }

    /**
     * Get debts for this contact
     */
    public function debts(): HasMany
    {
        return $this->hasMany(Debt::class);
    }

    /**
     * Scope for suppliers
     */
    public function scopeSuppliers($query)
    {
        return $query->where('type', 'supplier');
    }

    /**
     * Scope for customers
     */
    public function scopeCustomers($query)
    {
        return $query->where('type', 'customer');
    }

    /**
     * Scope for active contacts
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Get total outstanding debt (hutang kepada contact ini)
     */
    public function getTotalPayableAttribute(): float
    {
        return $this->debts()
            ->where('type', 'payable')
            ->whereIn('status', ['unpaid', 'partial'])
            ->sum(\DB::raw('total_amount - paid_amount'));
    }

    /**
     * Get total outstanding receivable (piutang dari contact ini)
     */
    public function getTotalReceivableAttribute(): float
    {
        return $this->debts()
            ->where('type', 'receivable')
            ->whereIn('status', ['unpaid', 'partial'])
            ->sum(\DB::raw('total_amount - paid_amount'));
    }
}
