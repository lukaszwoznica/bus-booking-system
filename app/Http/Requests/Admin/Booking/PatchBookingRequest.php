<?php

namespace App\Http\Requests\Admin\Booking;

use App\BookingStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PatchBookingRequest extends FormRequest
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
        $statuses = [];
        foreach (BookingStatus::getKeys() as $status) {
            $statuses[] = strtolower($status);
        }

        return [
            'status' => [
                'required', 'string', Rule::in($statuses)
            ]
        ];
    }
}
