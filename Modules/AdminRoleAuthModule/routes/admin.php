<?php
use Illuminate\Support\Facades\Route;
use Modules\AdminRoleAuthModule\Http\Controllers\Settings\LanguagesController;

Route::get('locale/{locale}', [LanguagesController::class, 'switchLang'])->name('language-switch');

Route::group(['middleware' => ['auth:admin', 'password.confirm:admin.password.confirm,1', 'LocaleMiddleware']], function () {
    
    require __DIR__ . '/module_routes.php';
});

require __DIR__ . '/admin_auth.php';
