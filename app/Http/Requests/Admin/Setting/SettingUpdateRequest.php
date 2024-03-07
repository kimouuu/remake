<?php

namespace App\Http\Requests\Admin\Setting;

use Illuminate\Foundation\Http\FormRequest;

class SettingUpdateRequest extends FormRequest
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
            'history' => 'nullable|string',
            'community_bio' => 'nullable|string',
            'image' => 'nullable|image',
            'video' => 'nullable|url',
            'video1' => 'nullable|url',
            'video2' => 'nullable|url',
            'community_structure' => 'nullable|string',
            'slogan' => 'nullable|string|max:100',
            'community_name' => 'nullable|string|max:100',
            'endpoint' => 'nullable|string',
            'sender' => 'nullable|string',
            'api_key' => 'nullable|string',
        ];
    }
}
