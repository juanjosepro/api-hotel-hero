<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserRequest extends FormRequest
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
        return $this->createUser();
        } elseif ( $this->isMethod('put') ) {
            return $this->updateUser();
        }
    }

    public function createUser(): array
    {
        return [
            'role_id' => ['required', 'numeric', 'digits_between:1,2'],
            'name' => ['required', 'string', 'min:3', 'max:30'],
            'last_name' => ['required', 'string', 'min:3', 'max:30'],
            'dni' => ['required', 'numeric', 'digits_between:8,12', 'unique:users'],
            'phone' => ['required', 'numeric', 'digits_between:6,14', 'unique:users'],
            'date_of_birth' => ['required', 'date', 'max:19'],
            'email' => ['required', 'string', 'email', 'min:8', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'password_confirmation' => ['required', 'string', 'min:8']
        ];
    }

    public function updateUser(): array
    {
        return [
            'role_id' => ['required', 'numeric', 'min:1'],
            'name' => ['required', 'string', 'min:3', 'max:30'],
            'last_name' => ['required', 'string', 'min:3', 'max:30'],
            'dni' => ['required', 'numeric', 'digits_between:8,12',
                Rule::unique('users')->ignore($this->route('user'), 'id')],
            'phone' => ['required', 'digits_between:6,14',
                Rule::unique('users')->ignore($this->route('user'), 'id')],
            'date_of_birth' => ['required', 'date', 'max:19'],
            'email' => ['string', 'email', 'min:8',
                Rule::unique('users')->ignore($this->route('user'), 'id')],
        ];
    }
}
