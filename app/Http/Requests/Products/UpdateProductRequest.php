<?php

namespace App\Http\Requests\Products;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends FormRequest
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
    public function rules(): array
    {
        $productId = $this->id;
        return [
            'name' => "required|string|max:100|min:2|unique:products,name,$productId,id",
            'code' => "required|digits:5|unique:products,code,$productId,id",
            'price' => 'required|numeric|max:999999|min:50',
            'count' => 'required|integer|digits:3',
            'brand_id' => 'required|integer|exists:brands,id',
            'subcategory_id' => 'required|integer|exists:subcategories,id',
            'image' => 'nullable|mimes:png,jpg,jpeg'
        ];
    }
}
