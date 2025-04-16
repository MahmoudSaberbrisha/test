<?php

namespace Modules\AdminRoleAuthModule\Http\Requests\Auth;

use Illuminate\Auth\Events\Lockout;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Modules\AdminRoleAuthModule\Models\Admin;
use App\Models\Teacher;
use App\Models\Student;

class LoginRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'code' => ['required', 'string'],
            'password' => ['required', 'string'],
        ];
    }

    /**
     * Attempt to authenticate the request's credentials.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function authenticate()//: void
    {
        $this->ensureIsNotRateLimited();

        $credentialsByCode = $this->only('code', 'password');
        $credentialsByCode['active'] = 1;

        $credentialsByUserName = [
            'user_name' => $credentialsByCode['code'], 
            'password' => $credentialsByCode['password'], 
            'active' => 1
        ];

        $admin = Admin::where('code', $this->only('code'))
                ->orWhere('user_name', $this->only('code'))
                ->first();

        if ($admin) 
            return $this->checkLogin('admin', $admin, $credentialsByCode, $credentialsByUserName);

        throw ValidationException::withMessages([
            'code' => trans('auth.failed'),
        ]);
        
        return false;
    }

    public function checkLogin($guard, $user, $credentialsByCode, $credentialsByUserName)
    {
        $logged_in = Auth::guard($guard)->attempt($credentialsByCode, $this->boolean('remember')) || Auth::guard($guard)->attempt($credentialsByUserName, $this->boolean('remember'));

        if (! $logged_in) {
            RateLimiter::hit($this->throttleKey());

            if ($user->active != 1) {
                toastr()->error(__('This '.$guard.' is not active.'));
            } else {
                throw ValidationException::withMessages([
                    'password' => trans('auth.failed'),
                ]);
            }
            return false;
        }

        return $guard;
    }

    /**
     * Ensure the login request is not rate limited.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function ensureIsNotRateLimited(): void
    {
        if (! RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
            return;
        }

        event(new Lockout($this));

        $seconds = RateLimiter::availableIn($this->throttleKey());

        throw ValidationException::withMessages([
            'throttle' => trans('auth.throttle', [
                'seconds' => $seconds,
                'minutes' => ceil($seconds / 60),
            ]),
        ]);
    }

    /**
     * Get the rate limiting throttle key for the request.
     */
    public function throttleKey(): string
    {
        return Str::transliterate(Str::lower($this->input('code')).'|'.$this->ip());
    }
}
