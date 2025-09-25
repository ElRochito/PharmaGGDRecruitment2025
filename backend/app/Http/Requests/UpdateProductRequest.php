<?php

namespace App\Http\Requests;

use App\Models\Admin;
use App\Models\Product;
use Illuminate\Container\Attributes\CurrentUser;
use Illuminate\Container\Attributes\RouteParameter;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateProductRequest extends FormRequest
{
    /**
     * @return array<string,mixed>
     */
    public function rules(
        #[CurrentUser]
        Admin $admin,
        #[RouteParameter('product')]
        Product $product,
    ): array {
        return [
            'name' => [
                'sometimes',
                'max:255',
                Rule::unique(Product::class)->ignore($product),
            ],
            'description' => ['sometimes'],
            'price' => [
                'sometimes',
                'numeric',
                'min:0',
            ],
            'stock' => [
                'sometimes',
                'integer',
                'min:0',
            ],
        ];
    }
}
