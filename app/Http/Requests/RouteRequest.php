<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RouteRequest extends FormRequest
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
        return [
            'name' => 'required|string|max:255',
            'locations' => 'required|array|min:2',
            'locations.*.id' => 'required|integer|exists:locations,id',
            'locations.*.minutes' => 'sometimes|required|integer|digits_between:1,5|gte:0'
        ];
    }

    public function attributes()
    {
        return [
            'locations.*.id' => 'location',
            'locations.*.minutes' => 'expected time'
        ];
    }

    public function messages()
    {
        return [
          'locations.*.id.exists' => 'The selected :attribute does not exist.'
        ];
    }
}
