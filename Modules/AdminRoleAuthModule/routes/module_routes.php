<?php
use Illuminate\Support\Facades\Route;
use Modules\AdminRoleAuthModule\Http\Controllers\AdminsController;
use Modules\AdminRoleAuthModule\Http\Controllers\RolesController;
use Modules\AdminRoleAuthModule\Http\Controllers\Settings\LanguagesController;
use Modules\AdminRoleAuthModule\Http\Controllers\Settings\GeneralSettingsController;
use Modules\AdminRoleAuthModule\Http\Controllers\Settings\SmtpSettingsController;
use Modules\AdminRoleAuthModule\Http\Controllers\Settings\FirebaseSettingsController;
use Modules\AdminRoleAuthModule\Http\Controllers\Settings\FileManagerController;
use Modules\AdminRoleAuthModule\Http\Controllers\Settings\RegionController;
use Modules\AdminRoleAuthModule\Http\Controllers\Settings\BranchController;
use Modules\AdminRoleAuthModule\Http\Controllers\Settings\TypeController;
use Modules\AdminRoleAuthModule\Http\Controllers\Settings\CurrencyController;

Route::prefix('users')->group(function () {
    //Admins
    Route::resource('admins', AdminsController::class);
    Route::post('changeActive', [AdminsController::class, 'changeActive'])->name('admin-active');
    Route::post('updateAccount', [AdminsController::class, 'updateAccount'])->name('update-account');
    Route::post('updatePassword', [AdminsController::class, 'updatePassword'])->name('update-password');

    //Roles
    Route::resource('roles', RolesController::class);
});

//Settings
Route::prefix('settings')->group(function () {
    //General Settings
    Route::resource('general-settings', GeneralSettingsController::class)->only(['index', 'update']);
    //SMTP Settings
    Route::group(['middleware' => 'feature:smtp-feature'], function () {
        Route::resource('smtp-settings', SmtpSettingsController::class);
        Route::post('send-test-email', [SmtpSettingsController::class, 'sendTestEmail'])->name('sendTestEmail');
    });
    //Firebase Settings
    Route::group(['middleware' => 'feature:firebase-feature'], function () {
        Route::resource('firebase-settings', FirebaseSettingsController::class);
    });
    //Language Settings
    Route::group(['middleware' => 'feature:languages-feature'], function () {
        Route::resource('languages', LanguagesController::class)->except(['create', 'edit', 'show']);
        Route::post('languages/changeActive', [LanguagesController::class, 'changeActive'])->name('language-active');
        Route::post('languages/changeRtl', [LanguagesController::class, 'changeRtl'])->name('language-rtl');
    });
    //Regions Settings
    Route::group(['middleware' => 'feature:regions-branches-feature'], function () {
        Route::resource('regions', RegionController::class)->except(['create', 'edit', 'show']);
        Route::post('regions/changeActive', [RegionController::class, 'changeActive'])->name('region-active');
    });
    //Branches Settings
    Route::group(['middleware' => 'feature.flags:regions-branches-feature,branches-feature'], function () {
        Route::resource('branches', BranchController::class)->except(['create', 'edit', 'show']);
        Route::post('branches/changeActive', [BranchController::class, 'changeActive'])->name('branch-active');
    });
    //Currencies Settings
    Route::group(['middleware' => 'feature:currencies-feature'], function () {
        Route::resource('currencies', CurrencyController::class)->except(['create', 'edit', 'show']);
        Route::post('currencies/changeActive', [CurrencyController::class, 'changeActive'])->name('currency-active');
    });
});
//File Manager
Route::resource('file-manager', FileManagerController::class)->middleware('feature:file-manager-feature');

Route::prefix('services-management')->group(function () {
    //Types Settings
    Route::group(['middleware' => 'feature:types-feature'], function () {
        Route::resource('types', TypeController::class)->except(['create', 'edit', 'show']);
        Route::post('types/changeActive', [TypeController::class, 'changeActive'])->name('type-active');
    });
});