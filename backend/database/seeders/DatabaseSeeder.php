<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Exercise;
use App\Models\Article;
use App\Models\NewsArticle;
use App\Models\Workout;
use App\Models\WorkoutExercise;
use App\Models\WorkoutSession;
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
			],
            [
                'name' => 'Mike Johnson',
                'email' => 'mike@example.com',
                'password' => Hash::make('password123'),
                'age' => 35,
                'height' => 175,
                'weight' => 75,
                'fitness_level' => 'intermediate'
            ],
            [
                'name' => 'Emily Davis',
                'email' => 'emily@example.com',
                'password' => Hash::make('password123'),
                'age' => 29,
                'height' => 168,
                'weight' => 65,
                'fitness_level' => 'intermediate'
            ],
            [
                'name' => 'David Wilson',
                'email' => 'david@example.com',
                'password' => Hash::make('password123'),
                'age' => 32,
                'height' => 180,
                'weight' => 85,
                'fitness_level' => 'advanced'
            ]
		]);

		// Create sample exercises
		$exercises = Exercise::factory()->createMany([
			[
				'name' => 'Push-ups',
				'description' => 'A basic upper body exercise targeting chest, shoulders, and triceps.',
				'category' => 'Strength',
				'muscle_groups' => ['Chest', 'Shoulders', 'Triceps'],
				'equipment_needed' => [],
				'difficulty_level' => 'Beginner',
				'instructions' => [
					'Start in a plank position with hands shoulder-width apart',
					'Lower your body until your chest nearly touches the floor',
					'Push back up to the starting position',
					'Repeat for desired reps'
				],
                'recommendations' => [
                    'repetitions' => '8-15 reps',
                    'sets' => '3-4 series',
                    'rest' => '60-90 seconds between sets',
                    'frequency' => '2-3 times per week'
                ],
				'calories_per_minute' => 8,
				'is_active' => true,
                'is_favorite' => false
			],
			[
				'name' => 'Pull-ups',
				'description' => 'Upper body exercise targeting back and biceps.',
				'category' => 'Strength',
				'muscle_groups' => ['Back', 'Biceps'],
				'equipment_needed' => ['Pull Up Bar'],
				'difficulty_level' => 'Intermediate',
				'instructions' => [
					'Hang from a pull-up bar with palms facing away',
					'Pull your body up until your chin is above the bar',
					'Lower yourself back down with control',
					'Repeat for desired reps'
				],
                'recommendations' => [
                    'repetitions' => '6-12 reps',
                    'sets' => '3-4 series',
                    'rest' => '90-120 seconds between sets',
                    'frequency' => '2-3 times per week'
                ],
				'calories_per_minute' => 10,
				'is_active' => true,
                'is_favorite' => false
			],
			[
				'name' => 'Squats',
				'description' => 'Lower body exercise targeting quadriceps, glutes, and hamstrings.',
				'category' => 'Strength',
				'muscle_groups' => ['Quadriceps', 'Glutes', 'Hamstrings'],
				'equipment_needed' => [],
				'difficulty_level' => 'Beginner',
				'instructions' => [
					'Stand with feet shoulder-width apart',
					'Lower your body as if sitting back into a chair',
					'Keep your chest up and knees over your toes',
					'Return to standing position'
				],
                'recommendations' => [
                    'repetitions' => '10-20 reps',
                    'sets' => '3-4 series',
                    'rest' => '60-90 seconds between sets',
                    'frequency' => '2-3 times per week'
                ],
				'calories_per_minute' => 6,
				'is_active' => true,
                'is_favorite' => false
			],
			[
				'name' => 'Planks',
				'description' => 'Core strengthening exercise.',
				'category' => 'Core',
				'muscle_groups' => ['Core', 'Shoulders'],
				'equipment_needed' => [],
				'difficulty_level' => 'Beginner',
				'instructions' => [
					'Start in a push-up position',
					'Lower onto your forearms',
					'Keep your body in a straight line',
					'Hold for desired time'
				],
                'recommendations' => [
                    'repetitions' => '30-60 seconds',
                    'sets' => '3-4 series',
                    'rest' => '30-60 seconds between sets',
                    'frequency' => '3-4 times per week'
                ],
				'calories_per_minute' => 4,
				'is_active' => true,
                'is_favorite' => false
			],
			[
				'name' => 'Burpees',
				'description' => 'Full-body exercise combining strength and cardio.',
				'category' => 'Cardio',
				'muscle_groups' => ['Full Body'],
				'equipment_needed' => [],
				'difficulty_level' => 'Advanced',
				'instructions' => [
					'Start standing, then squat down and place hands on floor',
					'Jump feet back into plank position',
					'Do a push-up (optional)',
					'Jump feet back to squat position',
					'Jump up with arms overhead'
				],
                'recommendations' => [
                    'repetitions' => '10-15 reps',
                    'sets' => '3-4 series',
                    'rest' => '60-90 seconds between sets',
                    'frequency' => '2-3 times per week'
                ],
				'calories_per_minute' => 12,
				'is_active' => true,
                'is_favorite' => false
			],
            [
                'name' => 'Lunges',
                'description' => 'Lower body exercise targeting quadriceps, glutes, and hamstrings.',
                'category' => 'Strength',
                'muscle_groups' => ['Quadriceps', 'Glutes', 'Hamstrings'],
                'equipment_needed' => [],
                'difficulty_level' => 'Beginner',
                'instructions' => [
                    'Stand with feet together',
                    'Step forward with one leg and lower your hips until both knees are bent at about 90 degrees',
                    'Return to starting position and switch legs',
                    'Repeat for desired reps'
                ],
                'recommendations' => [
                    'repetitions' => '10-15 reps per leg',
                    'sets' => '3-4 series',
                    'rest' => '60-90 seconds between sets',
                    'frequency' => '2-3 times per week'
                ],
                'calories_per_minute' => 6,
                'is_active' => true,
                'is_favorite' => false
            ],
            [
                'name' => 'Jumping Jacks',
                'description' => 'Cardio exercise that increases heart rate and burns calories.',
                'category' => 'Cardio',
                'muscle_groups' => ['Full Body'],
                'equipment_needed' => [],
                'difficulty_level' => 'Beginner',
                'instructions' => [
                    'Stand upright with feet together and arms at your sides',
                    'Jump up, spreading your legs shoulder-width apart while raising your arms overhead',
                    'Jump back to starting position',
                    'Repeat for desired reps'
                ],
                'recommendations' => [
                    'repetitions' => '30-60 seconds',
                    'sets' => '3-4 series',
                    'rest' => '30-60 seconds between sets',
                    'frequency' => '3-4 times per week'
                ],
                'calories_per_minute' => 8,
                'is_active' => true,
                'is_favorite' => false
            ],
            [
                'name' => 'Mountain Climbers',
                'description' => 'Cardio and core exercise that increases heart rate and strengthens the core.',
                'category' => 'Cardio',
                'muscle_groups' => ['Core', 'Legs', 'Shoulders'],
                'equipment_needed' => [],
                'difficulty_level' => 'Intermediate',
                'instructions' => [
                    'Start in a plank position with arms straight',
                    'Bring one knee towards your chest, then switch legs quickly as if running in place',
                    'Keep your core tight and back straight',
                    'Repeat for desired time'
                ],
                'recommendations' => [
                    'repetitions' => '30-60 seconds',
                    'sets' => '3-4 series',
                    'rest' => '30-60 seconds between sets',
                    'frequency' => '3-4 times per week'
                ],
                'calories_per_minute' => 10,
                'is_active' => true,
                'is_favorite' => false
            ],
            [
                'name' => 'Bicycle Crunches',
                'description' => 'Core exercise that targets the abdominal muscles.',
                'category' => 'Core',
                'muscle_groups' => ['Abdominals', 'Obliques'],
                'equipment_needed' => [],
                'difficulty_level' => 'Intermediate',
                'instructions' => [
                    'Lie flat on your back with hands behind your head and legs lifted off the ground',
                    'Bring one knee towards your chest while simultaneously twisting your torso to bring the opposite elbow towards that knee',
                    'Switch sides in a pedaling motion',
                    'Repeat for desired reps'
                ],
                'recommendations' => [
                    'repetitions' => '15-20 reps per side',
                    'sets' => '3-4 series',
                    'rest' => '30-60 seconds between sets',
                    'frequency' => '3-4 times per week'
                ],
                'calories_per_minute' => 8,
                'is_active' => true,
                'is_favorite' => false
            ],
            [
                'name' => 'Russian Twists',
                'description' => 'Core exercise that targets the oblique muscles.',
                'category' => 'Core',
                'muscle_groups' => ['Obliques', 'Abdominals'],
                'equipment_needed' => ['Optional: Medicine Ball or Dumbbell'],
                'difficulty_level' => 'Intermediate',
                'instructions' => [
                    'Sit on the floor with knees bent and feet flat',
                    'Lean back slightly while keeping your back straight',
                    'Hold your hands together or a weight in front of you',
                    'Twist your torso to the right, then to the left, while keeping your core engaged',
                    'Repeat for desired reps'
                ],
                'recommendations' => [
                    'repetitions' => '15-20 reps per side',
                    'sets' => '3-4 series',
                    'rest' => '30-60 seconds between sets',
                    'frequency' => '3-4 times per week'
                ],
                'calories_per_minute' => 7,
                'is_active' => true,
                'is_favorite' => false
            ],
            [
                'name' => 'RDL (Romanian Deadlift)',
                'description' => 'Strength exercise that targets the hamstrings, glutes, and lower back.',
                'category' => 'Strength',
                'muscle_groups' => ['Hamstrings', 'Glutes', 'Lower Back'],
                'equipment_needed' => ['Dumbbells or Barbell'],
                'difficulty_level' => 'Intermediate',
                'instructions' => [
                    'Stand with feet hip-width apart, holding dumbbells or a barbell in front of your thighs',
                    'Keep a slight bend in your knees and hinge at the hips to lower the weights down the front of your legs',
                    'Lower until you feel a stretch in your hamstrings, then return to the starting position by driving your hips forward',
                    'Keep your back straight and core engaged throughout the movement',
                    'Repeat for desired reps'
                ],
                'recommendations' => [
                    'repetitions' => '8-12 reps',
                    'sets' => '3-4 series',
                    'rest' => '60-90 seconds between sets',
                    'frequency' => '2-3 times per week'
                ],
                'calories_per_minute' => 5,
                'is_active' => true,
                'is_favorite' => false
            ]
		]);

		// Create sample workouts
		$workouts = Workout::factory()->createMany([
            [
                'user_id' => $users[0]->_id,
                'name' => 'Upper Body Workout',
                'description' => 'Focus on chest and back',
                'workout_date' => now(),
                'total_duration' => 60,
                'difficulty_level' => 'Intermediate',
                'status' => 'planned',
                'notes' => 'Remember to warm up before starting the workout.',
                'calories_burned' => 400
            ],
			[
				'user_id' => $users[0]->_id,
				'name' => 'Upper Body Workout',
				'description' => 'Focus on chest and back',
				'workout_date' => now()->addDays(2),
				'total_duration' => 60,
				'difficulty_level' => 'Intermediate',
                'status' => 'planned',
                'notes' => 'Remember to warm up before starting the workout.',
                'calories_burned' => 400
			],
			[
				'user_id' => $users[0]->_id,
				'name' => 'Lower Body Workout',
				'description' => 'Leg day',
				'workout_date' => now()->addDays(4),
				'total_duration' => 45,
                'difficulty_level' => 'Intermediate',
                'status' => 'planned',
                'notes' => 'Focus on form and depth during squats.',
                'calories_burned' => 350
			],
            [
                'user_id' => $users[0]->_id,
                'name' => 'Full Body Workout',
                'description' => 'Full body strength and conditioning',
                'workout_date' => now()->addDays(6),
                'total_duration' => 55,
                'difficulty_level' => 'Advanced',
                'status' => 'planned',
                'notes' => 'Include a mix of strength and cardio exercises.',
                'calories_burned' => 500
            ],
            [
                'user_id' => $users[1]->_id,
                'name' => 'Upper Body Workout',
                'description' => 'Focus on chest and back',
                'workout_date' => now(),
                'total_duration' => 60,
                'difficulty_level' => 'Intermediate',
                'status' => 'planned',
                'notes' => 'Remember to warm up before starting the workout.',
                'calories_burned' => 400
            ],
            [
                'user_id' => $users[1]->_id,
                'name' => 'Upper Body Workout',
                'description' => 'Focus on chest and back',
                'workout_date' => now()->addDays(2),
                'total_duration' => 60,
                'difficulty_level' => 'Intermediate',
                'status' => 'planned',
                'notes' => 'Remember to warm up before starting the workout.',
                'calories_burned' => 400
            ],
            [
                'user_id' => $users[1]->_id,
                'name' => 'Lower Body Workout',
                'description' => 'Leg day',
                'workout_date' => now()->addDays(4),
                'total_duration' => 45,
                'difficulty_level' => 'Intermediate',
                'status' => 'planned',
                'notes' => 'Focus on form and depth during squats.',
                'calories_burned' => 350
            ],
            [
                'user_id' => $users[1]->_id,
                'name' => 'Full Body Workout',
                'description' => 'Full body strength and conditioning',
                'workout_date' => now()->addDays(6),
                'total_duration' => 55,
                'difficulty_level' => 'Advanced',
                'status' => 'planned',
                'notes' => 'Include a mix of strength and cardio exercises.',
                'calories_burned' => 500
            ],
            [
                'user_id' => $users[2]->_id,
                'name' => 'Upper Body Workout',
                'description' => 'Focus on chest and back',
                'workout_date' => now(),
                'total_duration' => 60,
                'difficulty_level' => 'Intermediate',
                'status' => 'planned',
                'notes' => 'Remember to warm up before starting the workout.',
                'calories_burned' => 400
            ],
            [
                'user_id' => $users[2]->_id,
                'name' => 'Upper Body Workout',
                'description' => 'Focus on chest and back',
                'workout_date' => now()->addDays(2),
                'total_duration' => 60,
                'difficulty_level' => 'Intermediate',
                'status' => 'planned',
                'notes' => 'Remember to warm up before starting the workout.',
                'calories_burned' => 400
            ],
            [
                'user_id' => $users[2]->_id,
                'name' => 'Lower Body Workout',
                'description' => 'Leg day',
                'workout_date' => now()->addDays(4),
                'total_duration' => 45,
                'difficulty_level' => 'Intermediate',
                'status' => 'planned',
                'notes' => 'Focus on form and depth during squats.',
                'calories_burned' => 350
            ],
            [
                'user_id' => $users[2]->_id,
                'name' => 'Full Body Workout',
                'description' => 'Full body strength and conditioning',
                'workout_date' => now()->addDays(6),
                'total_duration' => 55,
                'difficulty_level' => 'Advanced',
                'status' => 'planned',
                'notes' => 'Include a mix of strength and cardio exercises.',
                'calories_burned' => 500
            ],
            [
                'user_id' => $users[3]->_id,
                'name' => 'Upper Body Workout',
                'description' => 'Focus on chest and back',
                'workout_date' => now(),
                'total_duration' => 60,
                'difficulty_level' => 'Intermediate',
                'status' => 'planned',
                'notes' => 'Remember to warm up before starting the workout.',
                'calories_burned' => 400
            ],
            [
                'user_id' => $users[3]->_id,
                'name' => 'Upper Body Workout',
                'description' => 'Focus on chest and back',
                'workout_date' => now()->addDays(2),
                'total_duration' => 60,
                'difficulty_level' => 'Intermediate',
                'status' => 'planned',
                'notes' => 'Remember to warm up before starting the workout.',
                'calories_burned' => 400
            ],
            [
                'user_id' => $users[3]->_id,
                'name' => 'Lower Body Workout',
                'description' => 'Leg day',
                'workout_date' => now()->addDays(4),
                'total_duration' => 45,
                'difficulty_level' => 'Intermediate',
                'status' => 'planned',
                'notes' => 'Focus on form and depth during squats.',
                'calories_burned' => 350
            ],
            [
                'user_id' => $users[3]->_id,
                'name' => 'Full Body Workout',
                'description' => 'Full body strength and conditioning',
                'workout_date' => now()->addDays(6),
                'total_duration' => 55,
                'difficulty_level' => 'Advanced',
                'status' => 'planned',
                'notes' => 'Include a mix of strength and cardio exercises.',
                'calories_burned' => 500
            ],
            [
                'user_id' => $users[4]->_id,
                'name' => 'Full Body Workout',
                'description' => 'Full body strength and conditioning',
                'workout_date' => now()->subDays(2),
                'total_duration' => 55,
                'difficulty_level' => 'Advanced',
                'status' => 'completed',
                'notes' => 'Include a mix of strength and cardio exercises.',
                'calories_burned' => 500
            ],
            [
                'user_id' => $users[4]->_id,
                'name' => 'Upper Body Workout',
                'description' => 'Focus on chest and back',
                'workout_date' => now()->subDays(4),
                'total_duration' => 60,
                'difficulty_level' => 'Intermediate',
                'status' => 'completed',
                'notes' => 'Remember to warm up before starting the workout.',
                'calories_burned' => 400
            ],
            [
                'user_id' => $users[4]->_id,
                'name' => 'Upper Body Workout',
                'description' => 'Focus on chest and back',
                'workout_date' => now()->subDays(6),
                'total_duration' => 60,
                'difficulty_level' => 'Intermediate',
                'status' => 'completed',
                'notes' => 'Remember to warm up before starting the workout.',
                'calories_burned' => 400
            ],
            [
                'user_id' => $users[4]->_id,
                'name' => 'Lower Body Workout',
                'description' => 'Leg day',
                'workout_date' => now(),
                'total_duration' => 45,
                'difficulty_level' => 'Intermediate',
                'status' => 'planned',
                'notes' => 'Focus on form and depth during squats.',
                'calories_burned' => 350
            ],
		]);

        // For each workout we will insert 5 exercises where sets and repts are randomly generated. Sets will
        // have numbers from 3 to 5, and reps will have numbers from 8 to 15.
        // The exercises will be randomly selected from the exercises's collection.
        // The exercises will be inserted into the exercises's collection with the workout_id as a reference to the workout they belong to.
        $workoutsExercisesData = [];
        $completedDavidWorkouts = [];
        /** @var Workout $workout */
        foreach($workouts as $workout) {
            $exerciseIds = $exercises->random(5)->pluck('_id')->toArray();
            $completedExercise = $workout->user()->first()->email == 'david@example.com' && $workout->status == 'completed';
            // Save completed WODs for later to create a session
            if($completedExercise) {
                $completedDavidWorkouts[] = $workout;
            }
            foreach($exerciseIds as $index => $exerciseId) {
                $workoutsExercisesData[] = [
                    'workout_id' => $workout->_id,
                    'exercise_id' => $exerciseId,
                    'sets' => rand(3, 5),
                    'reps' => rand(8, 15),
                    'rest_time' => rand(30, 90),
                    'order' => $index + 1,
                    'completed' => $completedExercise
                ];
            }
        }

        $workout_exercises = WorkoutExercise::factory()->createMany($workoutsExercisesData);

        // Create completed sessions for user David Wilson to mock this behavior on frontend and check it
        $sessions = [];
        foreach($completedDavidWorkouts as $davidWorkout) {
            $totalExercises = $davidWorkout->exercises->count();
            $completedExercises = $davidWorkout->exercises->where('completed', true)->count();
            $sessions[] = [
                'user_id' => $davidWorkout->user_id,
                'workout_id' => $davidWorkout->_id,
                'started_at' => $davidWorkout->created_at ?? now(),
                'completed_at' => $davidWorkout->workout_date ?? now(),
                'duration' => $davidWorkout->total_duration ?? 0,
                'calories_burned' => $davidWorkout->calories_burned ?? 0,
                'exercises_completed' => $completedExercises,
                'total_exercises' => $totalExercises,
            ];
        }

        WorkoutSession::factory()->createMany($sessions);

		// Create blog articles
		$articles = Article::factory()->createMany([
			[
				'title' => '10 Best Exercises for Building Core Strength',
				'slug' => '10-best-exercises-building-core-strength',
				'excerpt' => 'Discover the most effective exercises to strengthen your core and improve your overall fitness performance.',
				'content' => 'Core strength is fundamental to overall fitness and daily activities. Here are the 10 most effective exercises to build a strong, stable core...',
				'category' => 'Fitness',
				'tags' => ['Core', 'Strength', 'Exercises'],
				'published_at' => now()->subDays(1),
				'status' => 'published',
				'views' => 150,
				'likes' => 25,
				'is_featured' => true,
                'author' => 'John Doe',
                'reading_time' => '5 min'
			],
			[
				'title' => 'The Science Behind Post-Workout Nutrition',
				'slug' => 'science-behind-post-workout-nutrition',
				'excerpt' => 'Learn how to fuel your body properly after intense training sessions for optimal recovery and results.',
				'content' => 'Proper post-workout nutrition is crucial for recovery, muscle growth, and replenishing energy stores...',
				'category' => 'Nutrition',
				'tags' => ['Nutrition', 'Recovery', 'Post-Workout'],
				'published_at' => now()->subDays(2),
				'status' => 'published',
				'views' => 89,
				'likes' => 15,
				'is_featured' => false,
                'author' => 'Jane Smith',
                'reading_time' => '3 min'
			]
		]);

		// Create news articles
		$newsArticles = NewsArticle::factory()->createMany([
			[
				'title' => 'New Study Reveals Benefits of Morning Workouts',
				'slug' => 'new-study-morning-workouts-benefits',
				'excerpt' => 'Recent research shows that exercising in the morning can boost metabolism and improve mood throughout the day.',
				'content' => 'A comprehensive study published in the Journal of Health Psychology reveals significant benefits...',
				'category' => 'Fitness',
				'tags' => ['Study', 'Morning', 'Metabolism'],
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
				'category' => 'Technology',
				'tags' => ['AI', 'Technology', 'Fitness Apps'],
				'author_name' => 'Tech Reporter',
				'published_at' => now()->subHours(12),
				'status' => 'published',
				'views' => 120,
				'is_breaking' => true
			]
		]);

	}
}
