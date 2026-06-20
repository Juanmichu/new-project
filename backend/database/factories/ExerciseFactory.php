<?php

namespace Database\Factories;

use App\Http\Constants\Exercises;
use App\Models\Exercise;
use Illuminate\Database\Eloquent\Factories\Factory;

class ExerciseFactory extends Factory
{

    protected $model = Exercise::class;

    /**
     * @inheritDoc
     */
    public function definition(): array
    {
        return [
            'name'              => $this->faker->word,
            'description'       => $this->faker->sentence,
            'category'          => $this->faker->randomElement(Exercises::CATEGORIES),
            'muscle_groups'     => $this->faker->randomElements(Exercises::MUSCLE_GROUPS, $this->faker->numberBetween(1, 3)),
            'equipment_needed'  => $this->faker->randomElements(Exercises::EQUIPMENT_TYPES, $this->faker->numberBetween(0, 2)),
            'difficulty_level'  => $this->faker->randomElement(Exercises::DIFFICULTY_LEVELS),
            'instructions'      => $this->faker->paragraphs($this->faker->numberBetween(2, 5), true),
            'calories_per_minute' => $this->faker->numberBetween(5, 15),
            'is_active'         => $this->faker->boolean(80), // 80% chance of being active
            'is_favorite'       => $this->faker->boolean(),
            'created_at'        => now(),
            'updated_at'        => now(),
        ];
    }
}
