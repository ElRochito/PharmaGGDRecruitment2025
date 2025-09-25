<?php

/* @covers \App\Http\Controllers\ProductController::index */

use App\Models\Product;
use Laravel\Sanctum\PersonalAccessToken;

it('retrieves products with pagination', function (): void {
    [$product1, $product2, $product3] = Product::factory(3)
        ->sequence(
            [
                'name' => 'Doliprane',
                'description' => 'Doliprane',
                'price' => 5.50,
                'stock' => 10,
            ],
            [
                'name' => 'Efferalgan',
                'description' => 'Efferalgan',
                'price' => 4.50,
                'stock' => 4,
            ],
            [
                'name' => 'Dafalgan',
                'description' => 'Dafalgan',
                'price' => 9.80,
                'stock' => 12,
            ]
        )
        ->create();

    $this
        ->getJson('api/products')
        ->assertOk()
        ->assertJsonPath('data', [
            [
                'id' => $product1->id,
                'name' => 'Doliprane',
                'description' => 'Doliprane',
                'price' => 5.50,
                'stock' => 10,
            ],
            [
                'id' => $product2->id,
                'name' => 'Efferalgan',
                'description' => 'Efferalgan',
                'price' => 4.50,
                'stock' => 4,
            ],
            [
                'id' => $product3->id,
                'name' => 'Dafalgan',
                'description' => 'Dafalgan',
                'price' => 9.80,
                'stock' => 12,
            ],
        ])
        ->assertJsonStructure([
            'links' => ['first', 'last', 'prev', 'next'],
            'meta' => ['current_page', 'per_page', 'from', 'to', 'path'],
        ])
        ->dump();

    $this->assertDatabaseCount(PersonalAccessToken::class, 0);
});
