<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePetRequest extends FormRequest
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
            'name' => 'required',
            'gender' => 'required',
            'datebirth' => 'nullable',
            'weight' => 'nullable',
            'description' => 'required',
            'image' => 'required|image|mimes:jpg,png,jpeg,gif,svg',
            'categories_id' => 'required'
        ];
    }
}
