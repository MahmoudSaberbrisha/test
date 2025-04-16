<?php

namespace Modules\AdminRoleAuthModule\Repositories;
use Modules\AdminRoleAuthModule\RepositoryInterface\LanguagesRepositoryInterface;
use Modules\AdminRoleAuthModule\Models\Language;
use Modules\AdminRoleAuthModule\Models\LanguageTranslation;
use App\Traits\ImageTrait;
use Cache;

class DBLanguagesRepository implements LanguagesRepositoryInterface
{
    use ImageTrait;

    public function getAll()
    {
        return Language::withTranslation()
            ->select(['id', 'image', 'active', 'rtl'])
            ->get();
    }

    public function create(array $request)
    {
        $locale = getDefaultLanguageCode();
        if ($request['default'] == 1) 
            Language::where('default', 1)->update(['default' => 0]);
        if (isset($request['image'])) 
            $request['image'] = $this->verifyAndUpload($request, 'image', 'languages');
        $data = [
            'code'    => $request['code'],
            'rtl'     => (int) $request['rtl'],
            'default' => (int) $request['default'],
            'image'   => $request['image'],
            $locale => [
                'name' => $request['name']
            ]
        ];
        return Language::create($data);
    }

    public function findById($id)
    {
        return Language::withTranslation()->findOrFail($id);
    }

    public function update(int $id, array $request)
    {
        $language = $this->findById($id);
        $image = $language->getRawOriginal('image');
        $defaultLanguage = $this->getDefaultLanguage();
        if(isset($request['image'])) {
            if ($language->getRawOriginal('image') != null)
                $this->deleteFile('languages/'.$language->getRawOriginal('image'));
            $image = $this->verifyAndUpload($request, 'image', 'languages');
        }
        if ($request['default'] == 1) 
            Language::where('id', '!=', $id)->update(['default' => 0]);
        if ($request['default'] == 0 && $defaultLanguage->id == $id)
            return false;

        $language->update([
            'rtl'     => (int) $request['rtl'],
            'default' => (int) $request['default'],
            'image'     => $image,
        ]);

        return LanguageTranslation::updateOrCreate([
            'language_id' => $id,
            'locale' => $request['locale'],
        ],
        [
            'name' => $request['name']
        ]);
    }

    public function delete(int $id)
    {
        $language = $this->findById($id);
        if ($language->default || $language->code == app()->getLocale())
            return false;
        if ($language->getRawOriginal('image') != null) 
            $this->deleteFile('languages/'.$language->getRawOriginal('image'));
        return $language->delete();
    }

    public function active(int $id, string $value)
    {
        $language = $this->findById($id);
        if (!$language)
            return response()->json( array('type' => 'error', 'text' => __('Something went wrong during the process.')) );
        if ($language->default || $language->code == app()->getLocale())
            return response()->json( array('type' => 'error', 'text' => __('You cannot deactivate the default or the current language.')) );
        $language->active = ($value == 'true') ? 1 : 0;
        $language->save();
        Cache::forget('languages');
        if ($value == 'true') 
            return response()->json( array('type' => 'success', 'text' => __('Record activated successfully.')) );
        return response()->json( array('type' => 'success', 'text' => __('Record deactivated successfully.')) );
    }

    public function changeRtl(int $id, string $value)
    {
        $language = $this->findById($id);
        if (!$language)
            return response()->json( array('type' => 'error', 'text' => __('Something went wrong during the process.')) );
        $language->rtl = ($value == 'true') ? 1 : 0;
        $language->save();
        Cache::forget('languages');
        if (app()->getLocale() == $language->code)
            session()->put('rtl', $language->rtl);
        return response()->json( array('type' => 'success', 'text' => __('RTL toggle successfully.')) );
    }

    public function getActiveLanguages()
    {
        return Language::withTranslation()
            ->where('active', 1)
            ->get();
    }

    public function getDefaultLanguage()
    {
        return Language::withTranslation()
            ->where('default', 1)
            ->first();
    }
}
