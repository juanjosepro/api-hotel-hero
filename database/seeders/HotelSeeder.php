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
        $hotel = new Hotel();
        $hotel->name = 'Pen House';
        $hotel->ruc = '95315984672';
        $hotel->location = 'Arequipa Cayma Buenos Aires';
        $hotel->phone = '935257000';
        $hotel->email = 'penhouse@app.com';
        $hotel->levels = 5;
        $hotel->description = 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industrys standard dummy text ever since the 1500s';
        $hotel->image = 'public/without-image.png';
        $hotel->logo = 'public/without-image.png';
        $hotel->save();
    }
}
