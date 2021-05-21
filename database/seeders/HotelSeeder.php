<?php

namespace Database\Seeders;

use App\Models\Hotel;
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
        //Hotel::factory(1)->create();
        $hotel = new Hotel();
        $hotel->name = 'la casona';
        $hotel->ruc = '95315984672';
        $hotel->location = 'Arequipa cayma Buenos Aires';
        $hotel->phone = '935257000';
        $hotel->email = 'lacasona@gmail.com';
        $hotel->levels = 5;
        $hotel->description = 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industrys standard dummy text ever since the 1500s';
        $hotel->image = 'public/without-image.jpg';
        $hotel->logo = 'public/without-image.jpg';
        $hotel->save();
    }
}
