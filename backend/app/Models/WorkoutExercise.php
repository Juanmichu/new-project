<?php
namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class WorkoutExercise extends Model
{
	protected $connection = 'mongodb';
	protected $collection = 'workout_exercises';

	protected $fillable = [
		'workout_id',
		'exercise_id',
		'sets',
		'reps',
		'weight',
		'duration',
		'rest_time',
		'order',
		'notes',
		'completed'
	];

	protected $casts = [
		'sets' => 'integer',
		'reps' => 'integer',
		'weight' => 'decimal:2',
		'duration' => 'integer',
		'rest_time' => 'integer',
		'order' => 'integer',
		'completed' => 'boolean',
		'created_at' => 'datetime',
		'updated_at' => 'datetime'
	];

	// Relationships
	public function workout()
	{
		return $this->belongsTo(Workout::class);
	}

	public function exercise()
	{
		return $this->belongsTo(Exercise::class);
	}
}
