<?php

/* @covers \App\Http\Controllers\ProductController::update */

use App\Actions\UpdateProduct;
use App\Data\ProductData;
use App\Models\Admin;
use App\Models\Permission;
use App\Models\Product;
use App\Models\Role;
use App\Models\User;

it('updates a product', function (): void {
    $product = Product::factory()->createOne([
        'name' => 'Doliprane',
        'description' => 'Doliprane',
        'price' => 5.50,
        'stock' => 10,
    ]);

    $permission = Permission::factory()->createOne([
        'code' => 'products.update',
    ]);

    $role = Role::factory()
        ->hasAttached($permission)
        ->createOne(['all_permissions' => true]);

    $user = Admin::factory()->for($role)->createOne();
    $token = $user->createToken('azerty')->plainTextToken;

    $this->mock(UpdateProduct::class)
        ->shouldReceive('execute')
        ->withArgs(function (Product $myProduct, ProductData $data) use ($product) {
            return $product->id === $myProduct->id
                && $data->name === 'Doliprane';
        })
        ->andReturn(Product::factory()->createOne())
        ->once();

    $this
        ->putJson("api/products/{$product->getRouteKey()}", [
            'name' => 'Doliprane',
            'description' => 'Doliprane',
            'price' => 5.50,
            'stock' => 10,
        ], [
            'Authorization' => 'Bearer ' . $token,
        ])
        ->assertOk();
});

it('cant update price with bad permission', function (): void {
    $product = Product::factory()->createOne([
        'name' => 'Doliprane',
        'description' => 'Doliprane',
        'price' => 5.50,
        'stock' => 10,
    ]);

    $permission = Permission::factory()->createOne([
        'code' => 'products.update',
    ]);

    $role = Role::factory()
        ->hasAttached($permission)
        ->createOne(['all_permissions' => false]);

    $user = Admin::factory()->for($role)->createOne();
    $token = $user->createToken('azerty')->plainTextToken;

    $this->mock(UpdateProduct::class)
        ->shouldReceive('execute')
        ->never();

    $this
        ->putJson("api/products/{$product->getRouteKey()}", [
            'name' => 'Doliprane',
            'description' => 'Doliprane',
            'price' => 5.50,
            'stock' => 10,
        ], [
            'Authorization' => 'Bearer ' . $token,
        ])
        ->assertJsonValidationErrors([
            'price' => 'The price field is prohibited',
        ]);
});

it('denies a unser to update a product', function (): void {
    $product = Product::factory()->createOne([
        'name' => 'Doliprane',
        'description' => 'Doliprane',
        'price' => 5.50,
        'stock' => 10,
    ]);

    $user = User::factory()->createOne();
    $token = $user->createToken('azerty')->plainTextToken;

    $this->mock(UpdateProduct::class)
        ->shouldReceive('execute')
        ->never();

    $this
        ->putJson("api/products/{$product->getRouteKey()}", [
            'name' => 'Doliprane',
            'description' => 'Doliprane',
            'price' => 5.50,
            'stock' => 10,
        ], [
            'Authorization' => 'Bearer ' . $token,
        ])
        ->assertForbidden();
});
