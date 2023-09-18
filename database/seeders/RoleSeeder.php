<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds_
     *
     * @return void
     */
    public function run()
    {
        $superAdmin = Role::create(['name' => 'super_admin']);
        Role::create(['name' => 'admin']);
        Role::create(['name' => 'employee']);
        Role::create(['name' => 'user']);
        $permissions = [
            [
                'group_name' => 'Global',
                'permissions' => [
                    'dashboard_manage',
                    'site_setting_manage',
                ]
            ],
            [
                'group_name' => 'Commands',
                'permissions' => [
                    'commands_manage',
                    'command_cache_clear',
                    'command_config_clear',
                    'command_route_clear',
                    'command_optimize',
                    'command_migrate',
                    'command_migrate_fresh',
                    'command_migrate_fresh_seed',
                ]
            ],
            [
                'group_name' => 'Roles',
                'permissions' => [
                    'role_manage',
                    'role_list',
                    'role_view',
                    'role_create',
                    'role_update',
                    'role_delete',
                ]
            ],
            [
                'group_name' => 'Permission',
                'permissions' => [
                    'permission_manage',
                    'permission_list',
                    'permission_view',
                    'permission_update',
                    'permission_delete',
                    'permission_create',

                ]
            ],
            [
                'group_name' => 'Admin',
                'permissions' => [
                    'admin_manage',
                    'admin_list',
                    'admin_view',
                    'admin_update',
                    'admin_delete',
                    'admin_create',
                ]
            ],
            [
                'group_name' => 'User',
                'permissions' => [
                    'user_manage',
                    'user_list',
                    'user_view',
                    'user_update',
                    'user_delete',
                    'user_create',
                ]
            ],
            [
                'group_name' => 'Store',
                'permissions' => [
                    'store_manage',
                    'store_list',
                    'store_view',
                    'store_update',
                    'store_delete',
                    'store_create',
                ]
            ],
            [
                'group_name' => 'Transactions',
                'permissions' => [
                    'transaction_manage',
                    'transaction_list',
                    'transaction_view',
                    'transaction_update',
                    'transaction_delete',
                    'transaction_create',
                ]
            ],


        ];

        for ($i = 0;$i<count($permissions);$i++){
            $permissions_group = $permissions[$i]['group_name'];
            for ($j = 0;$j<count($permissions[$i]['permissions']);$j++){
                //Admin guard Permisson
                $super_permission =  Permission::create(['name'=>$permissions[$i]['permissions'][$j],'group_name'=>$permissions_group]);
                $superAdmin->givePermissionTo($super_permission);
                $super_permission->assignRole($superAdmin);

            }

        }
    }
}
