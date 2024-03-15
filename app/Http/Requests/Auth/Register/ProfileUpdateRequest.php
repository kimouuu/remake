<?php

namespace App\Http\Requests\Auth\Register;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;

class ProfileUpdateRequest extends FormRequest
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
            'fullname' => 'required|string|max:100',
            // 'phone' => 'required|digits_between:10,13|unique:users,phone,' . auth()->id(),
            'email' => 'required|string|email|max:255|unique:users,email,' . User::find($this->userId)->id,
            'gender' => 'required',
            'date_birth' => 'required|date',
            'address' => 'required|string|max:100',
            'province' => 'required|string|max:100',
            'city' => 'required|string|max:100',
            'district' => 'required|string|max:100',
            'postal_code' => 'required|digits:5',

        ];
    }
}
