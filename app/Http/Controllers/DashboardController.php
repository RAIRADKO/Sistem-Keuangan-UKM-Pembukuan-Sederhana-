<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        $store = $user->currentStore();

        if (!$store) {
            return redirect()->route('stores.create')
                ->with('info', 'Silakan buat toko terlebih dahulu.');
        }

        // Current month data
        $currentMonth = now()->month;
        $currentYear = now()->year;

        // Total income this month
        $totalIncome = Transaction::where('store_id', $store->id)
            ->where('type', 'income')
            ->whereMonth('transaction_date', $currentMonth)
            ->whereYear('transaction_date', $currentYear)
            ->sum('amount');

        // Total expense this month
        $totalExpense = Transaction::where('store_id', $store->id)
            ->where('type', 'expense')
            ->whereMonth('transaction_date', $currentMonth)
            ->whereYear('transaction_date', $currentYear)
            ->sum('amount');

        // Net balance
        $balance = $totalIncome - $totalExpense;

        // Top expense categories
        $topExpenses = Transaction::where('store_id', $store->id)
            ->where('type', 'expense')
            ->whereMonth('transaction_date', $currentMonth)
            ->whereYear('transaction_date', $currentYear)
            ->select('account_id', DB::raw('SUM(amount) as total'))
            ->groupBy('account_id')
            ->with('account')
            ->orderByDesc('total')
            ->limit(5)
            ->get();

        // Monthly trend (last 6 months)
        $monthlyTrend = [];
        for ($i = 5; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $month = $date->month;
            $year = $date->year;

            $income = Transaction::where('store_id', $store->id)
                ->where('type', 'income')
                ->whereMonth('transaction_date', $month)
                ->whereYear('transaction_date', $year)
                ->sum('amount');

            $expense = Transaction::where('store_id', $store->id)
                ->where('type', 'expense')
                ->whereMonth('transaction_date', $month)
                ->whereYear('transaction_date', $year)
                ->sum('amount');

            $monthlyTrend[] = [
                'month' => $date->format('M Y'),
                'income' => $income,
                'expense' => $expense,
            ];
        }

        // Recent transactions
        $recentTransactions = Transaction::where('store_id', $store->id)
            ->with(['account', 'user'])
            ->orderByDesc('transaction_date')
            ->orderByDesc('created_at')
            ->limit(10)
            ->get();

        return view('dashboard', compact(
            'store',
            'totalIncome',
            'totalExpense',
            'balance',
            'topExpenses',
            'monthlyTrend',
            'recentTransactions'
        ));
    }
}
