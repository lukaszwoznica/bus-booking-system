<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PutUserRequest extends PostUserRequest
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
        $rules = parent::rules();
        $rules['password'] = 'nullable|string|min:8';
        $rules['email'] = "required|string|email|max:255|unique:users,email,{$this->user->id}";

        return $rules;
    }
}
