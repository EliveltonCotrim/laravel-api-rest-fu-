<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // permissões
        Permission::updateOrCreate(['name' => 'posts.view']);
        Permission::updateOrCreate(['name' => 'posts.create']);
        Permission::updateOrCreate(['name' => 'posts.update']);
        Permission::updateOrCreate(['name' => 'posts.delete']);
        Permission::updateOrCreate(['name' => 'users.list']);

        // roles
        $admin = Role::createOrFirst(['name' => 'admin']);
        $editor = Role::createOrFirst(['name' => 'editor']);
        $user = Role::createOrFirst(['name' => 'user']);

        // vincular permissões
        $admin->givePermissionTo(Permission::all());

        $editor->givePermissionTo([
            'posts.view',
            'posts.create',
            'posts.update'
        ]);

        $user->givePermissionTo([
            'posts.view'
        ]);

        // Sempre que atualizar as permissions tem que revogar os tokens
    }
}
