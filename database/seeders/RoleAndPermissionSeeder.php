<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleAndPermissionSeeder extends Seeder
{
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Define permissions
        $permissions = [
            'manage settings',
            'view audit logs',
            
            'create achievements', 'edit achievements', 'delete achievements', 'publish achievements',
            'create bills', 'edit bills', 'delete bills', 'publish bills',
            'create motions', 'edit motions', 'delete motions', 'publish motions',
            'create projects', 'edit projects', 'delete projects', 'publish projects',
            'create news', 'edit news', 'delete news', 'publish news',
            'create speeches', 'edit speeches', 'delete speeches', 'publish speeches',
            'create events', 'edit events', 'delete events', 'publish events',
            'create publications', 'edit publications', 'delete publications', 'publish publications',
            'create media', 'edit media', 'delete media', 'publish media',
            
            'view messages', 'reply messages',
            'manage subscribers',
        ];

        foreach ($permissions as $permission) {
            Permission::findOrCreate($permission);
        }

        // Create roles and assign permissions
        $superAdmin = Role::findOrCreate('Super Admin');
        // Super Admin gets all permissions via a gate override usually, but let's assign explicitly too
        $superAdmin->givePermissionTo(Permission::all());

        $publisher = Role::findOrCreate('Publisher');
        $publisher->givePermissionTo([
            'create achievements', 'edit achievements', 'delete achievements', 'publish achievements',
            'create bills', 'edit bills', 'delete bills', 'publish bills',
            'create motions', 'edit motions', 'delete motions', 'publish motions',
            'create projects', 'edit projects', 'delete projects', 'publish projects',
            'create news', 'edit news', 'delete news', 'publish news',
            'create speeches', 'edit speeches', 'delete speeches', 'publish speeches',
            'create events', 'edit events', 'delete events', 'publish events',
            'create publications', 'edit publications', 'delete publications', 'publish publications',
            'create media', 'edit media', 'delete media', 'publish media',
            'view messages', 'reply messages',
            'manage subscribers',
        ]);

        $editor = Role::findOrCreate('Editor');
        $editor->givePermissionTo([
            'create achievements', 'edit achievements',
            'create bills', 'edit bills',
            'create motions', 'edit motions',
            'create projects', 'edit projects',
            'create news', 'edit news',
            'create speeches', 'edit speeches',
            'create events', 'edit events',
            'create publications', 'edit publications',
            'create media', 'edit media',
            'view messages',
        ]);

        Role::findOrCreate('Viewer');
    }
}
