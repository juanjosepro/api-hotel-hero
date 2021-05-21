<?php

namespace Database\Factories;

use App\Models\Guest;
use Illuminate\Database\Eloquent\Factories\Factory;

class GuestFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Guest::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'room_number' => rand(1, 20),
            'name' => $this->faker->name,
            'last_name' => $this->faker->lastName,
            'dni' => $this->faker->ean8,
            'phone' => $this->faker->phoneNumber,
            'email' => $this->faker->safeEmail,
            'persons' => rand(1, 3),
            'entry_date' => $this->faker->dateTimeBetween($startDate = 'now', $endDate = 'now', $timezone = null),
            'departure_date' => $this->faker->dateTimeBetween($startDate = 'now', $endDate = '+5 days', $timezone = null),
            'status' => $this->faker->randomElement(['hosped', 'retired']),
            'origin' => $this->faker->sentence,
            'message' => $this->faker->sentence,
            'via' => $this->faker->randomElement(['hotel', 'web', 'call', 'whatsapp', 'facebook', 'other']),
        ];
    }
}
