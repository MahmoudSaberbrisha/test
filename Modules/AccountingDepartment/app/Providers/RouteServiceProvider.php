<?php

namespace Modules\AccountingDepartment\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Modules\AdminRoleAuthModule\Http\Middleware\CheckFeatureFlags;

class RouteServiceProvider extends ServiceProvider
{
    protected string $name = 'AccountingDepartment';
    public const HOME = '/';
    public const ADMIN_PREFIX = 'admin';
    public const ADMIN_HOME = '/' . self::ADMIN_PREFIX . '/dashboard';

    /**
     * Called before routes are registered.
     *
     * Register any model bindings or pattern based filters.
     */
    public function boot(): void
    {
        Route::aliasMiddleware('feature.flags', CheckFeatureFlags::class);

        $this->configureRateLimiting();

        $this->routes(function () {
            Route::middleware('web')
                ->prefix(self::ADMIN_PREFIX)
                ->name(self::ADMIN_PREFIX . '.')
                ->group(module_path($this->name, '/routes/admin.php'));
        });
    }

    /**
     * Configure the rate limiters for the application.
     */
    protected function configureRateLimiting(): void
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
        });
    }

    /**
     * Define the routes for the application.
     */
    public function map(): void
    {
        $this->mapApiRoutes();
        $this->mapWebRoutes();
    }

    /**
     * Define the "web" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     */
    protected function mapWebRoutes(): void
    {
        Route::middleware('web')->group(module_path($this->name, '/routes/web.php'));
    }

    /**
     * Define the "api" routes for the application.
     *
     * These routes are typically stateless.
     */
    protected function mapApiRoutes(): void
    {
        Route::middleware('api')->prefix('api')->name('api.')->group(module_path($this->name, '/routes/api.php'));
    }
}
