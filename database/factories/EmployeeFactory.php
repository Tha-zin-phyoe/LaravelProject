<?php


namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;




/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Employee>
 */
class EmployeeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    

    public function definition(): array
    {
        return [

            'fullname' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'phone' => fake()->phoneNumber(),
            'password' => bcrypt('password'),
            'photo' => fake()->imageUrl(),
            'position' => fake()->jobTitle(),
            'salary' => fake()->randomFloat(2, 1000, 10000),
        ];
    }
}
