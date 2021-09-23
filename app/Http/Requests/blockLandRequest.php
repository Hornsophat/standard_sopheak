<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class blockLandRequest extends FormRequest
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
            "customer" => 'required|numeric',
            "block_description" => "required",
            "value_x" => "required|numeric",
            "value_y" => "required|numeric"
        ];
    }
}
