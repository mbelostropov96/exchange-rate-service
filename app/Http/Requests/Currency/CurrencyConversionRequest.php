<?php

declare(strict_types=1);

namespace App\Http\Requests\Currency;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class CurrencyConversionRequest extends FormRequest
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
            'currency_from' => ['required', 'string'],
            'currency_to' => ['required', 'string'],
            'value' => ['required', 'numeric', 'min:0.01'],
        ];
    }
}
