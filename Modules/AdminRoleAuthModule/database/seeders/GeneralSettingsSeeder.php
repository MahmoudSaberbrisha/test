<?php
namespace Modules\AdminRoleAuthModule\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\AdminRoleAuthModule\Models\Setting;
use Modules\AdminRoleAuthModule\Models\SettingTranslation;
use Storage;
use Config;
use DB;

class GeneralSettingsSeeder extends Seeder
{
    public function run()
    { 
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Setting::truncate();
        SettingTranslation::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        Config::set('filesystems.disks.local', array(
            'driver' => 'local',
            'url' => env('APP_URL') . 'seed_images/' ,
            'root' => public_path('seed_images/')
        ));
        $disk = Storage::disk('public');
        $disk2 = Storage::disk('local');

        $images = array('site_logo' => 'logo.png', 'site_icon' => 'icon.png', 'site_background_image' => 'background.jpeg');

        foreach ($images as $key => $image) {
            $disk->exists('/logo/'.$image)?$disk->delete('/logo/'.$image):'';
            if ( $disk2->exists('/'.$image) ) {
                $disk->writeStream( '/logo/'.$image, $disk2->readStream(''.$image) );
                Setting::updateOrCreate([
                    'key'    => $key
                ],[
                    'key'    => $key,
                    'type'   => 'image',
                    'ar' => [
                        'value'    => 'logo/'.$image
                    ]
                ]);
            }
        }

        Setting::updateOrCreate([
            'key'    => 'site_name'
        ],[
            'key'    => 'site_name',
            'type'   => 'text',
            'ar' => [
                'value'    => 'شركة بوسيدون للأنشطة البحرية'
            ],
            'en' => [
                'value'    => 'Poseidon'
            ]
        ]);

        Setting::updateOrCreate([
            'key'    => 'site_keywords'
        ],[
            'key'    => 'site_keywords',
            'type'   => 'fixed',
            'ar' => [
                'value'    => 'Poseidon, snorkeling, swimming, sailing'
            ]
        ]);

        Setting::updateOrCreate([
            'key'    => 'site_description'
        ],[
            'key'    => 'site_description',
            'type'   => 'text',
            'ar' => [
                'value'    => 'في بوسيدون، لدينا شغف كبير لخلق لحظات لا تنسى، اعتدنا على تقديم السعادة لأكثر من 15 عامًا. رحلاتنا عبارة عن حزمة من المرح والهدوء والذكريات، فهل أنت مستعد؟ تبدأ رحلتنا البحرية بالإبحار في بحيرة مارينا مع مرشدنا السياحي الذي يقدم لنا كيف أصبحت مارينا واحدة من أجمل الوجهات المذهلة في مصر. هل أنت مستعد للسباحة؟ لقد حان وقتك للاستمتاع بمياه البحر الصافية ولكن ضع في اعتبارك أن سلامتك تأتي أولاً، لذلك ستكون تحت إشراف مرشد الغطس المحترف لدينا. ولإضافة المزيد من الإثارة والمتعة إلى الرحلة، فإن الرياضات المائية جاهزة لك مثل قارب الموز والأريكة والجيت سكي. يلي ذلك الرياضات المائية، يسعدنا أن نقدم لك بوفيه مفتوح أعده رئيس الطهاة لدينا. بعد تناول الغداء، نختتم المتعة وتنتهي الرحلة بسعادة.. كما ذكرنا، فإن المهمة الرئيسية لبوسيدون هي تقديم السعادة، لذلك نقدم العديد من المنتجات الفريدة على متن السفينة ونوفر مصورًا محترفًا لخدمتك. تتمنى لكم شركة بوسيدون إقامة طيبة في مصر ورحلة لا تنسى وتخبر بها الجميع. حافظوا على سلامتكم، ومرحبًا بكم دائمًا لزيارة مصر مرة أخرى.'
            ],
            'en' => [
                'value'    => 'In Poseidon we have a great passion to create joyful memorable moments, we used to deliver  happiness more than 15 years. Our trips are a bundle of fun, tranquility, and memories, So are you ready? Our sea cruise starts with sailing in Marina Lake with our tour guide introducing how Marina became one of the most beautiful and amazing destinations in Egypt. Are you ready for swimming? It’s your time to enjoy the crystal-clear seawater but keep in mind that your safety comes first, so you will be under the supervision of our professional snorkeling guide. Adding more spice and fun to the trip, water sports are ready for you such as Banana-boat, Sofa, and Jetski. Followed by water sport it’s our pleasure to serve you an open buffet prepared by our professional chef. After having lunch, we wrap up the enjoyment and the trip happily ends.. As mentioned Poseidon’s main mission is to deliver happiness, so we are serving many unique products aboard and we  provide  a professional photographer at  your service. Poseidon wishes you a  nice stay in Egypt and a trip to remember and tell everyone about. Stay safe and you’re always welcomed to visit Egypt again.'
            ]
        ]);
    }
}
