<?php

namespace Database\Seeders;

use App\Models\Hotel;
use App\Models\Image;
use Illuminate\Database\Seeder;

class HotelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Hotel::factory(1)->create();
    }
}
