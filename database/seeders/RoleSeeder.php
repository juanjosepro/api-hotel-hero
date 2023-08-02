<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role = new Role();
        $role->name = 'administrador';
        $role->description = 'lorem ipsum dolor sit amet, consectetur adipisicing elit.';
        $role->save();

        $role = new Role();
        $role->name = 'recepcionista';
        $role->description = 'lorem ipsum dolor sit amet, consectetur adipisicing elit.';
        $role->save();
    }
}
