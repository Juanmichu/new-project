<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use MongoDB\Laravel\Eloquent\Model;

class Article extends Model
{
	use HasFactory;

	protected $connection = 'mongodb';
	protected $collection = 'articles';

	protected $fillable = [
		'user_id',
		'title',
		'slug',
		'excerpt',
		'content',
		'category',
		'tags',
		'featured_image',
		'published_at',
		'status',
		'views',
		'likes',
		'is_featured'
	];

	protected $casts = [
		'tags' => 'array',
		'published_at' => 'datetime',
		'views' => 'integer',
		'likes' => 'integer',
		'is_featured' => 'boolean',
		'created_at' => 'datetime',
		'updated_at' => 'datetime'
	];

	// Relationships
	public function author()
	{
		return $this->belongsTo(User::class, 'user_id');
	}
}
