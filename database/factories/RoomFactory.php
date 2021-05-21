<?php

namespace Database\Factories;

use App\Models\Hotel;
use App\Models\Category;
use App\Models\Room;
use Illuminate\Database\Eloquent\Factories\Factory;

class RoomFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Room::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'category_id' => Category::inRandomOrder()->value('id'),
            'number' => $this->faker->unique()->numberBetween($min = 300, $max = 320),
            'level' => rand(1, Hotel::inRandomOrder()->value('levels')),
            'location' => $this->faker->randomElement(['pasadiso', 'entrada', 'balcon']),
            'status' => 'available' //$this->faker->randomElement(['available', 'occupied', 'maintenance', 'cleaning', 'disabled']),
        ];
    }
}
