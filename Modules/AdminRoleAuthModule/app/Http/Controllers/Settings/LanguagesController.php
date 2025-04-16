<?php

namespace Modules\AdminRoleAuthModule\Http\Controllers\Settings;

use Modules\AdminRoleAuthModule\RepositoryInterface\LanguagesRepositoryInterface;
use Modules\AdminRoleAuthModule\Http\Requests\LanguageRequest;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Cache;
use Illuminate\Http\RedirectResponse;
use DataTables;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class LanguagesController extends Controller implements HasMiddleware
{
    protected $languageRepository;

    public static function middleware(): array
    {
        return [
            new Middleware('permission:View Languages', only: ['index']),
            new Middleware('permission:Create Languages', only: ['store']),
            new Middleware('permission:Edit Languages', only: ['update', 'changeRTL', 'changeActive']),
            new Middleware('permission:Delete Languages', only: ['destroy']),
        ];
    }

    public function __construct(LanguagesRepositoryInterface $languageRepository)
    {
        $this->languageRepository = $languageRepository;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if( $request->ajax() ) {
            $languages = $this->languageRepository->getAll();
            return DataTables::of($languages)
                ->addColumn('actions', 'adminroleauthmodule::settings.languages.partials.actions')
                ->addColumn('active', 'adminroleauthmodule::settings.languages.partials.active')
                ->addColumn('rtl', 'adminroleauthmodule::settings.languages.partials.rtl')
                ->addColumn('image', 'adminroleauthmodule::settings.languages.partials.image')
                ->rawColumns(['actions', 'active', 'rtl', 'image'])
                ->make(true);
        }
        return view('adminroleauthmodule::settings.languages.index');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(LanguageRequest $request): RedirectResponse
    {
        try {
            $this->languageRepository->create($request->validated());
            Cache::forget('languages');
            toastr()->success(__('Record successfully created.'));
            
        } catch (\Exception $e) {
            //dd($e->getMessage());
            toastr()->error(__('Something went wrong.'));  
        }
        return redirect()->route(auth()->getDefaultDriver().'.languages.index');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(LanguageRequest $request, $language): RedirectResponse
    {
        try {
            $record = $this->languageRepository->update($language, $request->validated());
            if ($record) {
                Cache::forget('languages');
                toastr()->success(__('Record successfully updated.'));
            } else
                toastr()->error(__('Please choose another default language before changing this one.'));
        } catch (\Exception $e) {
            toastr()->error(__('Something went wrong.'));  
        }
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $return = $this->languageRepository->delete($id);
            if (!$return)
                toastr()->error(__('You cannot delete the default or the current language.'));
            else {
                Cache::forget('languages');
                toastr()->success(__('Record successfully deleted.'));
            }
        } catch (\Exception $e) {
            toastr()->error(__('Something went wrong.'));  
        }
        return redirect()->back();
    }

    public function changeActive(Request $request)
    {
        try {
            return $this->languageRepository->active($request->id, $request->value);
        } catch (\Exception $e) {
            return response()->json( array('type' => 'error', 'text' => __('Something went wrong.')) );
        }
    }

    public function changeRtl(Request $request)
    {
        try {
            return $this->languageRepository->changeRtl($request->id, $request->value);
        } catch (\Exception $e) {
            return response()->json( array('type' => 'error', 'text' => __('Something went wrong.')) );
        }
    }

    public function switchLang($lang)
    {
        Cache::forget('languages');
        Cache::forget('settings');
        $activeLanguages = $this->languageRepository->getActiveLanguages();
        $codes = $activeLanguages->pluck('code')->toArray();
        $currentLanguage = $activeLanguages->where('code', $lang)->first();
        if (in_array($lang, $codes)) {
            Session::put('locale', $lang);
        }
        session()->put('rtl', $currentLanguage->rtl??1);
        return redirect()->back();
    }
}
