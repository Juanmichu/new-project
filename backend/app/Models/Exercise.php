<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use MongoDB\Laravel\Eloquent\Model;

/**
 * App\Models\Exercise
 * @property string $name
 * @property string $description
 * @property string $category
 * @property array $muscle_groups
 * @property array $equipment_needed
 * @property string $difficulty_level
 * @property array $instructions
 * @property array $recommendations
 * @property string $video_url
 * @property string $image_url
 * @property int $calories_per_minute
 * @property bool $is_active
 * @property bool $is_favorite
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 */
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
        'recommendations',
		'video_url',
		'image_url',
		'calories_per_minute',
		'is_active',
        'is_favorite'
	];

	protected $casts = [
		'is_active' => 'boolean',
		'is_favorite' => 'boolean',
		'created_at' => 'datetime',
		'updated_at' => 'datetime'
	];

	// Relationships
	public function workoutExercises()
	{
		return $this->hasMany(WorkoutExercise::class, 'exercise_id', '_id');
	}
}
