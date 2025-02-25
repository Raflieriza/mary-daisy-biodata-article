<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        // Membuat Role
        $admin = Role::firstOrCreate(['name' => 'admin']);
        $user = Role::firstOrCreate(['name' => 'user']);

        // Membuat Permission
        $createPost = Permission::firstOrCreate(['name' => 'create post']);
        $editPost = Permission::firstOrCreate(['name' => 'edit post']);
        $deletePost = Permission::firstOrCreate(['name' => 'delete post']);

        // Memberikan Permission ke Role
        $admin->givePermissionTo([$createPost, $editPost, $deletePost]);
        $user->givePermissionTo($createPost);
    }
}
