<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'store_id',
        'category_id',
        'name',
        'sku',
        'purchase_price',
        'selling_price',
        'stock_quantity',
        'min_stock_alert',
        'description',
        'is_active',
    ];

    protected $casts = [
        'purchase_price' => 'decimal:2',
        'selling_price' => 'decimal:2',
        'stock_quantity' => 'integer',
        'min_stock_alert' => 'integer',
        'is_active' => 'boolean',
    ];

    /**
     * Get the store that owns this product
     */
    public function store(): BelongsTo
    {
        return $this->belongsTo(Store::class);
    }

    /**
     * Get the category for this product
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(ProductCategory::class, 'category_id');
    }

    /**
     * Get stock movements for this product
     */
    public function stockMovements(): HasMany
    {
        return $this->hasMany(StockMovement::class);
    }

    /**
     * Get transaction items for this product
     */
    public function transactionItems(): HasMany
    {
        return $this->hasMany(TransactionItem::class);
    }

    /**
     * Scope for active products
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope for low stock products
     */
    public function scopeLowStock($query)
    {
        return $query->whereColumn('stock_quantity', '<=', 'min_stock_alert')
            ->where('min_stock_alert', '>', 0);
    }

    /**
     * Scope for in stock products
     */
    public function scopeInStock($query)
    {
        return $query->where('stock_quantity', '>', 0);
    }

    /**
     * Check if product is low on stock
     */
    public function getIsLowStockAttribute(): bool
    {
        return $this->min_stock_alert > 0 && $this->stock_quantity <= $this->min_stock_alert;
    }

    /**
     * Get profit margin (selling price - purchase price)
     */
    public function getProfitMarginAttribute(): float
    {
        return (float) $this->selling_price - (float) $this->purchase_price;
    }

    /**
     * Get profit margin percentage
     */
    public function getProfitMarginPercentAttribute(): float
    {
        if ($this->purchase_price == 0) {
            return 0;
        }
        return round((($this->selling_price - $this->purchase_price) / $this->purchase_price) * 100, 2);
    }

    /**
     * Adjust stock and record the movement
     */
    public function adjustStock(int $quantity, string $type, ?int $userId = null, ?int $transactionId = null, ?string $notes = null): StockMovement
    {
        $stockBefore = $this->stock_quantity;
        
        if ($type === 'in') {
            $this->stock_quantity += abs($quantity);
        } elseif ($type === 'out') {
            $this->stock_quantity -= abs($quantity);
        } else { // adjustment
            $this->stock_quantity = $quantity;
            $quantity = $quantity - $stockBefore;
        }
        
        $this->save();

        return $this->stockMovements()->create([
            'user_id' => $userId ?? auth()->id(),
            'transaction_id' => $transactionId,
            'type' => $type,
            'quantity' => $quantity,
            'stock_before' => $stockBefore,
            'stock_after' => $this->stock_quantity,
            'notes' => $notes,
        ]);
    }

    /**
     * Get total revenue from this product
     */
    public function getTotalRevenueAttribute(): float
    {
        return $this->transactionItems()->sum('subtotal');
    }

    /**
     * Get total units sold
     */
    public function getTotalUnitsSoldAttribute(): int
    {
        return $this->transactionItems()->sum('quantity');
    }
}
