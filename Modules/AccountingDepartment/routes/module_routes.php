<?php

use Illuminate\Support\Facades\Route;
use Modules\AccountingDepartment\Http\Controllers\EntryController;
use Modules\AccountingDepartment\Http\Controllers\ChartOfAccountController;
use Modules\AccountingDepartment\Http\Controllers\AccountingDepartmentController;
use Modules\AccountingDepartment\Http\Controllers\RevenuesExpensesController;

Route::prefix('admin/accounting-department')->group(function () {
    Route::get('entries/master', function () {
        return view('accounting-department::entries.master');
    })->name('entries.master');

    Route::get('master', function () {
        return view('accounting-department::master');
    })->name('master');

    Route::resource('entries', EntryController::class);
    Route::get('account-movement', [EntryController::class, 'accountMovement'])->name('account.movement');

    // Custom account routes must come before the resource route
    Route::get('accounts/balances', [ChartOfAccountController::class, 'balances'])->name('accounts.balances');
    Route::get('accounts/statement/{account}', [ChartOfAccountController::class, 'statement'])->name('accounts.statement');
    Route::get('accounts/print/{account}', [ChartOfAccountController::class, 'print'])->name('accounts.print');

    // New routes for financial balance and cost centers report
    Route::get('financial-balance', [AccountingDepartmentController::class, 'financialBalance'])->name('financial.balance');
    Route::get('cost-centers-report', [AccountingDepartmentController::class, 'costCentersReport'])->name('cost.centers.report');

    // New route for revenues and expenses
    Route::get('revenues-expenses', [RevenuesExpensesController::class, 'index'])->name('revenues.expenses');

    Route::get('trial-balance', [AccountingDepartmentController::class, 'trialBalance'])->name('trial.balance');

    // Resource route comes last
    Route::resource('accounts', ChartOfAccountController::class);
});