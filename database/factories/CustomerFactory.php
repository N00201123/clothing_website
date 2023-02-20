<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Customer>
 */
class CustomerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'first_name' => $this->faker->firstName,
            'last_name' =>$this->faker->lastName,
            'email' => $this->faker->email,
            'phone' => $this->faker->numberBetween(1000000, 9999999),
            'address' => $this->faker->streetAddress
        ];
    }
}
