<?php

/* @covers \App\Http\Controllers\ProductController::index */

use App\Actions\UpdateProduct;
use App\Data\ProductData;
use App\Models\Product;

it('creates a product', function (): void {
    $product = Product::factory()->createOne(['name' => 'test product']);
    $data = new ProductData(
        name: 'Efferalgan',
        description: 'Efferalgan',
        price: 4.50,
        stock: 4,
    );

    app(UpdateProduct::class)->execute($product, $data);

    $this->assertDatabaseHas(Product::class, [
        'id' => $product->id,
        'name' => 'Efferalgan',
        'description' => 'Efferalgan',
        'price' => 4.50,
        'stock' => 4,
    ]);
});
