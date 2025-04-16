<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Request as FacadesRequest;
use Modules\AdminRoleAuthModule\Providers\RouteServiceProvider;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    protected function redirectTo(Request $request): ?string
    {
        return $request->expectsJson() ? null : (FacadesRequest::segment(1) == RouteServiceProvider::ADMIN_PREFIX ? route('admin.login') : route('admin.login'));
    }
}
