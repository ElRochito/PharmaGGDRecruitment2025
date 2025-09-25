<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateProductRequest extends FormRequest
{
    /**
     * @return array<string,mixed>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'max:255', 'unique:products,name'],
            'description' => ['required'],
            'price' => ['required', 'numeric', 'min:0', 'max:100'],
            'stock' => ['required', 'integer', 'min:0', 'max:100'],
        ];
    }
}
