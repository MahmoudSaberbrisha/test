<?php

namespace Modules\AdminRoleAuthModule\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\AdminRoleAuthModule\Repositories\DBAdminsRepository;
use Modules\AdminRoleAuthModule\RepositoryInterface\RolesRepositoryInterface;
use Modules\AdminRoleAuthModule\Repositories\DBRolesRepository;
use Modules\AdminRoleAuthModule\RepositoryInterface\LanguagesRepositoryInterface;
use Modules\AdminRoleAuthModule\Repositories\DBLanguagesRepository;
use Modules\AdminRoleAuthModule\RepositoryInterface\SettingsRepositoryInterface;
use Modules\AdminRoleAuthModule\Repositories\DBSettingsRepository;
use Modules\AdminRoleAuthModule\Repositories\DBRegionsRepository;
use Modules\AdminRoleAuthModule\Repositories\DBBranchesRepository;
use Modules\AdminRoleAuthModule\Repositories\DBTypesRepository;
use Modules\AdminRoleAuthModule\RepositoryInterface\CurrencyRepositoryInterface;
use Modules\AdminRoleAuthModule\Repositories\DBCurrenciesRepository;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind('AdminCrudRepository', function($app) {
            return new DBAdminsRepository();
        });
        $this->app->bind(RolesRepositoryInterface::class, DBRolesRepository::class);
        $this->app->bind(LanguagesRepositoryInterface::class, DBLanguagesRepository::class);
        $this->app->bind(SettingsRepositoryInterface::class, DBSettingsRepository::class);
        $this->app->bind('RegionCrudRepository', function($app) {
            return new DBRegionsRepository();
        });
        $this->app->bind('BranchCrudRepository', function($app) {
            return new DBBranchesRepository();
        });
        $this->app->bind('TypeCrudRepository', function($app) {
            return new DBTypesRepository();
        });
        $this->app->bind(CurrencyRepositoryInterface::class, DBCurrenciesRepository::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
