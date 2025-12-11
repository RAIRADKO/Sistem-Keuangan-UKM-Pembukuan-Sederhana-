<?php

namespace App\Http\Controllers;

use App\Models\Account;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AccountController extends Controller
{
    /**
     * Display a listing of accounts
     */
    public function index(Request $request)
    {
        $store = Auth::user()->currentStore();

        if (!$store) {
            return redirect()->route('stores.create');
        }

        $type = $request->get('type');

        $accounts = Account::where('store_id', $store->id)
            ->when($type, fn($q) => $q->where('type', $type))
            ->withCount('transactions')
            ->orderBy('type')
            ->orderBy('name')
            ->get();

        return view('accounts.index', compact('accounts', 'store', 'type'));
    }

    /**
     * Show the form for creating a new account
     */
    public function create()
    {
        $store = Auth::user()->currentStore();

        if (!$store) {
            return redirect()->route('stores.create');
        }

        return view('accounts.create', compact('store'));
    }

    /**
     * Store a newly created account
     */
    public function store(Request $request)
    {
        $store = Auth::user()->currentStore();

        if (!$store) {
            return redirect()->route('stores.create');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:income,expense',
            'description' => 'nullable|string',
        ]);

        $validated['store_id'] = $store->id;

        Account::create($validated);

        return redirect()->route('accounts.index')
            ->with('success', 'Kategori akun berhasil dibuat!');
    }

    /**
     * Show the form for editing an account
     */
    public function edit(Account $account)
    {
        $this->authorizeAccount($account);
        $store = Auth::user()->currentStore();

        return view('accounts.edit', compact('account', 'store'));
    }

    /**
     * Update the specified account
     */
    public function update(Request $request, Account $account)
    {
        $this->authorizeAccount($account);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:income,expense',
            'description' => 'nullable|string',
        ]);

        $account->update($validated);

        return redirect()->route('accounts.index')
            ->with('success', 'Kategori akun berhasil diperbarui!');
    }

    /**
     * Remove the specified account
     */
    public function destroy(Account $account)
    {
        $this->authorizeAccount($account);

        // Check if account has transactions
        if ($account->transactions()->count() > 0) {
            return back()->with('error', 'Tidak dapat menghapus akun yang memiliki transaksi.');
        }

        $account->delete();

        return redirect()->route('accounts.index')
            ->with('success', 'Kategori akun berhasil dihapus!');
    }

    /**
     * Check if user has access to account's store
     */
    private function authorizeAccount(Account $account)
    {
        $store = Auth::user()->currentStore();

        if (!$store || $account->store_id !== $store->id) {
            abort(403, 'Anda tidak memiliki akses ke akun ini.');
        }
    }
}
