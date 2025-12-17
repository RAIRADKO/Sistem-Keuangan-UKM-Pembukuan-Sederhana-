<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StockMovement extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'user_id',
        'transaction_id',
        'type',
        'quantity',
        'stock_before',
        'stock_after',
        'notes',
    ];

    protected $casts = [
        'quantity' => 'integer',
        'stock_before' => 'integer',
        'stock_after' => 'integer',
    ];

    /**
     * Get the product for this movement
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Get the user who recorded this movement
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the linked transaction (if any)
     */
    public function transaction(): BelongsTo
    {
        return $this->belongsTo(Transaction::class);
    }

    /**
     * Get type label in Indonesian
     */
    public function getTypeLabelAttribute(): string
    {
        return match($this->type) {
            'in' => 'Stok Masuk',
            'out' => 'Stok Keluar',
            'adjustment' => 'Penyesuaian',
            default => $this->type,
        };
    }

    /**
     * Get type color for UI
     */
    public function getTypeColorAttribute(): string
    {
        return match($this->type) {
            'in' => 'green',
            'out' => 'red',
            'adjustment' => 'blue',
            default => 'gray',
        };
    }
}
