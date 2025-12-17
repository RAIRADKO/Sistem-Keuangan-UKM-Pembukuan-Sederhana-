<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Carbon\Carbon;

class Budget extends Model
{
    use HasFactory;

    protected $fillable = [
        'store_id',
        'account_id',
        'name',
        'amount',
        'period',
        'alert_threshold',
        'is_active',
        'notes',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'alert_threshold' => 'integer',
        'is_active' => 'boolean',
    ];

    /**
     * Get the store that owns this budget.
     */
    public function store(): BelongsTo
    {
        return $this->belongsTo(Store::class);
    }

    /**
     * Get the account (category) for this budget.
     */
    public function account(): BelongsTo
    {
        return $this->belongsTo(Account::class);
    }

    /**
     * Get the date range for the current period.
     */
    public function getCurrentPeriodDates(): array
    {
        $now = Carbon::now();
        
        return match ($this->period) {
            'weekly' => [
                'start' => $now->copy()->startOfWeek(),
                'end' => $now->copy()->endOfWeek(),
            ],
            'monthly' => [
                'start' => $now->copy()->startOfMonth(),
                'end' => $now->copy()->endOfMonth(),
            ],
            'yearly' => [
                'start' => $now->copy()->startOfYear(),
                'end' => $now->copy()->endOfYear(),
            ],
            default => [
                'start' => $now->copy()->startOfMonth(),
                'end' => $now->copy()->endOfMonth(),
            ],
        };
    }

    /**
     * Get total spent in current period for this budget's category.
     */
    public function getSpentAmountAttribute(): float
    {
        $dates = $this->getCurrentPeriodDates();
        
        return Transaction::where('store_id', $this->store_id)
            ->where('account_id', $this->account_id)
            ->where('type', 'expense')
            ->whereBetween('transaction_date', [$dates['start'], $dates['end']])
            ->sum('amount');
    }

    /**
     * Get remaining budget.
     */
    public function getRemainingAmountAttribute(): float
    {
        return max(0, $this->amount - $this->spent_amount);
    }

    /**
     * Get percentage of budget used.
     */
    public function getUsagePercentageAttribute(): float
    {
        if ($this->amount <= 0) {
            return 0;
        }
        
        return min(100, round(($this->spent_amount / $this->amount) * 100, 1));
    }

    /**
     * Check if budget alert threshold is reached.
     */
    public function getIsAlertTriggeredAttribute(): bool
    {
        return $this->usage_percentage >= $this->alert_threshold;
    }

    /**
     * Check if budget is exceeded.
     */
    public function getIsExceededAttribute(): bool
    {
        return $this->spent_amount > $this->amount;
    }

    /**
     * Get alert status: 'normal', 'warning', 'danger'.
     */
    public function getAlertStatusAttribute(): string
    {
        if ($this->is_exceeded) {
            return 'danger';
        }
        
        if ($this->is_alert_triggered) {
            return 'warning';
        }
        
        return 'normal';
    }

    /**
     * Get period label in Indonesian.
     */
    public function getPeriodLabelAttribute(): string
    {
        return match ($this->period) {
            'weekly' => 'Mingguan',
            'monthly' => 'Bulanan',
            'yearly' => 'Tahunan',
            default => $this->period,
        };
    }

    /**
     * Scope for active budgets.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope for budgets with triggered alerts.
     */
    public function scopeWithTriggeredAlerts($query)
    {
        return $query->active()->get()->filter(fn($budget) => $budget->is_alert_triggered);
    }
}
