<?php

/* @covers \App\Http\Controllers\ProductController::index */

use App\Actions\UpdateProduct;
use App\Data\ProductData;
use App\Models\Admin;
use App\Models\Permission;
use App\Models\Product;
use App\Models\Role;

it('creates a product', function (): void {
    $product = Product::factory()->createOne(['name' => 'test product']);
    $data = new ProductData(
        name: 'Efferalgan',
        description: 'Efferalgan',
        price: 4.50,
        stock: 4,
    );

    $permission = Permission::factory()->createOne([
        'code' => 'products.update',
    ]);

    $role = Role::factory()
        ->hasAttached($permission)
        ->createOne(['all_permissions' => true]);

    $admin = Admin::factory()->for($role)->createOne();

    app(UpdateProduct::class)->execute($product, $admin, $data);

    $this->assertDatabaseHas(Product::class, [
        'id' => $product->id,
        'name' => 'Efferalgan',
        'description' => 'Efferalgan',
        'price' => 4.50,
        'stock' => 4,
    ]);
});

it('dont update price without right permissions', function (): void {
    $product = Product::factory()->createOne([
        'name' => 'test product',
        'price' => 10,
        'stock' => 2,
    ]);
    $data = new ProductData(
        name: 'Efferalgan',
        description: 'Efferalgan',
        price: 4.50,
        stock: 4,
    );

    $permission = Permission::factory()->createOne([
        'code' => 'products.update',
    ]);

    $role = Role::factory()
        ->hasAttached($permission)
        ->createOne(['all_permissions' => false]);

    $admin = Admin::factory()->for($role)->createOne();

    app(UpdateProduct::class)->execute($product, $admin, $data);

    $this->assertDatabaseHas(Product::class, [
        'id' => $product->id,
        'name' => 'Efferalgan',
        'description' => 'Efferalgan',
        'price' => 10,
        'stock' => 4,
    ]);
});
