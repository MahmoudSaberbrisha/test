<?php

namespace Modules\AdminRoleAuthModule\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Modules\AdminRoleAuthModule\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Illuminate\Support\Facades\RateLimiter;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('adminroleauthmodule::auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $auth = $request->authenticate();

        if ($auth) {

            $request->session()->put('auth.password_confirmed_at', time() + 10800);

            RateLimiter::clear($request->throttleKey());

            $request->session()->regenerate();

            toastr()->success(__('Hello user.'));

            app('redirect')->setIntendedUrl(route($auth.'.dashboard'));

            if ($auth == 'admin')
                return redirect()->intended(RouteServiceProvider::ADMIN_HOME);
        }

        return redirect()->back();
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('admin')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->route('admin.login');
    }
}
