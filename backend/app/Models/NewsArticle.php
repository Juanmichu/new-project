<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class NewsArticle extends Model
{
	protected $connection = 'mongodb';
	protected $collection = 'news_articles';

	protected $fillable = [
		'title',
		'slug',
		'excerpt',
		'content',
		'category',
		'tags',
		'featured_image',
		'author_name',
		'source_url',
		'published_at',
		'status',
		'views',
		'is_breaking'
	];

	protected $casts = [
		'tags' => 'array',
		'published_at' => 'datetime',
		'views' => 'integer',
		'is_breaking' => 'boolean',
		'created_at' => 'datetime',
		'updated_at' => 'datetime'
	];
}
