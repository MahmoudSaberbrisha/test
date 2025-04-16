<?php

namespace Modules\AdminRoleAuthModule\RepositoryInterface;

interface SettingsRepositoryInterface {

    public function getGeneralSettings();

    public function getSettingsByKey(String $key);

    public function updateGeneralSettings(array $request);
    
    public function updateSmtpSettings(array $request);

    public function updateJsonTypeSettings(array $request, String $key);
}
