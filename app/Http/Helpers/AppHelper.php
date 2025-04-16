<?php

use Modules\AdminRoleAuthModule\RepositoryInterface\LanguagesRepositoryInterface;
use App\Models\AcademicYear;
use App\Models\PaymentSetting;
use Carbon\Carbon;

if (! function_exists('getDefaultLanguageCode')) {
    function getDefaultLanguageCode()
    {
        $languageRepository = app(LanguagesRepositoryInterface::class);
        $defaultLanguage = $languageRepository->getDefaultLanguage();
        if ($defaultLanguage) {
            return $defaultLanguage->code;
        }
        return session()->get('locale', 'ar');
    }
}

if (!function_exists('feature')) {
    function feature($feature)
    {
        return \YlsIdeas\FeatureFlags\Facades\Features::accessible($feature);
    }
}
