<?php

namespace Modules\AdminRoleAuthModule\Providers;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\App;
use Modules\AdminRoleAuthModule\RepositoryInterface\SettingsRepositoryInterface;

class MailConfigServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        if (app()->runningInConsole()) return;
        
        $mailSettings = Cache::rememberForever('mail_settings', function () {
            $mail = App::make(SettingsRepositoryInterface::class)->getSettingsByKey('smtp_settings');
            if ($mail) {
                return $mail->getProcessedValue();
            }
            return [];
        });
        if ($mailSettings)
        {
            if(count(array_filter($mailSettings)) == count($mailSettings)) {
                $config = array(
                    'driver'     => 'smtp',
                    'host'       => $mailSettings['mail_host'],
                    'port'       => $mailSettings['mail_port'],
                    'from'       => array('address' => $mailSettings['mail_useremail'], 'name' => $mailSettings['mail_useremail']),
                    'stream' => [
                        'ssl' => [
                            'allow_self_signed' => true,
                            'verify_peer' => false,
                            'verify_peer_name' => false,
                        ],
                    ],
                    'encryption' => $mailSettings['mail_encryption'],
                    'username'   => $mailSettings['mail_useremail'],
                    'password'   => $mailSettings['mail_password'] ? decrypt($mailSettings['mail_password']) : null,
                    'sendmail'   => '/usr/sbin/sendmail -bs',
                    'pretend'    => false,
                );
                Config::set('mail', $config);
            } 
        }
    }
}