<?php

namespace Modules\AdminRoleAuthModule\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\AdminRoleAuthModule\RepositoryInterface\SettingsRepositoryInterface as SmtpInterface;
use Modules\AdminRoleAuthModule\Http\Requests\SmtpSettingsRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Mail;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class SmtpSettingsController extends Controller implements HasMiddleware
{
    protected $smtpRepository;

    public static function middleware(): array
    {
        return [
            new Middleware('permission:View SMTP Settings', only: ['index']),
            new Middleware('permission:Edit SMTP Settings', only: ['update']),
        ];
    }

    public function __construct(SmtpInterface $smtpRepository)
    {
        $this->smtpRepository = $smtpRepository;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $settings = $this->smtpRepository->getSettingsByKey('smtp_settings');
        if (!$settings) {
            $settings = [
                'mail_host'       => '',
                'mail_port'       => '',
                'mail_useremail'  => '',
                'mail_password'   => '',
                'mail_encryption' => ''
            ];
            $settings = $this->smtpRepository->updateSmtpSettings($settings);
        }
        return view('adminroleauthmodule::settings.smtp-settings.index', compact('settings'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SmtpSettingsRequest $request): RedirectResponse
    {
        try {
            $this->smtpRepository->updateSmtpSettings($request->validated());
            Cache::forget('mail_settings');
            toastr()->success(__('Record successfully updated.'));  
        } catch (\Exception $e) {
            //dd($e->getMessage());
            toastr()->error(__('Something went wrong.'));  
        }
        return redirect()->back();
    }

    public function sendTestEmail(SmtpSettingsRequest $request)
    {
        try {
            Mail::raw('This is SMTP Test Email Body', function ($message) use ($request) {
                $message->to($request->validated()['email'])
                ->subject('SMTP Test Email Subject');
            });
            toastr()->success(__('Email sent, please check your email.'));
        } catch (\Exception $e) {
            //$e->getMessage();
            toastr()->error(__('Something went wrong! please, try again.'));
        }
        return redirect()->back();
    }

}
