<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Workout;
use App\Models\WorkoutSession;
use Illuminate\Database\Eloquent\Factories\Factory;

class WorkoutSessionFactory extends Factory
{

	protected $model = WorkoutSession::class;

    /**
     * @inheritDoc
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'workout_id' => Workout::factory(),
            'started_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
            'completed_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
            'duration' => $this->faker->numberBetween(1, 60),
            'calories_burned' => $this->faker->numberBetween(100, 500),
            'exercises_completed' => $this->faker->numberBetween(1, 10),
            'total_exercises' => $this->faker->numberBetween(1, 10),
            'notes' => $this->faker->paragraphs($this->faker->numberBetween(1, 3), true),
            'rating' => $this->faker->numberBetween(1, 5)
		];
    }
}
