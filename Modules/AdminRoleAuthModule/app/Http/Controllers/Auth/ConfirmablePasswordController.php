<?php

namespace Modules\AdminRoleAuthModule\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Modules\AdminRoleAuthModule\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;
use Modules\AdminRoleAuthModule\Http\Requests\Auth\ConfirmablePasswordRequest;

class ConfirmablePasswordController extends Controller
{
    /**
     * Show the confirm password view.
     */
    public function show(Request $request): View
    {
        if (request()->segment(count(request()->segments())) != 'confirm-password')
            $request->session()->put('url.intended', \URL::previous());
        $request->session()->put('auth.password_confirmed_at', 0);

        return view('adminroleauthmodule::auth.confirm-password');
    }

    /**
     * Confirm the user's password.
     */
    public function store(ConfirmablePasswordRequest $request): RedirectResponse
    {
        $guard = auth()->getDefaultDriver();
        
        if (! Auth::guard($guard)->validate([
            'user_name' => $request->user()->user_name,
            'password' => $request->password,
        ])) {
            throw ValidationException::withMessages([
                'password' => __('auth.password'),
            ]);
        }

        $request->session()->put('auth.password_confirmed_at', time() + 10800);

        $previousUrl = $request->session()->get('url.intended')??'/'.$guard.'/dashboard';

        $request->session()->forget('url.intended');

        toastr()->success(__('Welcome back!'));

        return redirect()->intended($previousUrl);
    }
}
