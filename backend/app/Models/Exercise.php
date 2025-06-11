<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class Exercise extends Model
{
	protected $connection = 'mongodb';
	protected $collection = 'exercises';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array<int, string>
	 */
	protected $fillable = [
		'workout_id',
		'name',
		'description',
		'type', // cardio, strength, flexibility, etc.
		'sets',
		'reps',
		'weight_kg',
		'duration_seconds',
		'distance_meters',
		'calories_burned',
		'rest_seconds',
		'order',
		'is_completed',
		'completed_at',
		'notes',
		'video_url',
		'image_url',
	];

	/**
	 * The attributes that should be cast.
	 *
	 * @var array<string, string>
	 */
	protected $casts = [
		'sets' => 'integer',
		'reps' => 'integer',
		'weight_kg' => 'decimal:2',
		'duration_seconds' => 'integer',
		'distance_meters' => 'decimal:2',
		'calories_burned' => 'integer',
		'rest_seconds' => 'integer',
		'order' => 'integer',
		'is_completed' => 'boolean',
		'completed_at' => 'datetime',
	];

	/**
	 * Get the workout that owns the exercise.
	 */
	public function workout()
	{
		return $this->belongsTo(Workout::class);
	}

	/**
	 * Scope a query to order exercises by their order field.
	 */
	public function scopeOrdered($query)
	{
		return $query->orderBy('order');
	}

	/**
	 * Scope a query to only include completed exercises.
	 */
	public function scopeCompleted($query)
	{
		return $query->where('is_completed', true);
	}

	/**
	 * Mark exercise as completed
	 */
	public function markAsCompleted()
	{
		$this->update([
			'is_completed' => true,
			'completed_at' => now(),
		]);
	}

	/**
	 * Get formatted duration
	 */
	public function getFormattedDuration()
	{
		if (!$this->duration_seconds) {
			return null;
		}

		$minutes = floor($this->duration_seconds / 60);
		$seconds = $this->duration_seconds % 60;

		if ($minutes > 0) {
			return sprintf('%d:%02d', $minutes, $seconds);
		}

		return sprintf('%d sec', $seconds);
	}

	/**
	 * Get exercise summary for display
	 */
	public function getSummary()
	{
		$summary = [];

		if ($this->sets && $this->reps) {
			$summary[] = "{$this->sets} sets x {$this->reps} reps";
		}

		if ($this->weight_kg) {
			$summary[] = "{$this->weight_kg} kg";
		}

		if ($this->duration_seconds) {
			$summary[] = $this->getFormattedDuration();
		}

		if ($this->distance_meters) {
			$summary[] = "{$this->distance_meters} m";
		}

		return implode(' • ', $summary);
	}
}
