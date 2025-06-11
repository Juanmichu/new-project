<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use MongoDB\Laravel\Eloquent\Model;
use MongoDB\Laravel\Auth\User as MongoUser;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends MongoUser implements JWTSubject
{
	use HasApiTokens, HasFactory, Notifiable;

	protected $connection = 'mongodb';
	protected $collection = 'users';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array<int, string>
	 */
	protected $fillable = [
		'name',
		'email',
		'password',
		'role',
		'is_active',
	];

	/**
	 * The attributes that should be hidden for serialization.
	 *
	 * @var array<int, string>
	 */
	protected $hidden = [
		'password',
		'remember_token',
	];

	/**
	 * The attributes that should be cast.
	 *
	 * @var array<string, string>
	 */
	protected $casts = [
		'email_verified_at' => 'datetime',
		'password' => 'hashed',
		'is_active' => 'boolean',
	];

	/**
	 * Get the identifier that will be stored in the subject claim of the JWT.
	 *
	 * @return mixed
	 */
	public function getJWTIdentifier()
	{
		return $this->getKey();
	}

	/**
	 * Return a key value array, containing any custom claims to be added to the JWT.
	 *
	 * @return array
	 */
	public function getJWTCustomClaims()
	{
		return [];
	}

	/**
	 * Get the workouts for the user.
	 */
	public function workouts()
	{
		return $this->hasMany(Workout::class);
	}

	/**
	 * Check if user is admin
	 */
	public function isAdmin()
	{
		return $this->role === 'admin';
	}

	/**
	 * Get today's workout for the user
	 */
	public function getTodayWorkout()
	{
		return $this->workouts()
			->whereDate('scheduled_date', today())
			->first();
	}
}
