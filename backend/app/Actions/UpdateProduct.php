<?php

namespace App\Actions;

use App\Data\ProductData;
use App\Models\Admin;
use App\Models\Product;
use Illuminate\Support\Traits\Conditionable;

class UpdateProduct
{
    use Conditionable;

    public function execute(Product $product, Admin $admin, ProductData $data): void
    {
        $product->update(
            (array) $this->when(
                $admin->role->all_permissions === true || $admin->role->permissions->contains(
                    'code',
                    'products.update_price'
                ),
                fn () => $data->toArray(),
                fn () => $data->except('price')->toArray()
            )
        );
    }
}
