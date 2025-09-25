<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Seeder;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create permissions
        $permissions = [
            ['code' => 'users.read', 'name' => 'Read Users'],
            ['code' => 'users.create', 'name' => 'Create Users'],
            ['code' => 'users.update', 'name' => 'Update Users'],
            ['code' => 'users.delete', 'name' => 'Delete Users'],
            ['code' => 'admins.read', 'name' => 'Read Admins'],
            ['code' => 'admins.create', 'name' => 'Create Admins'],
            ['code' => 'admins.update', 'name' => 'Update Admins'],
            ['code' => 'admins.delete', 'name' => 'Delete Admins'],
            ['code' => 'roles.read', 'name' => 'Read Roles'],
            ['code' => 'roles.create', 'name' => 'Create Roles'],
            ['code' => 'roles.update', 'name' => 'Update Roles'],
            ['code' => 'roles.delete', 'name' => 'Delete Roles'],
            ['code' => 'permissions.read', 'name' => 'Read Permissions'],
            ['code' => 'permissions.create', 'name' => 'Create Permissions'],
            ['code' => 'permissions.update', 'name' => 'Update Permissions'],
            ['code' => 'permissions.delete', 'name' => 'Delete Permissions'],
            ['code' => 'products.create', 'name' => 'Create Products'],
            ['code' => 'products.read', 'name' => 'Read Products'],
            ['code' => 'products.update', 'name' => 'Update Products'],
            ['code' => 'products.delete', 'name' => 'Delete Products'],
            ['code' => 'products.update_price', 'name' => 'Update Product Price'],
        ];

        Permission::query()->insert($permissions);

        // Create roles
        $superAdminRole = Role::query()->create([
            'code' => 'super_admin',
            'name' => 'Administrateur',
            'all_permissions' => true,
        ]);

        $catalogRole = Role::query()->create([
            'code' => 'catalog',
            'name' => 'Catalogue',
            'all_permissions' => false,
        ]);

        // Assign specific permissions to admin role
        $adminPermissions = Permission::query()
            ->whereIn('code', [
                'users.read',
                'users.create',
                'users.update',
                'admins.read',
                'roles.read',
                'permissions.read',
                'products.update_price',
            ])
            ->pluck('id');

        $superAdminRole->permissions()->attach($adminPermissions);

        // Assign specific permissions to moderator role
        $catalogPermissions = Permission::query()
            ->whereIn('code', [
                'users.read',
                'products.read',
                'products.update',
            ])
            ->get();

        $catalogRole->permissions()->attach($catalogPermissions);
    }
}
