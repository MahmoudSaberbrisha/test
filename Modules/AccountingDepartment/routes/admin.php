<?php
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['auth:admin', 'password.confirm:admin.password.confirm,1', 'LocaleMiddleware']], function () {
    
    require __DIR__ . '/module_routes.php';
});
