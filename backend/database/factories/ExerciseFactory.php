<?php

namespace Database\Factories;

use App\Models\Exercise;
use Illuminate\Database\Eloquent\Factories\Factory;

class ExerciseFactory extends Factory
{

	protected $model = Exercise::class;

    /**
     * @inheritDoc
     */
    public function definition()
    {
        return [
			'name' => $this->faker->word,
			'description' => $this->faker->sentence,
			'category' => $this->faker->randomElement(['Strength', 'Cardio', 'Flexibility']),
			'muscle_groups' => $this->faker->randomElements(['Chest', 'Back', 'Legs', 'Arms', 'Shoulders'], $this->faker->numberBetween(1, 3)),
			'equipment_needed' => $this->faker->randomElements(['Dumbbell', 'Barbell', 'Bodyweight', 'Machine'], $this->faker->numberBetween(0, 2)),
			'difficulty_level' => $this->faker->randomElement(['beginner', 'intermediate', 'advanced']),
			'instructions' => $this->faker->paragraphs($this->faker->numberBetween(2, 5), true),
			'calories_per_minute' => $this->faker->numberBetween(5, 15),
			'is_active' => $this->faker->boolean(80), // 80% chance of being active
			'created_at' => now(),
			'updated_at' => now(),
		];
    }
}
