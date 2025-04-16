<?php

namespace Modules\AdminRoleAuthModule\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Modules\AdminRoleAuthModule\Http\Requests\Auth\NewPasswordRequest;
use Modules\AdminRoleAuthModule\Http\Requests\Auth\FirebasePasswordRequest;
use Modules\AdminRoleAuthModule\Models\Admin;

class NewPasswordController extends Controller
{
    /**
     * Display the password reset view.
     */
    public function create(Request $request): View
    {
        return view('adminroleauthmodule::auth.reset-password', ['request' => $request]);
    }

    public function broker($guard = null)
    {
        if ($guard) {
            return Password::broker($guard);
        }
        return Password::broker('admins');
    }

    /**
     * Handle an incoming new password request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(NewPasswordRequest $request): RedirectResponse
    {
        // Here we will attempt to reset the user's password. If it is successful we
        // will update the password on an actual user model and persist it to the
        // database. Otherwise we will parse the error and return the response.

        $admin = Admin::where('email', $request->email)->first();

        if ($admin) {
            if (Hash::check($request->password, $admin->password)) {
                return back()->withErrors(__('The new password must be different from the current password.'));
            }
        }

        $credentials = $request->only('email', 'password', 'password_confirmation', 'token');
        $guards = ['admins', 'students', 'teachers'];
        $status = null;

        foreach ($guards as $guard) {
            $status = $this->broker($guard)->reset(
                $credentials,
                function ($user) use ($request) {
                    $user->forceFill([
                        'password' => Hash::make($request->password),
                        'remember_token' => Str::random(60),
                    ])->save();
                    event(new PasswordReset($user));
                }
            );

            if ($status == Password::PASSWORD_RESET) {
                break;
            }
        }

        if ($status == Password::PASSWORD_RESET) {
            toastr()->success(__('Password reset successfully.'));
            return redirect()->route('admin.login')->with('status', __($status));
        } else {
            return back()->withInput($request->only('email'))
                         ->withErrors(['throttle' => __($status)]);
        }
    }

    public function firebaseResetPassword(FirebasePasswordRequest $request): RedirectResponse
    {
        $validate_request = $request->validated();
        $user = Admin::where('phone', $validate_request['phone'])->first();

        $user->forceFill([
            'password' => Hash::make($validate_request['password']),
            'remember_token' => Str::random(60),
        ])->save();

        toastr()->success(__('Password reset successfully.'));
        return redirect()->route('admin.login');

        $status = $this->broker()->reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user) use ($request) {
                $user->forceFill([
                    'password' => Hash::make($request->password),
                    'remember_token' => Str::random(60),
                ])->save();
                event(new PasswordReset($user));
            }
        );

        // If the password was successfully reset, we will redirect the user back to
        // the application's home authenticated view. If there is an error we can
        // redirect them back to where they came from with their error message.

        if ($status == Password::PASSWORD_RESET) {
            toastr()->success(__('Password reset successfully.'));
            return redirect()->route('admin.login')->with('status', __($status));
        } else {
            return back()->withInput($request->only('email'))
                ->withErrors(['throttle' => __($status)]);
        }
    }
}
