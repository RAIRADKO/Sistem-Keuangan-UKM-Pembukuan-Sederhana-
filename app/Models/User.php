<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Get stores associated with this user
     */
    public function stores(): BelongsToMany
    {
        return $this->belongsToMany(Store::class, 'store_user')
            ->withPivot('role')
            ->withTimestamps();
    }

    /**
     * Get transactions created by this user
     */
    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class);
    }

    /**
     * Get stores where user is owner
     */
    public function ownedStores(): BelongsToMany
    {
        return $this->belongsToMany(Store::class, 'store_user')
            ->wherePivot('role', 'owner')
            ->withTimestamps();
    }

    /**
     * Check if user is owner of a specific store
     */
    public function isOwnerOf(Store $store): bool
    {
        return $this->stores()
            ->wherePivot('store_id', $store->id)
            ->wherePivot('role', 'owner')
            ->exists();
    }

    /**
     * Get the current active store from session
     */
    public function currentStore(): ?Store
    {
        $storeId = session('current_store_id');
        if ($storeId) {
            return $this->stores()->find($storeId);
        }
        return $this->stores()->first();
    }

    /**
     * Check if user is manager of a specific store
     */
    public function isManagerOf(Store $store): bool
    {
        return $this->stores()
            ->wherePivot('store_id', $store->id)
            ->wherePivot('role', 'manager')
            ->exists();
    }

    /**
     * Check if user is kasir of a specific store
     */
    public function isKasirOf(Store $store): bool
    {
        return $this->stores()
            ->wherePivot('store_id', $store->id)
            ->wherePivot('role', 'kasir')
            ->exists();
    }

    /**
     * Get user's role in a specific store
     */
    public function getRoleIn(Store $store): ?string
    {
        $pivot = $this->stores()->where('store_id', $store->id)->first();
        return $pivot ? $pivot->pivot->role : null;
    }

    /**
     * Check if user has permission in current store context
     * Permissions are role-based:
     * - owner: all permissions
     * - manager: most permissions except team management
     * - kasir: limited to transactions only
     */
    public function hasStorePermission(string $permission, ?Store $store = null): bool
    {
        $store = $store ?? $this->currentStore();
        
        if (!$store) {
            return false;
        }

        $role = $this->getRoleIn($store);
        
        if (!$role) {
            return false;
        }

        // Owner has all permissions
        if ($role === 'owner') {
            return true;
        }

        // Define permissions per role
        $rolePermissions = [
            'manager' => [
                'transactions.view',
                'transactions.create',
                'transactions.edit',
                'reports.income',
                'reports.expense',
                'reports.profit-loss',
                'reports.cashflow',
                'reports.debts',
                'reports.stock',
                'reports.product-profit',
                'debts.view',
                'debts.create',
                'debts.edit',
                'debts.payment',
                'products.view',
                'products.create',
                'products.edit',
                'products.adjust-stock',
                'contacts.view',
                'contacts.create',
                'contacts.edit',
                'accounts.view',
            ],
            'kasir' => [
                'transactions.view',
                'transactions.create',
                'reports.income',
                'reports.expense',
                'debts.view',
                'debts.payment',
                'products.view',
                'contacts.view',
                'accounts.view',
            ],
        ];

        return in_array($permission, $rolePermissions[$role] ?? []);
    }

    /**
     * Check if user can delete transactions
     */
    public function canDeleteTransactions(?Store $store = null): bool
    {
        $store = $store ?? $this->currentStore();
        return $store && $this->isOwnerOf($store);
    }

    /**
     * Check if user can view profit/loss reports
     */
    public function canViewProfitLoss(?Store $store = null): bool
    {
        $store = $store ?? $this->currentStore();
        if (!$store) return false;
        
        $role = $this->getRoleIn($store);
        return in_array($role, ['owner', 'manager']);
    }

    /**
     * Check if user can manage team
     */
    public function canManageTeam(?Store $store = null): bool
    {
        $store = $store ?? $this->currentStore();
        return $store && $this->isOwnerOf($store);
    }
}
