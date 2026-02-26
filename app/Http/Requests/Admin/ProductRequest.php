<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->isAdmin();
    }

    public function rules(): array
    {
        $productId = $this->route('product')?->id;

        return [
            'name'              => 'required|string|max:255',
            'category_id'       => 'required|exists:categories,id',
            'description'       => 'nullable|string',
            'short_description' => 'nullable|string|max:500',
            'price'             => 'required|numeric|min:0',
            'compare_price'     => 'nullable|numeric|min:0',
            'stock'             => 'required|integer|min:0',
            'sku'               => 'nullable|string|max:100|unique:products,sku,' . $productId,
            'image'             => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'gallery'           => 'nullable|array',
            'gallery.*'         => 'image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'is_active'         => 'boolean',
            'is_featured'       => 'boolean',
        ];
    }

    public function messages(): array
    {
        return [
            'category_id.required' => 'Please select a category.',
            'category_id.exists'   => 'The selected category does not exist.',
            'price.required'       => 'Product price is required.',
            'price.numeric'        => 'Price must be a valid number.',
            'stock.required'       => 'Stock quantity is required.',
            'image.image'          => 'The file must be an image.',
            'image.max'            => 'Image may not be greater than 2MB.',
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'is_active'   => $this->boolean('is_active'),
            'is_featured' => $this->boolean('is_featured'),
        ]);
    }
}
