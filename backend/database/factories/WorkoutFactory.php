<?php

namespace Database\Factories;

use App\Models\Exercise;
use App\Models\User;
use App\Models\Workout;
use Illuminate\Database\Eloquent\Factories\Factory;

class WorkoutFactory extends Factory
{
	protected $model = Workout::class;

	public function definition()
	{
		return [
			'user_id' => User::factory(),
			'name' => $this->faker->randomElement(['Upper Body', 'Lower Body', 'Full Body', 'Cardio']) . ' Workout',
			'description' => $this->faker->sentence,
			'date' => $this->faker->dateTimeBetween('-1 month', 'now'),
			'duration_minutes' => $this->faker->numberBetween(20, 90),
			'exercises' => [
				[
					'exercise_id' => Exercise::factory(),
					'sets' => $this->faker->numberBetween(3, 5),
					'reps' => $this->faker->numberBetween(5, 12),
					'weight_kg' => $this->faker->optional(0.7)->numberBetween(5, 100) // 70% chance of having weight
				],
				[
					'exercise_id' => Exercise::factory(),
					'sets' => $this->faker->numberBetween(2, 4),
					'reps' => $this->faker->numberBetween(8, 15),
					'weight_kg' => $this->faker->optional(0.5)->numberBetween(5, 80) // 50% chance of having weight
				],
				[
					'exercise_id' => Exercise::factory(),
					'sets' => $this->faker->numberBetween(1, 3),
					'reps' => $this->faker->numberBetween(10, 20),
					'weight_kg' => null // bodyweight exercise
				]
			]
		];
	}
}
