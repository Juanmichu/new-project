<?php
// app/Models/User.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use MongoDB\Laravel\Auth\User as MongoAuthenticatable;

class User extends MongoAuthenticatable
{
	use HasApiTokens, HasFactory, Notifiable;

	protected $connection = 'mongodb';
	protected $collection = 'users';

	protected $fillable = [
		'name',
		'email',
		'password',
		'age',
		'weight',
		'height',
		'fitness_level',
		'goals',
		'avatar',
		'preferences',
		'role',
		'is_active'
	];

	protected $hidden = [
		'password',
		'remember_token',
	];

	protected $casts = [
		'email_verified_at' => 'datetime',
		'password' => 'hashed',
		'goals' => 'array',
		'preferences' => 'array',
		'is_active' => 'boolean',
		'age' => 'integer',
		'weight' => 'decimal:2',
		'height' => 'decimal:2',
		'created_at' => 'datetime',
		'updated_at' => 'datetime'
	];

	protected $attributes = [
		'role' => 'user',
		'is_active' => true,
		'fitness_level' => 'beginner',
		'goals' => [],
		'preferences' => []
	];

	// Relationships
	public function workouts()
	{
		return $this->hasMany(Workout::class);
	}

	public function workoutSessions()
	{
		return $this->hasMany(WorkoutSession::class);
	}

	public function articles()
	{
		return $this->hasMany(Article::class);
	}

	// Helper methods
	public function isAdmin()
	{
		return $this->role === 'admin';
	}

	public function isActive()
	{
		return $this->is_active === true;
	}

	public function getTodayWorkout()
	{
		return $this->workouts()
			->whereDate('workout_date', today())
			->with(['exercises.exercise'])
			->first();
	}

	public function getCompletedWorkoutsCount()
	{
		return $this->workouts()
			->where('status', 'completed')
			->count();
	}

	public function getActiveStreakDays()
	{
		$sessions = $this->workoutSessions()
			->whereNotNull('completed_at')
			->orderBy('completed_at', 'desc')
			->get();

		$streak = 0;
		$currentDate = now()->startOfDay();

		foreach ($sessions as $session) {
			$sessionDate = $session->completed_at->startOfDay();

			if ($sessionDate->eq($currentDate) || $sessionDate->eq($currentDate->subDay())) {
				$streak++;
				$currentDate = $sessionDate;
			} else {
				break;
			}
		}

		return $streak;
	}

	public function getBMI()
	{
		if (!$this->weight || !$this->height) {
			return null;
		}

		$heightInMeters = $this->height / 100;
		return round($this->weight / ($heightInMeters * $heightInMeters), 1);
	}

	public function getFitnessGoals()
	{
		return $this->goals ?? [];
	}

	public function hasGoal($goal)
	{
		return in_array($goal, $this->getFitnessGoals());
	}

	public function addGoal($goal)
	{
		$goals = $this->getFitnessGoals();
		if (!in_array($goal, $goals)) {
			$goals[] = $goal;
			$this->update(['goals' => $goals]);
		}
	}

	public function removeGoal($goal)
	{
		$goals = $this->getFitnessGoals();
		$goals = array_filter($goals, function($g) use ($goal) {
			return $g !== $goal;
		});
		$this->update(['goals' => array_values($goals)]);
	}

	public function getPreference($key, $default = null)
	{
		return $this->preferences[$key] ?? $default;
	}

	public function setPreference($key, $value)
	{
		$preferences = $this->preferences ?? [];
		$preferences[$key] = $value;
		$this->update(['preferences' => $preferences]);
	}

	// Scopes
	public function scopeActive($query)
	{
		return $query->where('is_active', true);
	}

	public function scopeAdmins($query)
	{
		return $query->where('role', 'admin');
	}

	public function scopeUsers($query)
	{
		return $query->where('role', 'user');
	}

	public function scopeByFitnessLevel($query, $level)
	{
		return $query->where('fitness_level', $level);
	}
}
