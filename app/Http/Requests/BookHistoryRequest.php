<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BookHistoryRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'status' => 'nullable|integer|in:1,2',
            'per_page' => 'nullable|integer|min:1|max:100'
        ];
    }
}
