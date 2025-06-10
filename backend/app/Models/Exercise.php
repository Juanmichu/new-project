<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;
use MongoDB\Laravel\Eloquent\SoftDeletes;

class Exercise extends Model
{
	use SoftDeletes;

	protected $connection = 'mongodb';
	protected $collection = 'exercises';

	protected $fillable = [
		'name',
		'description',
		'muscle_group', // chest, back, legs, arms, shoulders, core
		'equipment', // barbell, dumbbell, machine, bodyweight, etc.
		'difficulty' // beginner, intermediate, advanced
	];
}
