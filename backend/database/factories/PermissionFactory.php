<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @method RoleFactory hasAdmins($count = 1, $attributes = [])
 * @method RoleFactory hasPermissions($count = 1, $attributes = [])
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Role>
 */
class PermissionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'code' => $this->faker->name(),
        ];
    }
}
