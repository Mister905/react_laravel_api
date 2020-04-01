<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8',
            'confirm_password' => 'required|same:password'
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'first_name.required' => 'First Name is required',
            'last_name.required'  => 'Last Name is required',
            'email.required'  => 'Email is required',
            'email.email'  => 'Please enter a valid email',
            'password.required'  => 'Password is required',
            'password.min'  => 'Minimum password length is 8 characters',
            'confirm_password.required'  => 'Password Confirmation is required',
            'confirm_password.same'  => 'Passwords must match'
        ];
    }
}
