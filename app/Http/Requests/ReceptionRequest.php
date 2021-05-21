<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ReceptionRequest extends FormRequest
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
            return $this->registeNewGuestAndUpdateGuestData();
            } elseif ( $this->isMethod('put') ) {
                return $this->registeNewGuestAndUpdateGuestData();
            }
    }

    public function registeNewGuestAndUpdateGuestData(): array
    {
        return [
            'room_number' => ['required', 'numeric', 'digits_between:1,3'],
            'name' => ['required', 'string', 'min:3', 'max:30'],
            'last_name' => ['required', 'string', 'min:3', 'max:30'],
            'dni' => ['required', 'numeric', 'digits_between:8,12'],
            'persons' => ['required', 'numeric', 'min:1'],
            'origin' => ['required', 'string', 'min:6', 'max:50'],
            'entry_date' => ['required', 'string'],
            'departure_date' => ['required', 'string'],
        ];
    }
}
