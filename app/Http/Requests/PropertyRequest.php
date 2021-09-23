<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PropertyRequest extends FormRequest
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
        return [];
    }

    public function messages()
    {
        return [
            'project' => "Project is required.",
            'project_zone' => "Project zone is required.",
            'property_type' => "Project type is required.",
            'property_name' => "Project name is required.",
        ];
    }

}
