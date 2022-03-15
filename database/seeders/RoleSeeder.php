<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //  Creación de Roless    
       $role1 = Role::create(['name' => 'Administrador']);
       $role2 = Role::create(['name' => 'Cajero']);
        // permissos
        Permission::create(['name' =>'admin.usuarios.cajero'])->syncRoles([$role2]);
        Permission::create(['name' =>'admin.usuarios.administrador'])->syncRoles([$role1]);
    }
}
