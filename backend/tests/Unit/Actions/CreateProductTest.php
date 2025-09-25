<?php

/* @covers \App\Http\Controllers\ProductController::index */

use App\Actions\CreateProduct;
use App\Data\ProductData;
use App\Models\Product;

it('creates a product', function (): void {
    $data = new ProductData(
        name: 'Efferalgan',
        description: 'Efferalgan',
        price: 4.50,
        stock: 4,
    );

    app(CreateProduct::class)->execute($data);

    $this->assertDatabaseHas(Product::class, [
        'name' => 'Efferalgan',
        'description' => 'Efferalgan',
        'price' => 4.50,
        'stock' => 4,
    ]);
});
