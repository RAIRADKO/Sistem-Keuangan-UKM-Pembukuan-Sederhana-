<?php

namespace App\Http\Controllers;

use App\Models\Budget;
use App\Models\Account;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BudgetController extends Controller
{
    /**
     * Get the current store from session.
     */
    protected function getCurrentStore()
    {
        $storeId = session('current_store_id');
        return Auth::user()->stores()->findOrFail($storeId);
    }

    /**
     * Display a listing of the budgets.
     */
    public function index()
    {
        $store = $this->getCurrentStore();
        
        $budgets = Budget::where('store_id', $store->id)
            ->with('account')
            ->orderBy('name')
            ->get();

        // Get budgets with triggered alerts
        $alertedBudgets = $budgets->filter(fn($b) => $b->is_alert_triggered);

        return view('budgets.index', compact('store', 'budgets', 'alertedBudgets'));
    }

    /**
     * Show the form for creating a new budget.
     */
    public function create()
    {
        $store = $this->getCurrentStore();
        
        // Get expense accounts for budget categories
        $accounts = Account::where('store_id', $store->id)
            ->where('type', 'expense')
            ->orderBy('name')
            ->get();

        return view('budgets.create', compact('store', 'accounts'));
    }

    /**
     * Store a newly created budget in storage.
     */
    public function store(Request $request)
    {
        $store = $this->getCurrentStore();

        $validated = $request->validate([
            'account_id' => 'required|exists:accounts,id',
            'name' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0',
            'period' => 'required|in:weekly,monthly,yearly',
            'alert_threshold' => 'required|integer|min:1|max:100',
            'notes' => 'nullable|string',
        ]);

        // Check if budget for this account+period already exists
        $exists = Budget::where('store_id', $store->id)
            ->where('account_id', $validated['account_id'])
            ->where('period', $validated['period'])
            ->exists();

        if ($exists) {
            return back()->withErrors(['account_id' => 'Budget untuk kategori dan periode ini sudah ada.'])->withInput();
        }

        $validated['store_id'] = $store->id;
        $validated['is_active'] = true;

        Budget::create($validated);

        return redirect()->route('budgets.index')
            ->with('success', 'Budget berhasil dibuat.');
    }

    /**
     * Show the form for editing the specified budget.
     */
    public function edit(Budget $budget)
    {
        $store = $this->getCurrentStore();
        
        if ($budget->store_id !== $store->id) {
            abort(403);
        }

        $accounts = Account::where('store_id', $store->id)
            ->where('type', 'expense')
            ->orderBy('name')
            ->get();

        return view('budgets.edit', compact('store', 'budget', 'accounts'));
    }

    /**
     * Update the specified budget in storage.
     */
    public function update(Request $request, Budget $budget)
    {
        $store = $this->getCurrentStore();
        
        if ($budget->store_id !== $store->id) {
            abort(403);
        }

        $validated = $request->validate([
            'account_id' => 'required|exists:accounts,id',
            'name' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0',
            'period' => 'required|in:weekly,monthly,yearly',
            'alert_threshold' => 'required|integer|min:1|max:100',
            'is_active' => 'boolean',
            'notes' => 'nullable|string',
        ]);

        // Check if budget for this account+period already exists (excluding current)
        $exists = Budget::where('store_id', $store->id)
            ->where('account_id', $validated['account_id'])
            ->where('period', $validated['period'])
            ->where('id', '!=', $budget->id)
            ->exists();

        if ($exists) {
            return back()->withErrors(['account_id' => 'Budget untuk kategori dan periode ini sudah ada.'])->withInput();
        }

        $validated['is_active'] = $request->boolean('is_active');

        $budget->update($validated);

        return redirect()->route('budgets.index')
            ->with('success', 'Budget berhasil diperbarui.');
    }

    /**
     * Remove the specified budget from storage.
     */
    public function destroy(Budget $budget)
    {
        $store = $this->getCurrentStore();
        
        if ($budget->store_id !== $store->id) {
            abort(403);
        }

        $budget->delete();

        return redirect()->route('budgets.index')
            ->with('success', 'Budget berhasil dihapus.');
    }

    /**
     * Get budget alerts for dashboard widget.
     */
    public static function getBudgetAlerts($storeId): array
    {
        $budgets = Budget::where('store_id', $storeId)
            ->active()
            ->with('account')
            ->get();

        $alerts = [];
        foreach ($budgets as $budget) {
            if ($budget->is_alert_triggered) {
                $alerts[] = [
                    'budget' => $budget,
                    'status' => $budget->alert_status,
                    'percentage' => $budget->usage_percentage,
                    'spent' => $budget->spent_amount,
                    'limit' => $budget->amount,
                    'remaining' => $budget->remaining_amount,
                ];
            }
        }

        return $alerts;
    }
}
