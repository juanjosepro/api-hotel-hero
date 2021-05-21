<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Reservation;
use App\Models\Room;
use Illuminate\Database\Eloquent\Factories\Factory;

class ReservationFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Reservation::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'room_number' => Room::inRandomOrder()->value('number'),
            'via' => $this->faker->randomElement(['hotel', 'web', 'call', 'whatsapp', 'facebook', 'other']),
            'name' => $this->faker->name,
            'last_name' => $this->faker->lastName,
            'phone' => $this->faker->phoneNumber,
            'persons' => rand(1, 3),
            'email' => $this->faker->safeEmail,
            'entry_date' => $this->faker->dateTimeBetween($startDate = 'now', $endDate = 'now', $timezone = null),
            'departure_date' => $this->faker->dateTimeBetween($startDate = 'now', $endDate = '+5 days', $timezone = null),
            'message' => $this->faker->sentence,
        ];
    }
}
