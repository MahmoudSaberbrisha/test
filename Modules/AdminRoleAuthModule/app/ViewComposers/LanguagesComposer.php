<?php

namespace Modules\AdminRoleAuthModule\ViewComposers;

use Illuminate\View\View;
use YlsIdeas\FeatureFlags\Contracts\Features;
use Modules\AdminRoleAuthModule\RepositoryInterface\LanguagesRepositoryInterface;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Session;

class LanguagesComposer
{
    /**
     * Create a movie composer.
     *
     * @return void
     */
    public function __construct(protected LanguagesRepositoryInterface $languagesRepository)
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
        $locale = app()->getLocale();
        $features = app(Features::class);
        if (!$features->accessible('languages-feature')) {
            $languages = [];
            $currentLanguage = [];
        } else {
            $activeLanguages = $this->languagesRepository->getActiveLanguages();
            $languages = Cache::rememberForever('languages', function () use ($activeLanguages) {
                return $activeLanguages ?: [];
            });
            $currentLanguage = $activeLanguages->where('code', $locale)->first();
            if (!$currentLanguage) {
                $currentLanguage = $activeLanguages->first();
                app()->setLocale($currentLanguage->code);
            }
        }
        $view->with('languages', $languages ?: []);
        $view->with('currentLanguage', $currentLanguage ?: []);
    }
}
