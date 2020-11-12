<?php

namespace App\Http\Requests\Booking;


use Illuminate\Foundation\Http\FormRequest;

class PostBookingRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $today = now()->toDateString();

        return [
            'ride_id' => 'required|integer|exists:rides,id',
            'start_location_id' => 'required|integer|exists:locations,id',
            'end_location_id' => 'required|integer|exists:locations,id',
            'travel_date' => "required|date|after_or_equal:$today",
            'seats' => 'required|integer|min:1'
        ];
    }
}
