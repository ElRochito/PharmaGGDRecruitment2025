<?php

namespace App\Http\Controllers;

use App\Actions\CreateProduct;
use App\Actions\UpdateProduct;
use App\Data\ProductData;
use App\Http\Requests\CreateProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Http\Resources\ProductResource;
use App\Models\Admin;
use App\Models\Product;
use Illuminate\Container\Attributes\CurrentUser;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductController
{
    public function index(): JsonResource
    {
        $products = Product::query()->latest()->paginate();

        return ProductResource::collection($products);
    }

    public function store(CreateProductRequest $request, CreateProduct $createProduct): JsonResource
    {
        $data = ProductData::from($request);
        $product = $createProduct->execute($data);

        return ProductResource::make($product);
    }

    public function show(Product $product): JsonResource
    {
        return ProductResource::make($product);
    }

    public function update(
        #[CurrentUser]
        Admin $admin,
        UpdateProductRequest $request,
        Product $product,
        UpdateProduct $updateProduct,
    ): JsonResource {
        $data = ProductData::from($request);

        $updateProduct->execute($product, $admin, $data);

        return ProductResource::make($product);
    }
}
