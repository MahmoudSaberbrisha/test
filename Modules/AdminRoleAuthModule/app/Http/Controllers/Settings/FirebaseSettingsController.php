<?php

namespace Modules\AdminRoleAuthModule\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\AdminRoleAuthModule\RepositoryInterface\SettingsRepositoryInterface as FirebaseInterface;
use Modules\AdminRoleAuthModule\Http\Requests\FirebaseSettingsRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Contracts\View\View;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class FirebaseSettingsController extends Controller implements HasMiddleware
{
    protected $firebaseRepository;

    public static function middleware(): array
    {
        return [
            new Middleware('permission:View Firebase Settings', only: ['index']),
            new Middleware('permission:Edit Firebase Settings', only: ['update']),
        ];
    }

    public function __construct(FirebaseInterface $firebaseRepository)
    {
        $this->firebaseRepository = $firebaseRepository;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $settings = $this->firebaseRepository->getSettingsByKey('firebase_settings');
        if (!$settings) {
            $settings = [
                'api_key'    => '',
                'project_id' => '',
                'sender_id'  => '',
                'app_id'     => ''
            ];
            $settings = $this->firebaseRepository->updateJsonTypeSettings($settings, 'firebase_settings');
        }
        return view('adminroleauthmodule::settings.firebase-settings.index', compact('settings'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(FirebaseSettingsRequest $request): RedirectResponse
    {
        try {
            $this->firebaseRepository->updateJsonTypeSettings($request->validated(), 'firebase_settings');
            toastr()->success(__('Record successfully updated.'));  
        } catch (\Exception $e) {
            //dd($e->getMessage());
            toastr()->error(__('Something went wrong.'));  
        }
        return redirect()->back();
    }

}
