<?php

namespace Database\Factories;

use App\Models\Exercise;
use App\Models\User;
use App\Models\Workout;
use Illuminate\Database\Eloquent\Factories\Factory;

class WorkoutFactory extends Factory
{
	protected $model = Workout::class;

	public function definition(): array
	{
		return [
			'user_id' => User::factory(),
            'coach_id' => '',
			'name' => $this->faker->randomElement(['Upper Body', 'Lower Body', 'Full Body', 'Cardio']) . ' Workout',
			'description' => $this->faker->sentence,
			'workout_date' => $this->faker->dateTimeBetween('-1 month', '+1 month'),
            'total_duration' => $this->faker->numberBetween(30, 120),
            'difficulty_level' => $this->faker->randomElement(['Beginner', 'Intermediate', 'Advanced']),
            'status' => $this->faker->randomElement(['planned', 'completed', 'skipped']),
            'notes' => $this->faker->optional(0.5)->sentence,
            'calories_burned' => $this->faker->optional(0.5)->numberBetween(100, 1000),
		];
	}
}
