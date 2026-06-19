<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use MongoDB\Laravel\Eloquent\Model;

/**
 * @property string $_id
 * @property string $user_id
 * @property string $workout_id
 * @property Illuminate\Support\Carbon|null $completed_at
 * @property int $duration
 * @property int $calories_burned
 * @property int $exercises_completed
 * @property int $total_exercises
 * @property string $notes
 * @property int $rating
 * @property Illuminate\Support\Carbon|null $created_at
 * @property Illuminate\Support\Carbon|null $updated_at
 */
class WorkoutSession extends Model
{
	use HasFactory;

	protected $connection = 'mongodb';
	protected $collection = 'workout_sessions';

	protected $fillable = [
		'user_id',
		'workout_id',
		'started_at',
		'completed_at',
		'duration',
		'calories_burned',
		'exercises_completed',
		'total_exercises',
		'notes',
		'rating'
	];

	protected $casts = [
		'started_at' => 'datetime',
		'completed_at' => 'datetime',
		'duration' => 'integer',
		'calories_burned' => 'integer',
		'exercises_completed' => 'integer',
		'total_exercises' => 'integer',
		'rating' => 'integer',
		'created_at' => 'datetime',
		'updated_at' => 'datetime'
	];

	// Relationships
	public function user()
	{
		return $this->belongsTo(User::class, 'user_id', '_id');
	}

	public function workout()
	{
		return $this->belongsTo(Workout::class, 'workout_id', '_id');
	}
}
