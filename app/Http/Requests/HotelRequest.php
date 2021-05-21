<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class HotelRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'min:3', 'max:30'],
            'ruc' => ['required', 'min:3', 'max:1'],//, 'numeric', 'digits_between:8,15'
            'location' => ['required', 'string', 'min:3', 'max:50'],
            'levels' => ['required', 'numeric'],
            'phone' => ['required', 'digits_between:8,14'],
            'email' => ['required', 'string', 'min:8'],
            'description' => ['required', 'string', 'min:6', 'max:255'],
        ];
    }
}
