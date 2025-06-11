<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;
use Carbon\Carbon;

class Workout extends Model
{
	protected $connection = 'mongodb';
	protected $collection = 'workouts';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array<int, string>
	 */
	protected $fillable = [
		'user_id',
		'name',
		'description',
		'scheduled_date',
		'duration_minutes',
		'difficulty_level',
		'is_completed',
		'completed_at',
		'notes',
	];

	/**
	 * The attributes that should be cast.
	 *
	 * @var array<string, string>
	 */
	protected $casts = [
		'scheduled_date' => 'date',
		'completed_at' => 'datetime',
		'is_completed' => 'boolean',
		'duration_minutes' => 'integer',
	];

	/**
	 * Get the user that owns the workout.
	 */
	public function user()
	{
		return $this->belongsTo(User::class);
	}

	/**
	 * Get the exercises for the workout.
	 */
	public function exercises()
	{
		return $this->hasMany(Exercise::class);
	}

	/**
	 * Scope a query to only include today's workouts.
	 */
	public function scopeToday($query)
	{
		return $query->whereDate('scheduled_date', Carbon::today());
	}

	/**
	 * Scope a query to only include upcoming workouts.
	 */
	public function scopeUpcoming($query)
	{
		return $query->where('scheduled_date', '>=', Carbon::today());
	}

	/**
	 * Scope a query to only include completed workouts.
	 */
	public function scopeCompleted($query)
	{
		return $query->where('is_completed', true);
	}

	/**
	 * Mark workout as completed
	 */
	public function markAsCompleted()
	{
		$this->update([
			'is_completed' => true,
			'completed_at' => now(),
		]);
	}

	/**
	 * Get workout progress percentage
	 */
	public function getProgressPercentage()
	{
		$totalExercises = $this->exercises()->count();
		if ($totalExercises === 0) {
			return 0;
		}

		$completedExercises = $this->exercises()->where('is_completed', true)->count();
		return round(($completedExercises / $totalExercises) * 100, 2);
	}
}
