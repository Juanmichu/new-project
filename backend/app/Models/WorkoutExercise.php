<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use MongoDB\Laravel\Eloquent\Model;

/**
 * @property string $_id
 * @property string $workout_id
 * @property string $exercise_id
 * @property int $sets
 * @property int $reps
 * @property int $weight
 * @property int $duration
 * @property int $rest_time
 * @property int $order
 * @property string $notes
 * @property bool $completed
 * @property Illuminate\Support\Carbon|null $created_at
 * @property Illuminate\Support\Carbon|null $updated_at
 */
class WorkoutExercise extends Model
{
    use HasFactory;

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
        return $this->belongsTo(Workout::class, 'workout_id', '_id');
    }

    public function exercise()
    {
        return $this->belongsTo(Exercise::class, 'exercise_id', '_id');
    }
}
