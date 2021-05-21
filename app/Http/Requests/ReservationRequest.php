<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ReservationRequest extends FormRequest
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
            return $this->createAndUpdateReservation();
        } elseif ( $this->isMethod('put') ) {
            return $this->createAndUpdateReservation();
        }
    }

    public function createAndUpdateReservation(): array
    {
        return [
            'room_number' => ['required', 'numeric', 'digits_between:1,4'],
            'via' => ['required', 'string', 'min:3'],
            'name' => ['required', 'string', 'min:3', 'max:30'],
            'last_name' => ['required', 'string', 'min:3', 'max:30'],
            'persons' => ['required', 'numeric', 'min:1'],
            'entry_date' => ['required', 'string'],
            'departure_date' => ['required', 'string'],
        ];
    }
}
