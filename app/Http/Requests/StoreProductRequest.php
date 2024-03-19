<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules()
    {
        return [
            // 'supplier_id' => 'required|exists:supplier_details, id',
            'supplier_id' => 'required|integer',
            'product_name' => 'required|string',
            'quantity' => 'required|integer',
        ];
    }


    public function messages()
    {
        return [
            'supplier_id.required' => 'The supplier_id ID field is required.',
            'supplier_id.exists' => 'The selected supplier_id ID is invalid.',
            'product_name.required' => 'The product_name field is required.',
            'product_name.string' => 'The selected product_name is invalid.',
            'quantity.required' => 'The quantity field is required.',
            'quantity.string' => 'The selected quantity is invalid.',
        ];
    }
}
