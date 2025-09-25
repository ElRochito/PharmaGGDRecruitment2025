<?php

namespace App\Actions;

use App\Data\ProductData;
use App\Models\Product;

class CreateProduct
{
    public function execute(ProductData $productData): Product
    {
        return Product::query()->create($productData->toArray());
    }
}
