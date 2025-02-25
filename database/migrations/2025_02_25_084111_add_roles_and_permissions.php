<?php

use Illuminate\Database\Migrations\Migration;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

return new class extends Migration
{
    public function up(): void
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

    public function down(): void
    {
        Role::whereIn('name', ['admin', 'user'])->delete();
        Permission::whereIn('name', ['create post', 'edit post', 'delete post'])->delete();
    }
};
