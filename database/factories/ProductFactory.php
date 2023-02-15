<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'title' => $this->faker->word,
            'description' => $this->faker->text(200),
            'date'=> $this->faker->date,
            'price' => $this->faker->numberBetween(0, 1000),
            'size' => $this->faker->text(5),
            'genre' => $this->faker->word,
            'image_id' => $this->faker->word,
        ];
    }
}
