<?php

namespace Database\Seeders;

use App\Models\Image;
use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::factory()->create()->each(function ($user) {
            $user->image()->save(Image::factory()->make([
                'url' => 'public/without-image.jpg'
            ]));
        });
    }
}
