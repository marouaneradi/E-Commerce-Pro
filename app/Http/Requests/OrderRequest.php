<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrderRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        return [
            'first_name'     => 'required|string|max:100',
            'last_name'      => 'required|string|max:100',
            'email'          => 'required|email|max:255',
            'phone'          => 'nullable|string|max:20',
            'address'        => 'required|string|max:500',
            'city'           => 'required|string|max:100',
            'state'          => 'required|string|max:100',
            'zip_code'       => 'required|string|max:20',
            'country'        => 'required|string|max:100',
            'payment_method' => 'required|in:cod,card,paypal',
            'notes'          => 'nullable|string|max:1000',
        ];
    }
}
