<?php

namespace Modules\AdminRoleAuthModule\ViewComposers;

use Illuminate\View\View;
use YlsIdeas\FeatureFlags\Contracts\Features;
use Modules\AdminRoleAuthModule\RepositoryInterface\SettingsRepositoryInterface as GeneralInterface;
use Illuminate\Support\Facades\Cache;

class SettingsComposer
{
    /**
     * Create a movie composer.
     *
     * @return void
     */
    public function __construct(protected GeneralInterface $settingsRepository)
    {
        
    }

    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $allSettings = $this->settingsRepository->getGeneralSettings();
        $settings = Cache::rememberForever('settings', function () use ($allSettings) {
            return $allSettings ?: [];
        });
        $view->with('settings', $settings ?: []);
    }
}
