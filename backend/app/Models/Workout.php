<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use MongoDB\Laravel\Eloquent\Model;

/**
 * @property string $_id
 * @property string $user_id
 * @property string $name
 * @property string $description
 * @property \Illuminate\Support\Carbon|null $workout_date
 * @property int $total_duration
 * @property string $difficulty_level
 * @property string $status
 * @property string $notes
 * @property int $calories_burned
 */
class Workout extends Model
{
	use HasFactory;

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
		return $this->belongsTo(User::class, 'user_id', '_id');
	}

	public function exercises()
	{
		return $this->hasMany(WorkoutExercise::class, 'workout_id', '_id');
	}

	public function sessions()
	{
		return $this->hasMany(WorkoutSession::class, 'workout_id', '_id');
	}
}
