<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class Workout extends Model
{
	protected $connection = 'mongodb';
	protected $collection = 'workouts';

	protected $fillable = [
		'user_id',
		'name',
		'description',
		'workout_date',
		'total_duration',
		'difficulty_level',
		'status',
		'notes',
		'calories_burned'
	];

	protected $casts = [
		'workout_date' => 'date',
		'total_duration' => 'integer',
		'calories_burned' => 'integer',
		'created_at' => 'datetime',
		'updated_at' => 'datetime'
	];

	// Relationships
	public function user()
	{
		return $this->belongsTo(User::class);
	}

	public function exercises()
	{
		return $this->hasMany(WorkoutExercise::class);
	}

	public function sessions()
	{
		return $this->hasMany(WorkoutSession::class);
	}
}
