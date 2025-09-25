<?php

/* @covers \App\Http\Controllers\ProductController::store */

use App\Actions\CreateProduct;
use App\Data\ProductData;
use App\Models\Admin;
use App\Models\Permission;
use App\Models\Product;
use App\Models\Role;
use App\Models\User;

it('creates a product', function (): void {
    $permission = Permission::factory()->createOne([
        'code' => 'products.create',
    ]);

    $role = Role::factory()
        ->hasAttached($permission)
        ->createOne();

    $user = Admin::factory()
        ->for($role)
        ->createOne();
    $token = $user->createToken('azerty')->plainTextToken;

    $this->mock(CreateProduct::class)
        ->shouldReceive('execute')
        ->withArgs(function (ProductData $data) {
            return $data->name === 'Doliprane';
        })
        ->andReturn(Product::factory()->createOne())
        ->once();

    $this
        ->postJson('api/products', [
            'name' => 'Doliprane',
            'description' => 'Doliprane',
            'price' => 5.50,
            'stock' => 10,
        ], [
            'Authorization' => 'Bearer ' . $token,
        ])
        ->assertCreated();
});

it('denies a user to create a product', function (): void {
    $user = User::factory()->createOne();
    $token = $user->createToken('azerty')->plainTextToken;

    $this
        ->postJson('api/products', [
            'name' => 'Doliprane',
            'description' => 'Doliprane',
            'price' => 5.50,
            'stock' => 10,
        ], [
            'Authorization' => 'Bearer ' . $token,
        ])
        ->assertForbidden();
});
