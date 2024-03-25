<?php

namespace App\Http\Requests\Member\Document;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class DocumentStoreRequest extends FormRequest
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
            'user_document_type_id' => [
                'required',
                Rule::unique('user_documents', 'user_document_type_id')->where(function ($query) {
                    return $query->where('user_id', auth()->id());
                }),
            ],
            'input' => 'required_if:user_document_type_id,text',
            'input_or_image' => 'required_if:user_document_type_id,image|mimes:jpg,png,jpeg|max:2048',
            'verified_at' => 'nullable|date',
            'verified_by' => 'nullable',
        ];
    }
}
