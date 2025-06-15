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
		'preferences'
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
		'created_at' => 'datetime',
		'updated_at' => 'datetime'
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
}
