<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UrlUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    //    public function authorize(): bool
    //    {
    //        return false;
    //    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, array|\Illuminate\Contracts\Validation\Rule|string>
     */
    public function rules(): array
    {
        return [
            'url' => ['string', 'max:255', Rule::unique('url')],
        ];
    }
}
