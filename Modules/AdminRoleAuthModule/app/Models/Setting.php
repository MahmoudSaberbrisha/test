<?php

namespace Modules\AdminRoleAuthModule\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Storage;

class Setting extends Model implements TranslatableContract
{
    use Translatable;

    /**
     * The attributes that are mass assignable.
     */
    protected $table = 'settings';

    public $translationModel = 'Modules\AdminRoleAuthModule\Models\SettingTranslation';

    public $translatedAttributes = ['value'];

    protected $fillable = array('key', 'type');

    public function getProcessedValue($locale = null)
    {
        $locale = $locale ?? app()->getLocale();
        $value = $this->translateOrDefault($locale);
        if ($value)
            $value = $value->value;
        else
            $value = $this->translations()->first()->value;
        switch ($this->type) {
            case 'image':
                return $value != null && Storage::disk('public')->exists($value) ? Storage::disk('public')->url($value) : @asset('') . 'assets/admin/images/no-image.jpg';
            case 'json':
                return json_decode($value, true);
            default:
                return $value;
        }
    }

    static function updateValueByType($settings, $request)
    {
        foreach ($settings as $key => $value) {
            if(isset($request[$key])) {
                switch ($value->type) {
                    case 'image':
                        if ($value->getRawOriginal('value') != null)
                            $this->deleteFile('logo/'.$value->getRawOriginal('value'));
                        $request[$key] = $request[$key]->store('logo', 'public');
                        Setting::updateOrCreate([
                            'key' => $key
                        ],[
                            'key' => $key,
                            'value' => $request[$key]
                        ]);
                    case 'fixed':
                        Setting::updateOrCreate([
                            'key' => $key
                        ],[
                            'key' => $key,
                            'value' => $request[$key]
                        ]);
                    case 'json':
                        Setting::updateOrCreate([
                            'key' => $key
                        ],[
                            'key' => $key,
                            'value' => json_encode($request[$key])
                        ]);
                    default:
                        Setting::updateOrCreate([
                            'key' => $key
                        ],[
                            'key' => $key,
                            $request['locale'] => [
                                'value' => $request[$key]
                            ]
                        ]);
                }
            }
        }
    }
}
