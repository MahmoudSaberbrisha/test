<?php

namespace Modules\AdminRoleAuthModule\Http\Requests\Auth;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Auth\Events\Lockout;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Str;

class ResetPasswordRequest extends FormRequest
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
            'email' => ['required', 'string', 'email',
                function ($attribute, $value, $fail) {
                    $exists = false;
                    $guards = ['admin', 'student', 'teacher'];

                    foreach ($guards as $guard) {
                        $provider = config("auth.guards.$guard.provider");
                        $model = config("auth.providers.$provider.model");

                        if ($model::where('email', $value)->exists()) {
                            $exists = true;
                            break;
                        }
                    }

                    if (!$exists) {
                        $fail(__('The email does not exist in our records.'));
                    }
                },
            ]
        ];
    }

    public function encreaseAttemptes(): void
    {
        RateLimiter::hit($this->throttleKey());
    }

    public function ensureNotManyAttemptes(): void
    {
        if (! RateLimiter::attempts($this->throttleKey())) {
            return;
        }

        event(new Lockout($this));

        $seconds = RateLimiter::availableIn($this->throttleKey());

        throw ValidationException::withMessages([
            'email' => trans('passwords.throttled', [
                'seconds' => $seconds,
                'minutes' => ceil($seconds / 60),
            ]),
        ]);
    }

    public function throttleKey(): string
    {
        return Str::transliterate(Str::lower($this->input('email')).'|'.$this->ip());
    }

}
