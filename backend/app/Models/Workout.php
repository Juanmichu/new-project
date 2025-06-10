<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;
use MongoDB\Laravel\Eloquent\SoftDeletes;

class Workout extends Model
{
	use SoftDeletes;

	protected $connection = 'mongodb';
	protected $collection = 'workouts';

	protected $fillable = [
		'user_id',
		'name',
		'description',
		'date',
		'duration_minutes',
		'exercises'
	];

	protected $casts = [
		'exercises' => 'array',
		'date' => 'datetime'
	];

	public function user()
	{
		return $this->belongsTo(User::class);
	}
}
