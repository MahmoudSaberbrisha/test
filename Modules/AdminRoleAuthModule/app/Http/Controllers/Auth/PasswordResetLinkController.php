<?php

namespace Modules\AdminRoleAuthModule\Http\Controllers\Auth;

use Modules\AdminRoleAuthModule\Http\Requests\Auth\ResetPasswordRequest;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\View\View;
use DB;
use YlsIdeas\FeatureFlags\Facades\Features;

class PasswordResetLinkController extends Controller
{
    /**
     * Display the password reset link request view.
     */
    public function create(): View
    {
        if (Features::accessible('smtp-feature')) 
            return view('adminroleauthmodule::auth.forgot-password');
        if (Features::accessible('firebase-feature')) 
            return view('adminroleauthmodule::auth.firebase.forgot-password');
    }

    function emailSent()
    {
        $email = session()->get('sent-email');
        $found = DB::table('admin_password_reset_tokens')->where('email', $email)->exists();
        session()->forget('sent-email');
        if ($found) {
            return view('adminroleauthmodule::auth.email-sent', compact('email'));
        }
        return redirect()->route('admin.password.request');
    }

    public function broker($guard = null)
    {
        if ($guard) {
            return Password::broker($guard);
        }
        return Password::broker('admins');
    }

    /**
     * Handle an incoming password reset link request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(ResetPasswordRequest $request): RedirectResponse
    {        
        // We will send the password reset link to this user. Once we have attempted
        // to send the link, we will examine the response then see the message we
        // need to show to the user. Finally, we'll send out a proper response.

        try {
            $request->encreaseAttemptes();

            $email = $request->only('email')['email'];
            $guards = ['admins', 'students', 'teachers'];
            $status = null;
            $emailExists = false;

            foreach ($guards as $guard) {
                $status = $this->broker($guard)->sendResetLink(
                    ['email' => $email]
                );

                if ($status == Password::RESET_LINK_SENT) {
                    $emailExists = true;  
                    break; 
                }
            }

            if ($status == Password::RESET_THROTTLED) {
                $request->ensureNotManyAttemptes();
            }

            if ($emailExists) {
                session()->put('sent-email', $request->email);
                back()->withInput($request->only('email'));
            } else {
                toastr()->error(__('Failed to send email, please check if this email exists.'));
                return back()->withInput($request->only('email'))
                     ->withErrors(['email' => __('The email does not exist in our records.')]);
            }

            return $status == Password::RESET_LINK_SENT
                        ? redirect()->route('admin.email.sent')
                        : back()->withInput($request->only('email'))
                                ->withErrors(['email' => __($status)]);
        } catch (\Exception $e) {
            if (isset($status) && $status == 'passwords.throttled'){
                return back()->withInput($request->only('email'))->withErrors(['email' => __($e->getMessage())]);
            } else {
                toastr()->error(__('Failed to send email, please check if this email exists.'));
                return back()->withInput($request->only('email'));
            }
        }
    }

}
