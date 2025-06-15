<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Exercise;
use App\Models\Article;
use App\Models\NewsArticle;
use App\Models\Workout;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
	public function run(): void
	{
		// Create admin user
		User::factory()->create([
			'name' => 'Admin User',
			'email' => 'admin@fittracker.com',
			'password' => Hash::make('password'),
			'fitness_level' => 'advanced',
			'goals' => ['weight_loss', 'muscle_gain'],
			'age' => 30,
			'weight' => 70,
			'height' => 175
		]);

		// Create sample users
		$users = User::factory()->createMany([
			[
				'name' => 'John Doe',
				'email' => 'john@example.com',
				'password' => 1234,
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
				'name' => 'Push-ups',
				'description' => 'A basic upper body exercise targeting chest, shoulders, and triceps.',
				'category' => 'strength',
				'muscle_groups' => ['chest', 'shoulders', 'triceps'],
				'equipment_needed' => [],
				'difficulty_level' => 'beginner',
				'instructions' => [
					'Start in a plank position with hands shoulder-width apart',
					'Lower your body until your chest nearly touches the floor',
					'Push back up to the starting position',
					'Repeat for desired reps'
				],
				'calories_per_minute' => 8,
				'is_active' => true
			],
			[
				'name' => 'Pull-ups',
				'description' => 'Upper body exercise targeting back and biceps.',
				'category' => 'strength',
				'muscle_groups' => ['back', 'biceps'],
				'equipment_needed' => ['pull_up_bar'],
				'difficulty_level' => 'intermediate',
				'instructions' => [
					'Hang from a pull-up bar with palms facing away',
					'Pull your body up until your chin is above the bar',
					'Lower yourself back down with control',
					'Repeat for desired reps'
				],
				'calories_per_minute' => 10,
				'is_active' => true
			],
			[
				'name' => 'Squats',
				'description' => 'Lower body exercise targeting quadriceps, glutes, and hamstrings.',
				'category' => 'strength',
				'muscle_groups' => ['quadriceps', 'glutes', 'hamstrings'],
				'equipment_needed' => [],
				'difficulty_level' => 'beginner',
				'instructions' => [
					'Stand with feet shoulder-width apart',
					'Lower your body as if sitting back into a chair',
					'Keep your chest up and knees over your toes',
					'Return to standing position'
				],
				'calories_per_minute' => 6,
				'is_active' => true
			],
			[
				'name' => 'Planks',
				'description' => 'Core strengthening exercise.',
				'category' => 'core',
				'muscle_groups' => ['core', 'shoulders'],
				'equipment_needed' => [],
				'difficulty_level' => 'beginner',
				'instructions' => [
					'Start in a push-up position',
					'Lower onto your forearms',
					'Keep your body in a straight line',
					'Hold for desired time'
				],
				'calories_per_minute' => 4,
				'is_active' => true
			],
			[
				'name' => 'Burpees',
				'description' => 'Full-body exercise combining strength and cardio.',
				'category' => 'cardio',
				'muscle_groups' => ['full_body'],
				'equipment_needed' => [],
				'difficulty_level' => 'advanced',
				'instructions' => [
					'Start standing, then squat down and place hands on floor',
					'Jump feet back into plank position',
					'Do a push-up (optional)',
					'Jump feet back to squat position',
					'Jump up with arms overhead'
				],
				'calories_per_minute' => 12,
				'is_active' => true
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


		// Create blog articles
		$articles = Article::factory()->createMany([
			[
				'user_id' => '1',
				'title' => '10 Best Exercises for Building Core Strength',
				'slug' => '10-best-exercises-building-core-strength',
				'excerpt' => 'Discover the most effective exercises to strengthen your core and improve your overall fitness performance.',
				'content' => 'Core strength is fundamental to overall fitness and daily activities. Here are the 10 most effective exercises to build a strong, stable core...',
				'category' => 'fitness',
				'tags' => ['core', 'strength', 'exercises'],
				'published_at' => now()->subDays(1),
				'status' => 'published',
				'views' => 150,
				'likes' => 25,
				'is_featured' => true
			],
			[
				'user_id' => '1',
				'title' => 'The Science Behind Post-Workout Nutrition',
				'slug' => 'science-behind-post-workout-nutrition',
				'excerpt' => 'Learn how to fuel your body properly after intense training sessions for optimal recovery and results.',
				'content' => 'Proper post-workout nutrition is crucial for recovery, muscle growth, and replenishing energy stores...',
				'category' => 'nutrition',
				'tags' => ['nutrition', 'recovery', 'post-workout'],
				'published_at' => now()->subDays(2),
				'status' => 'published',
				'views' => 89,
				'likes' => 15,
				'is_featured' => false
			]
		]);

		// Create news articles
		$newsArticles = NewsArticle::factory()->createMany([
			[
				'title' => 'New Study Reveals Benefits of Morning Workouts',
				'slug' => 'new-study-morning-workouts-benefits',
				'excerpt' => 'Recent research shows that exercising in the morning can boost metabolism and improve mood throughout the day.',
				'content' => 'A comprehensive study published in the Journal of Health Psychology reveals significant benefits...',
				'category' => 'fitness',
				'tags' => ['study', 'morning', 'metabolism'],
				'author_name' => 'Dr. Sarah Johnson',
				'published_at' => now()->subHours(6),
				'status' => 'published',
				'views' => 75,
				'is_breaking' => false
			],
			[
				'title' => 'AI-Powered Workout Apps See 300% Growth',
				'slug' => 'ai-powered-workout-apps-growth',
				'excerpt' => 'The fitness technology sector experiences unprecedented growth as users embrace AI-driven personal training.',
				'content' => 'The integration of artificial intelligence in fitness applications has revolutionized how people approach their workout routines...',
				'category' => 'technology',
				'tags' => ['AI', 'technology', 'fitness apps'],
				'author_name' => 'Tech Reporter',
				'published_at' => now()->subHours(12),
				'status' => 'published',
				'views' => 120,
				'is_breaking' => true
			]
		]);

	}
}
