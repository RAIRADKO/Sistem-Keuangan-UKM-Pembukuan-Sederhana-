<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Transaction;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\TransactionsExport;

class ReportController extends Controller
{
    /**
     * Income report
     */
    public function income(Request $request)
    {
        $store = Auth::user()->currentStore();

        if (!$store) {
            return redirect()->route('stores.create');
        }

        $data = $this->getReportData($store, $request, 'income');

        return view('reports.income', $data);
    }

    /**
     * Expense report
     */
    public function expense(Request $request)
    {
        $store = Auth::user()->currentStore();

        if (!$store) {
            return redirect()->route('stores.create');
        }

        $data = $this->getReportData($store, $request, 'expense');

        return view('reports.expense', $data);
    }

    /**
     * Profit & Loss report
     */
    public function profitLoss(Request $request)
    {
        $store = Auth::user()->currentStore();

        if (!$store) {
            return redirect()->route('stores.create');
        }

        $startDate = $request->get('start_date', now()->startOfMonth()->format('Y-m-d'));
        $endDate = $request->get('end_date', now()->endOfMonth()->format('Y-m-d'));

        // Get income by category
        $incomeByCategory = Transaction::where('store_id', $store->id)
            ->where('type', 'income')
            ->whereBetween('transaction_date', [$startDate, $endDate])
            ->selectRaw('account_id, SUM(amount) as total')
            ->groupBy('account_id')
            ->with('account')
            ->get();

        // Get expense by category
        $expenseByCategory = Transaction::where('store_id', $store->id)
            ->where('type', 'expense')
            ->whereBetween('transaction_date', [$startDate, $endDate])
            ->selectRaw('account_id, SUM(amount) as total')
            ->groupBy('account_id')
            ->with('account')
            ->get();

        $totalIncome = $incomeByCategory->sum('total');
        $totalExpense = $expenseByCategory->sum('total');
        $netProfit = $totalIncome - $totalExpense;

        return view('reports.profit-loss', compact(
            'store',
            'startDate',
            'endDate',
            'incomeByCategory',
            'expenseByCategory',
            'totalIncome',
            'totalExpense',
            'netProfit'
        ));
    }

    /**
     * Cash flow report
     */
    public function cashflow(Request $request)
    {
        $store = Auth::user()->currentStore();

        if (!$store) {
            return redirect()->route('stores.create');
        }

        $startDate = $request->get('start_date', now()->startOfMonth()->format('Y-m-d'));
        $endDate = $request->get('end_date', now()->endOfMonth()->format('Y-m-d'));

        // Daily cash flow
        $dailyCashflow = Transaction::where('store_id', $store->id)
            ->whereBetween('transaction_date', [$startDate, $endDate])
            ->selectRaw('transaction_date, type, SUM(amount) as total')
            ->groupBy('transaction_date', 'type')
            ->orderBy('transaction_date')
            ->get()
            ->groupBy('transaction_date');

        // Calculate running balance
        $cashflowData = [];
        $runningBalance = 0;

        // Get previous balance
        $previousIncome = Transaction::where('store_id', $store->id)
            ->where('type', 'income')
            ->where('transaction_date', '<', $startDate)
            ->sum('amount');
        $previousExpense = Transaction::where('store_id', $store->id)
            ->where('type', 'expense')
            ->where('transaction_date', '<', $startDate)
            ->sum('amount');
        $runningBalance = $previousIncome - $previousExpense;

        $openingBalance = $runningBalance;

        foreach ($dailyCashflow as $date => $transactions) {
            $dayIncome = $transactions->where('type', 'income')->sum('total');
            $dayExpense = $transactions->where('type', 'expense')->sum('total');
            $runningBalance += ($dayIncome - $dayExpense);

            $cashflowData[] = [
                'date' => $date,
                'income' => $dayIncome,
                'expense' => $dayExpense,
                'balance' => $runningBalance,
            ];
        }

        $closingBalance = $runningBalance;

        return view('reports.cashflow', compact(
            'store',
            'startDate',
            'endDate',
            'cashflowData',
            'openingBalance',
            'closingBalance'
        ));
    }

    /**
     * Export report
     */
    public function export(Request $request, $type, $format)
    {
        $store = Auth::user()->currentStore();

        if (!$store) {
            return redirect()->route('stores.create');
        }

        $startDate = $request->get('start_date', now()->startOfMonth()->format('Y-m-d'));
        $endDate = $request->get('end_date', now()->endOfMonth()->format('Y-m-d'));

        $transactionType = null;
        if ($type === 'income' || $type === 'expense') {
            $transactionType = $type;
        }

        $transactions = Transaction::where('store_id', $store->id)
            ->when($transactionType, fn($q) => $q->where('type', $transactionType))
            ->whereBetween('transaction_date', [$startDate, $endDate])
            ->with(['account', 'user'])
            ->orderBy('transaction_date')
            ->get();

        $filename = "laporan_{$type}_{$startDate}_{$endDate}";

        if ($format === 'pdf') {
            $pdf = Pdf::loadView('reports.export-pdf', [
                'transactions' => $transactions,
                'store' => $store,
                'type' => $type,
                'startDate' => $startDate,
                'endDate' => $endDate,
            ]);

            return $pdf->download($filename . '.pdf');
        }

        if ($format === 'excel') {
            return Excel::download(
                new TransactionsExport($transactions, $store, $type, $startDate, $endDate),
                $filename . '.xlsx'
            );
        }

        abort(400, 'Format tidak didukung');
    }

    /**
     * Get report data based on type
     */
    private function getReportData($store, Request $request, $type)
    {
        $startDate = $request->get('start_date', now()->startOfMonth()->format('Y-m-d'));
        $endDate = $request->get('end_date', now()->endOfMonth()->format('Y-m-d'));
        $accountId = $request->get('account_id');

        $query = Transaction::where('store_id', $store->id)
            ->where('type', $type)
            ->whereBetween('transaction_date', [$startDate, $endDate])
            ->with(['account', 'user']);

        if ($accountId) {
            $query->where('account_id', $accountId);
        }

        $transactions = $query->orderBy('transaction_date', 'desc')->get();

        // Group by category
        $byCategory = $transactions->groupBy('account_id')->map(function ($items, $accountId) {
            return [
                'account' => $items->first()->account,
                'total' => $items->sum('amount'),
                'count' => $items->count(),
            ];
        })->values();

        $accounts = Account::where('store_id', $store->id)
            ->where('type', $type)
            ->get();

        $total = $transactions->sum('amount');

        return compact('store', 'transactions', 'byCategory', 'accounts', 'total', 'startDate', 'endDate', 'type');
    }
}
