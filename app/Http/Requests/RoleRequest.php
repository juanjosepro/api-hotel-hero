<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

use App\Rules\LowerCase;

class RoleRequest extends FormRequest
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
            return $this->createRole();
        } elseif ( $this->isMethod('put') ) {
            return $this->updateRole();
        }
    }

    public function createRole(): array
    {
        return [
            'name' => ['required', 'string', 'unique:roles', new LowerCase,
             'min:3', 'max:30'],
            'description' => ['required', 'string', 'min:3', 'max:250']
        ];
    }

    public function updateRole(): array
    {
        return [
            'name' => ['required', 'string', 'min:3', 'max:30',
             Rule::unique('roles')->ignore($this->route('role'), 'id')],
            'description' => ['required', 'string', 'min:3', 'max:30'],
        ];
    }
}
