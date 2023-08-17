<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = [
            
            'species-list',
            'species-create',
            'species-edit',
            'species-delete',
            'species-clear-list',
            'species-import',
            'species-export',
            'species-publish',
            'user-list',
            'user-create',
            'user-edit',
            'user-delete',
            'permission-list',
            'permission-create',
            'permission-edit',
            'permission-delete',
            'role-list',
            'role-create',
            'role-edit',
            'role-delete',
            'activity-logs',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        $role = Role::firstOrCreate(['name' => 'Administrator']);

        $permissions = Permission::pluck('id','id')->all();

        $role->syncPermissions($permissions);
    }
}
