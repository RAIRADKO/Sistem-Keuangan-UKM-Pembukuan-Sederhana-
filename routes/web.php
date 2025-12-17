<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\BudgetController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DebtController;
use App\Http\Controllers\PosController;
use App\Http\Controllers\ProductCategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\StoreController;
use App\Http\Controllers\StoreTeamController;
use App\Http\Controllers\TransactionController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::middleware(['auth', 'verified'])->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Store Management
    Route::get('/stores/select', [StoreController::class, 'select'])->name('stores.select');
    Route::get('/stores/join', [StoreController::class, 'showJoinForm'])->name('stores.join');
    Route::post('/stores/join', [StoreController::class, 'join'])->name('stores.join.store');
    Route::resource('stores', StoreController::class);
    Route::post('/stores/{store}/switch', [StoreController::class, 'switch'])->name('stores.switch');
    Route::post('/stores/{store}/regenerate-code', [StoreController::class, 'regenerateInviteCode'])->name('stores.regenerate-code');

    // Store Team Management
    Route::prefix('stores/{store}/team')->name('stores.team.')->group(function () {
        Route::get('/', [StoreTeamController::class, 'index'])->name('index');
        Route::get('/invite', [StoreTeamController::class, 'create'])->name('create');
        Route::post('/invite', [StoreTeamController::class, 'invite'])->name('invite');
        Route::patch('/{user}/role', [StoreTeamController::class, 'updateRole'])->name('update-role');
        Route::delete('/{user}', [StoreTeamController::class, 'remove'])->name('remove');
        Route::post('/transfer-ownership', [StoreTeamController::class, 'transferOwnership'])->name('transfer-ownership');
        Route::post('/leave', [StoreTeamController::class, 'leave'])->name('leave');
    });

    // Account Management
    Route::resource('accounts', AccountController::class);

    // Transaction Management
    Route::resource('transactions', TransactionController::class);

    // Budget Management
    Route::resource('budgets', BudgetController::class)->except(['show']);

    // POS Mode (Kasir)
    Route::get('/pos', [PosController::class, 'index'])->name('pos.index');
    Route::post('/pos/checkout', [PosController::class, 'checkout'])->name('pos.checkout');
    Route::get('/pos/products', [PosController::class, 'getProducts'])->name('pos.products');

    // Contact Management (Supplier & Customer)
    Route::resource('contacts', ContactController::class);

    // Debt Management (Hutang & Piutang)
    Route::resource('debts', DebtController::class);
    Route::get('/debts/{debt}/payment', [DebtController::class, 'showPaymentForm'])->name('debts.payment.form');
    Route::post('/debts/{debt}/payment', [DebtController::class, 'recordPayment'])->name('debts.payment.store');

    // Product Category Management
    Route::resource('product-categories', ProductCategoryController::class)->except(['show']);

    // Product Management
    Route::resource('products', ProductController::class);
    Route::get('/products/{product}/adjust-stock', [ProductController::class, 'showAdjustStockForm'])->name('products.adjust-stock.form');
    Route::post('/products/{product}/adjust-stock', [ProductController::class, 'adjustStock'])->name('products.adjust-stock');

    // Reports
    Route::prefix('reports')->name('reports.')->group(function () {
        Route::get('/income', [ReportController::class, 'income'])->name('income');
        Route::get('/expense', [ReportController::class, 'expense'])->name('expense');
        Route::get('/profit-loss', [ReportController::class, 'profitLoss'])->name('profit-loss');
        Route::get('/cashflow', [ReportController::class, 'cashflow'])->name('cashflow');
        Route::get('/debts', [ReportController::class, 'debtsReport'])->name('debts');
        Route::get('/stock', [ReportController::class, 'stockReport'])->name('stock');
        Route::get('/product-profit', [ReportController::class, 'productProfit'])->name('product-profit');
        Route::get('/export/{type}/{format}', [ReportController::class, 'export'])->name('export');
    });

    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';


