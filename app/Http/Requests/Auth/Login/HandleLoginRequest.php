<?php

namespace App\Http\Requests\Auth\Login;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class HandleLoginRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'phone' => 'required',
            'password' => 'required|min:8',
        ];
    }

    public function authenticate(): void
    {
        $credentialEmail = ['email' => $this->phone, 'password' => $this->password];

        if (Auth::attempt($this->only('phone', 'password'), $this->boolean('remember'))) {
            RateLimiter::clear($this->throttleKey());
        } elseif (Auth::attempt($credentialEmail, $this->boolean('rmember'))) {
            RateLimiter::clear($this->throttleKey());
        } else {
            RateLimiter::hit($this->throttleKey());
            throw ValidationException::withMessages([
                'phone' => __('auth.failed'),
            ]);
        }
    }

    public function throttleKey(): string
    {
        return Str::transliterate(Str::lower($this->input('phone')) . '|' . $this->ip());
    }
}
