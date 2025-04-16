<?php

namespace Modules\AdminRoleAuthModule\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use YlsIdeas\FeatureFlags\Facades\Features;

class CheckFeatureFlags
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next, ...$features)
    {
        foreach ($features as $feature) {
            if (Features::accessible($feature)) {
                return $next($request);
            }
        }

        abort(403, __("Access is not authorized"));
    }
}
