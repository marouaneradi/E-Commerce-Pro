<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class CategoryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->isAdmin();
    }

    public function rules(): array
    {
        $categoryId = $this->route('category')?->id;

        return [
            'name'       => 'required|string|max:255|unique:categories,name,' . $categoryId,
            'description'=> 'nullable|string|max:1000',
            'image'      => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'is_active'  => 'boolean',
            'sort_order' => 'integer|min:0',
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'is_active'  => $this->boolean('is_active'),
            'sort_order' => $this->input('sort_order', 0),
        ]);
    }
}
