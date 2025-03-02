<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Define roles
        $roles = ['admin', 'superadmin'];

        // Create roles
        foreach ($roles as $role) {
            Role::firstOrCreate(['name' => $role]);
        }

        // Define permissions
        $permissions = [
            'view_user',

            'view_banner',
            'create_banner',
            'store_banner',
            'show_banner',
            'edit_banner',
            'update_banner',
            'delete_banner',
            'publish_banner',

            'view_post',
            'create_post',
            'store_post',
            'show_post',
            'edit_post',
            'update_post',
            'delete_post',
            'publish_post',

            'view_page',
            'create_page',
            'store_page',
            'show_page',
            'edit_page',
            'update_page',
            'delete_page',

            'delete_media',

            'view_subscriber',

            'edit_setting',
            'update_setting',

        ];

        // Create permissions
        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // // Assign permissions to roles
        $admin = Role::findByName('superadmin');
        $admin->givePermissionTo(Permission::all());

        $user = User::find(17);
        $user->givePermissionTo(Permission::all());

        $this->command->info('Roles and Permissions Seeded Successfully!');
    }
}
