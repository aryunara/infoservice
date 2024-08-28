<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class LeadRequest extends FormRequest
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
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'min:2', 'max:20'],
            'surname' => ['required', 'string', 'min:2', 'max:20'],
            'phone' => ['required', 'string', 'min:10', 'max:16'],
            'email' => ['required', 'email', 'string', 'min:5'],
            'text' => ['required', 'string', 'min:5', 'max:255']
        ];
    }
}
