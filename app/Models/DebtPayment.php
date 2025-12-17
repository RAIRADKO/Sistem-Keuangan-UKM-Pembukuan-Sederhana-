<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DebtPayment extends Model
{
    use HasFactory;

    protected $fillable = [
        'debt_id',
        'user_id',
        'transaction_id',
        'amount',
        'payment_date',
        'notes',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'payment_date' => 'date',
    ];

    /**
     * Boot method to handle model events
     */
    protected static function boot()
    {
        parent::boot();

        // After creating a payment, update the debt's paid_amount and status
        static::created(function ($payment) {
            $debt = $payment->debt;
            $debt->paid_amount = $debt->payments()->sum('amount');
            $debt->updateStatus();
        });

        // After updating a payment, recalculate the debt's paid_amount and status
        static::updated(function ($payment) {
            $debt = $payment->debt;
            $debt->paid_amount = $debt->payments()->sum('amount');
            $debt->updateStatus();
        });

        // After deleting a payment, recalculate the debt's paid_amount and status
        static::deleted(function ($payment) {
            $debt = $payment->debt;
            $debt->paid_amount = $debt->payments()->sum('amount');
            $debt->updateStatus();
        });
    }

    /**
     * Get the debt for this payment
     */
    public function debt(): BelongsTo
    {
        return $this->belongsTo(Debt::class);
    }

    /**
     * Get the user who recorded this payment
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
}
