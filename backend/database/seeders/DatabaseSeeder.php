<?php

namespace Database\Seeders;

use App\Models\Exercise;
use App\Models\User;
use App\Models\Workout;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
	public function run()
	{
		// Create sample users
		$users = User::factory()->createMany([
			[
				'name' => 'John Doe',
				'email' => 'john@example.com',
				'password' => Hash::make('password123'),
				'age' => 30,
				'height' => 180,
				'weight' => 80,
				'fitness_level' => 'intermediate'
			],
			[
				'name' => 'Jane Smith',
				'email' => 'jane@example.com',
				'password' => Hash::make('password123'),
				'age' => 28,
				'height' => 165,
				'weight' => 60,
				'fitness_level' => 'beginner'
			]
		]);

		// Create sample exercises
		$exercises = Exercise::factory()->createMany([
			[
				'name' => 'Bench Press',
				'description' => 'Flat bench press with barbell',
				'muscle_group' => 'chest',
				'equipment' => 'barbell',
				'difficulty' => 'intermediate'
			],
			[
				'name' => 'Squat',
				'description' => 'Barbell back squat',
				'muscle_group' => 'legs',
				'equipment' => 'barbell',
				'difficulty' => 'intermediate'
			],
			[
				'name' => 'Deadlift',
				'description' => 'Conventional deadlift',
				'muscle_group' => 'back',
				'equipment' => 'barbell',
				'difficulty' => 'advanced'
			],
			[
				'name' => 'Pull-up',
				'description' => 'Bodyweight pull-up',
				'muscle_group' => 'back',
				'equipment' => 'bodyweight',
				'difficulty' => 'intermediate'
			],
			[
				'name' => 'Push-up',
				'description' => 'Standard push-up',
				'muscle_group' => 'chest',
				'equipment' => 'bodyweight',
				'difficulty' => 'beginner'
			]
		]);

		// Create sample workouts
		$workouts = Workout::factory()->createMany([
			[
				'user_id' => $users[0]->_id,
				'name' => 'Upper Body Workout',
				'description' => 'Focus on chest and back',
				'date' => now()->subDays(2),
				'duration_minutes' => 60,
				'exercises' => [
					[
						'exercise_id' => $exercises[0]->_id,
						'sets' => 4,
						'reps' => 8,
						'weight_kg' => 60
					],
					[
						'exercise_id' => $exercises[3]->_id,
						'sets' => 3,
						'reps' => 10,
						'weight_kg' => null // bodyweight
					]
				]
			],
			[
				'user_id' => $users[0]->_id,
				'name' => 'Lower Body Workout',
				'description' => 'Leg day',
				'date' => now()->subDays(4),
				'duration_minutes' => 45,
				'exercises' => [
					[
						'exercise_id' => $exercises[1]->_id,
						'sets' => 5,
						'reps' => 5,
						'weight_kg' => 100
					]
				]
			],
			[
				'user_id' => $users[1]->_id,
				'name' => 'Beginner Full Body',
				'description' => 'First workout',
				'date' => now()->subDays(1),
				'duration_minutes' => 30,
				'exercises' => [
					[
						'exercise_id' => $exercises[4]->_id,
						'sets' => 3,
						'reps' => 12,
						'weight_kg' => null
					],
					[
						'exercise_id' => $exercises[3]->_id,
						'sets' => 2,
						'reps' => 8,
						'weight_kg' => null
					]
				]
			]
		]);
	}
}
