<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;
use MongoDB\Laravel\Auth\User as Authenticatable;
use MongoDB\Laravel\Eloquent\SoftDeletes;


class User extends Authenticatable
{
	use SoftDeletes;

	protected $connection = 'mongodb';
	protected $collection = 'users';

	protected $fillable = [
		'name',
		'email',
		'password',
		'age',
		'height',
		'weight',
		'fitness_level' // beginner, intermediate, advanced
	];

	protected $hidden = [
		'password',
		'remember_token',
	];

	public function workouts()
	{
		return $this->hasMany(Workout::class);
	}
}
