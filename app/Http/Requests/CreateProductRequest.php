<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateProductRequest extends FormRequest
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
            'brand' => 'required',
            'name' => 'required',
            'image' => 'file|mimes:jpeg,jpg,png,gif|max:1024',
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
            'brand.required' => 'Brand is required',
            'name.required'  => 'Name is required',
            'image.file' => 'Image requires valid file',
            'image.mimes' => 'Accepted image formats: jpeg, jpg, png, gif',
            'image.max' => 'Maximum file size of 10MB exceeded' 
        ];
    }
}
