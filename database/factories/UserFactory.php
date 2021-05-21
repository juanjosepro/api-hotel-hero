<?php

namespace Database\Factories;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = User::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'role_id' => Role::inRandomOrder()->value('id'),
            'name' =>  strtolower($this->faker->name),
            'last_name' => strtolower($this->faker->lastName),
            'dni' => $this->faker->ean8,
            'phone' => $this->faker->phoneNumber,
            'date_of_birth' => $this->faker->datetime($max = 'now'),
            'status' => "enabled", //$this->faker->randomElement(['enabled', 'disabled']),
            'email' => strtolower($this->faker->unique()->safeEmail),
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10),
        ];
    }
}
