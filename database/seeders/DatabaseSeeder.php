<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        $this->call(HotelSeeder::class);
        $this->call(RoleSeeder::class);
        $this->call(UserSeeder::class);
        //$this->call(CategorySeeder::class);
        //$this->call(RoomSeeder::class);
        //$this->call(ReservationSeeder::class);
        //$this->call(GuestSeeder::class);
        //$this->call(BoxSeeder::class);
    }
}
