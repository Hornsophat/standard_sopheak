<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PropertyTypeRequest extends FormRequest
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
            'propertytype_name' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'propertytype_name' => "Name is required.",
            'propertytype_name_kh' => "Name Khmer is required."
        ];
    }

}
