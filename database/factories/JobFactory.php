<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Job>
 */
class JobFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
        'title'=>fake()->name,
        'location'=>fake()->city,
        'description'=>fake()->text,
        'company_name'=>fake()->name,
        'experience'=>rand(1,10),
        'vacancy'=>rand(1,10),
         'category_id'=>rand(1,5),
         'user_id'=>rand(15,18),
         'job_type_id'=>rand(1,5)
        ];
    }
}