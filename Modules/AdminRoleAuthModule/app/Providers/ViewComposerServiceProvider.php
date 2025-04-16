<?php

namespace Modules\AdminRoleAuthModule\Providers;

use Illuminate\Support\ServiceProvider;

class ViewComposerServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     */
    public function register(): void
    {
        //
    }

    /**
     * Get the services provided by the provider.
     */
    public function provides(): array
    {
        return [];
    }

    public function boot()
    {
        view()->composer(
            'admin.partials.languages',
            'Modules\AdminRoleAuthModule\ViewComposers\LanguagesComposer'
        );

        view()->composer(
            ['admin.layouts.*', 'admin.partials.header', 'adminroleauthmodule::auth.*', 'admin.pages.*'],
            'Modules\AdminRoleAuthModule\ViewComposers\SettingsComposer'
        );
    }
}
