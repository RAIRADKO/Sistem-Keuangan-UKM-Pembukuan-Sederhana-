<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Debt extends Model
{
    use HasFactory;

    protected $fillable = [
        'store_id',
        'contact_id',
        'user_id',
        'type',
        'total_amount',
        'paid_amount',
        'status',
        'due_date',
        'debt_date',
        'description',
    ];

    protected $casts = [
        'total_amount' => 'decimal:2',
        'paid_amount' => 'decimal:2',
        'due_date' => 'date',
        'debt_date' => 'date',
    ];

    /**
     * Get the store that owns this debt
     */
    public function store(): BelongsTo
    {
        return $this->belongsTo(Store::class);
    }

    /**
     * Get the contact for this debt
     */
    public function contact(): BelongsTo
    {
        return $this->belongsTo(Contact::class);
    }

    /**
     * Get the user who created this debt
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get payments for this debt
     */
    public function payments(): HasMany
    {
        return $this->hasMany(DebtPayment::class);
    }

    /**
     * Scope for payable (hutang)
     */
    public function scopePayable($query)
    {
        return $query->where('type', 'payable');
    }

    /**
     * Scope for receivable (piutang)
     */
    public function scopeReceivable($query)
    {
        return $query->where('type', 'receivable');
    }

    /**
     * Scope for unpaid debts
     */
    public function scopeUnpaid($query)
    {
        return $query->whereIn('status', ['unpaid', 'partial']);
    }

    /**
     * Scope for overdue debts
     */
    public function scopeOverdue($query)
    {
        return $query->whereNotNull('due_date')
            ->where('due_date', '<', now())
            ->whereIn('status', ['unpaid', 'partial']);
    }

    /**
     * Get remaining amount to pay
     */
    public function getRemainingAmountAttribute(): float
    {
        return (float) $this->total_amount - (float) $this->paid_amount;
    }

    /**
     * Check if debt is overdue
     */
    public function getIsOverdueAttribute(): bool
    {
        return $this->due_date && 
               $this->due_date->isPast() && 
               in_array($this->status, ['unpaid', 'partial']);
    }

    /**
     * Get payment progress percentage
     */
    public function getPaymentProgressAttribute(): float
    {
        if ($this->total_amount == 0) {
            return 100;
        }
        return round(($this->paid_amount / $this->total_amount) * 100, 2);
    }

    /**
     * Update status based on paid amount
     */
    public function updateStatus(): void
    {
        if ($this->paid_amount >= $this->total_amount) {
            $this->status = 'paid';
        } elseif ($this->paid_amount > 0) {
            $this->status = 'partial';
        } else {
            $this->status = 'unpaid';
        }
        $this->save();
    }

    /**
     * Get type label in Indonesian
     */
    public function getTypeLabelAttribute(): string
    {
        return $this->type === 'payable' ? 'Hutang' : 'Piutang';
    }

    /**
     * Get status label in Indonesian
     */
    public function getStatusLabelAttribute(): string
    {
        return match($this->status) {
            'unpaid' => 'Belum Lunas',
            'partial' => 'Sebagian',
            'paid' => 'Lunas',
            default => $this->status,
        };
    }

    /**
     * Get status color for UI
     */
    public function getStatusColorAttribute(): string
    {
        return match($this->status) {
            'unpaid' => 'red',
            'partial' => 'yellow',
            'paid' => 'green',
            default => 'gray',
        };
    }
}
