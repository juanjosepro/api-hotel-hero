<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Image;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Category::factory(5)->create()->each(function ($category) {
            $category->image()->save(Image::factory()->make([
                'url' => 'public/without-image.jpg'
            ]));
        });
    }
}
