<?php

namespace Modules\AdminRoleAuthModule\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\AdminRoleAuthModule\RepositoryInterface\SettingsRepositoryInterface as GeneralInterface;
use Modules\AdminRoleAuthModule\Http\Requests\GeneralSettingsRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class GeneralSettingsController extends Controller implements HasMiddleware
{
    protected $generalRepository;

    public static function middleware(): array
    {
        return [
            new Middleware('permission:View Site Settings', only: ['index']),
            new Middleware('permission:Edit Site Settings', only: ['update']),
        ];
    }

    public function __construct(GeneralInterface $generalRepository)
    {
        $this->generalRepository = $generalRepository;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $settings = $this->generalRepository->getGeneralSettings();
        return view('adminroleauthmodule::settings.general-settings.index', compact('settings'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(GeneralSettingsRequest $request): RedirectResponse
    {
        try {
            DB::beginTransaction();
            $this->generalRepository->updateGeneralSettings($request->validated());
            DB::commit();
            Cache::forget('settings');
            toastr()->success(__('Record successfully updated.'));  
        } catch (\Exception $e) {
            //dd($e->getMessage());
            DB::rollBack();
            toastr()->error(__('Something went wrong.'));  
        }
        return redirect()->back();
    }

}
