<?php

namespace App\Actions;

use App\Data\ProductData;
use App\Models\Product;
use Illuminate\Support\Traits\Conditionable;

class UpdateProduct
{
    use Conditionable;

    public function execute(Product $product, ProductData $data): void
    {
        $product->update($data->all());
    }
}
