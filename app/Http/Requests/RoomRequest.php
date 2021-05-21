<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class RoomRequest extends FormRequest
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
            return $this->createRoom();
            } elseif ( $this->isMethod('put') ) {
                return $this->updateRoom();
            }
    }

    public function createRoom(): array
    {
        return [
            'category_id' => ['required', 'numeric', 'digits_between:1,2'],
            'number' => ['required', 'numeric', 'digits_between:1,4', 'unique:rooms'],
            'level' => ['required', 'numeric', 'digits_between:1,2'],
        ];
    }

    public function updateRoom(): array
    {
        return [
            'category_id' => ['required', 'numeric', 'digits_between:1,2'],
            'number' => ['required', 'numeric', 'digits_between:1,4',
             Rule::unique('rooms')->ignore($this->route('room'), 'id')],
            'level' => ['required', 'numeric','digits_between:1,2'],
            'status' => ['required']
        ];
    }
}
