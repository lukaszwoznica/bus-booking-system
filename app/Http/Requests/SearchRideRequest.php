<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SearchRideRequest extends FormRequest
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
        $locationRegex = '/^[\p{L}]+[\p{L}\- ]*[\p{L}]+$/u';

        return [
            'start_location' => "required|string|regex:$locationRegex",
            'end_location' => "required|string|regex:$locationRegex",
            'date' => "required|date|after_or_equal:$today"
        ];
    }
}
