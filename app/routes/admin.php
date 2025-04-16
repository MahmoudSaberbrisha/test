<?php
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;

Route::group(['middleware' => ['auth:admin', 'password.confirm:admin.password.confirm,1', 'LocaleMiddleware']], function () {

    require __DIR__ . '/public_routes.php';
    
});
