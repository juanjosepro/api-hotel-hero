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
        Role::factory()->create([
            'name' => 'administrador',
            'description' => 'lorem ipsum dolor sit amet, consectetur adipisicing elit.'
        ]);
    }
}
