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
            'create_user',
            'store_user',
            'show_user',
            'edit_user',
            'update_user',
            'delete_user',

            'view_category',
            'create_category',
            'store_category',
            'show_category',
            'edit_category',
            'update_category',
            'delete_category',

            'view_sub_category',
            'create_sub_category',
            'store_sub_category',
            'show_sub_category',
            'edit_sub_category',
            'update_sub_category',
            'delete_sub_category',

            'view_banner',
            'create_banner',
            'store_banner',
            'show_banner',
            'edit_banner',
            'update_banner',
            'delete_banner',

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

            'view_permission',
            'create_permission',
            'store_permission',
            'show_permission',
            'edit_permission',
            'update_permission',
            'delete_permission',

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

        // $user = User::find(17);
        // $user->givePermissionTo(Permission::all());

        $this->command->info('Roles and Permissions Seeded Successfully!');
    }
}
