<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use MongoDB\Laravel\Eloquent\Model;

class Exercise extends Model
{
	use HasFactory;

	protected $connection = 'mongodb';
	protected $collection = 'exercises';

	protected $fillable = [
		'name',
		'description',
		'category',
		'muscle_groups',
		'equipment_needed',
		'difficulty_level',
		'instructions',
		'video_url',
		'image_url',
		'calories_per_minute',
		'is_active'
	];

	protected $casts = [
		'muscle_groups' => 'array',
		'equipment_needed' => 'array',
		'instructions' => 'array',
		'is_active' => 'boolean',
		'created_at' => 'datetime',
		'updated_at' => 'datetime'
	];

	// Relationships
	public function workoutExercises()
	{
		return $this->hasMany(WorkoutExercise::class);
	}
}
