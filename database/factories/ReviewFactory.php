<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Review>
 */
class ReviewFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'rating' => fake()->numberBetween(1,5),
            'review' => fake()->paragraph(4),
            'book_id' => null,
            'created_at' => fake()->dateTimeBetween('-2 years'),
            'updated_at' => function(array $attributes){
                return fake()->dateTimeBetween($attributes['created_at']);
            }
        ];
    }

    public function goodRate(){
        return $this->state(function (array $attributes){
            return [
                'rating' => fake()->numberBetween(4,5),
            ];
        });
    }

    public function averageRate(){
        return $this->state(function (array $attributes){
            return [
                'rating' => fake()->numberBetween(2,5),
            ];
        });
    }

    public function badRate(){
        return $this->state(function (array $attributes){
            return [
                'rating' => fake()->numberBetween(1,3),
            ];
        });
    }
}
