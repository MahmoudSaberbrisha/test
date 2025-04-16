<?php
namespace Modules\AdminRoleAuthModule\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\AdminRoleAuthModule\Models\Language;
use Modules\AdminRoleAuthModule\Models\LanguageTranslation;
use DB;
use Storage;
use Config;

class LanguagesSeeder extends Seeder
{
    public function run()
    { 
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Language::truncate();
        LanguageTranslation::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        Config::set('filesystems.disks.local', array(
            'driver' => 'local',
            'url' => env('APP_URL') . 'seed_images/' ,
            'root' => public_path('seed_images/')
        ));
        $disk = Storage::disk('public');
        $disk2 = Storage::disk('local');

        $language_images = ['lang-ar.png', 'lang-en.png'];

        foreach ($language_images as $key => $image) {
            if ( $disk2->exists('/'.$image) ) {
                if ( $disk->exists('/languages/'.$image) ) {
                    $disk->delete('/languages/'.$image);
                }
                $disk->writeStream( '/languages/'.$image, $disk2->readStream('/'.$image) );
            }
        }
        
        Language::updateOrCreate([
            'id' => 1
        ],
        [
            'code' => 'en',
            'rtl' => 0,
            'default' => 0,
            'active' => 1,
            'image' => 'languages/lang-en.png',
            'en' => [
                'name' => 'English',
            ],
            'ar' => [
                'name' => 'الانجليزية',
            ]
        ]);

        Language::updateOrCreate([
            'id' => 2
        ],
        [
            'code' => 'ar',
            'rtl' => 1,
            'default' => 1,
            'active' => 1,
            'image' => 'languages/lang-ar.png',
            'en' => [
                'name' => 'Arabic',
            ],
            'ar' => [
                'name' => 'العربية',
            ]
        ]);
    }
}
