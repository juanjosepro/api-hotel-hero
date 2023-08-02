<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

class CategoryFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Category::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->unique()->randomElement([
                'matrimonial',
                'doble',
                'premiun',
                'personal',
                'triple',
            ]),
            'price' => $this->faker->randomFloat($nbMaxDecimals = 2, $min = 50, $max = 250),
            'details' => 'tv satelital,internet wifi,estacionamiento,aire acondicionado,teléfono,vista al jardín',
        ];
    }
}
