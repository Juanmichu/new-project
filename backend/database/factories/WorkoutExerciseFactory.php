<?php

namespace Database\Factories;

use App\Models\Exercise;
use App\Models\User;
use App\Models\Workout;
use App\Models\WorkoutExercise;
use Illuminate\Database\Eloquent\Factories\Factory;

class WorkoutExerciseFactory extends Factory
{
	protected $model = WorkoutExercise::class;

	public function definition(): array
    {
		return [
			'user_id' => User::factory(),
            'workout_id' => Workout::factory(),
			'exercise_id' => Exercise::factory(),
			'sets' => $this->faker->numberBetween(3, 5),
			'reps' => $this->faker->numberBetween(5, 12),
            'weight' => $this->faker->numberBetween(10, 100),
            'duration' => $this->faker->optional(1)->numberBetween(30, 300),
            'rest_time' => $this->faker->numberBetween(30, 120),
            'order' => $this->faker->numberBetween(1, 10),
            'notes' => $this->faker->optional(0.5)->sentence,
            'completed' => $this->faker->boolean(50), // 70% chance of being completed
		];
	}
}

