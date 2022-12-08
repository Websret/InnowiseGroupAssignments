<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => 'required|min:2|max:255|string',
            'manufacture' => 'required|min:2|max:255',
            'release_date' => 'required',
            'cost' => 'required|min:1|integer',
            'description' => 'required|min:4|max:255',
            'product_type' => 'required|integer|max:255',
        ];
    }
}
