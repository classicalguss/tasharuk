<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class IndicatorRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
			'text' => 'string|required',
			'highly_effective' => 'string',
			'effective' => 'string',
			'satisfactory' => 'string',
			'needs_improvement' => 'string',
			'does_not_meet_standard' => 'string'
        ];
    }
}
