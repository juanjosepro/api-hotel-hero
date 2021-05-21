<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CategoryRequest extends FormRequest
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
        if( $this->isMethod('post') ) {
            return $this->createCategory();
        } elseif ( $this->isMethod('put') ) {
            return $this->updateCategory();
        }
    }

    public function createCategory(): array
    {
        return [
            'name' => ['required', 'string', 'unique:categories', 'min:3', 'max:15']
        ];
    }

    public function updateCategory(): array
    {
        return [
            'name' => ['required', 'string', 'min:3', 'max:15', Rule::unique('categories')->ignore($this->route('category'), 'id')],
            'price' => ['required', /*'regex:/^[\d]{0,8}(\[\d]{1,2})?$/',*/ 'min:5', 'max:8'],
            'details' => ['required', 'string', 'min:5']
        ];
    }

    public function messages(): array
    {
        return [
            'price.min' => 'El campo precio debe ser mayor o igual a 5 digitos contando los (, y .)',
            'price.max' => 'El campo precio debe ser menor o igual a 8 digitos contando los (, y .)',
            /*'price.regex' => 'El formato correcto es... ej(50, 50.00, 3130.33)',*/
        ];
    }
}
