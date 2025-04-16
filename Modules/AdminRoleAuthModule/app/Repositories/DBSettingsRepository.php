<?php

namespace Modules\AdminRoleAuthModule\Repositories;
use Modules\AdminRoleAuthModule\RepositoryInterface\SettingsRepositoryInterface;
use Modules\AdminRoleAuthModule\Models\Setting;
use App\Traits\ImageTrait;

class DBSettingsRepository implements SettingsRepositoryInterface
{
    use ImageTrait;

    public function getGeneralSettings()
    {
        return Setting::withTranslation()
            ->where('key', 'LIKE', "site_%")
            ->get()
            ->keyBy('key');
    }

    public function getSettingsByKey($key)
    {
        return Setting::withTranslation()
            ->where('key', $key)
            ->first();
    }

    public function updateSmtpSettings(array $request)
    {
        $request['mail_password'] = $request['mail_password'] ? encrypt($request['mail_password']) : null;
        return Setting::updateOrCreate([
            'key' => 'smtp_settings'
        ],[
            'key' => 'smtp_settings',
            'type' => 'json', 
            'value' => json_encode($request)
        ]);
    }

    public function updateGeneralSettings(array $request)
    {
        $settings = $this->getGeneralSettings();
        return Setting::updateValueByType($settings, $request);
    }

    public function updateJsonTypeSettings(array $request, String $key)
    {
        return Setting::updateOrCreate([
            'key' => $key
        ],[
            'key' => $key,
            'type' => 'json', 
            'value' => json_encode($request)
        ]);
    }

}
