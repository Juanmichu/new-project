<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use MongoDB\Laravel\Eloquent\Model;

/**
 * @property string $_id
 * @property string $title
 * @property string $slug
 * @property string $excerpt
 * @property string $content
 * @property string $category
 * @property array $tags
 * @property string $featured_image
 * @property string $author_name
 * @property string $source_url
 * @property Illuminate\Support\Carbon|null $published_at
 * @property string $status
 * @property int $views
 * @property bool $is_breaking
 * @property Illuminate\Support\Carbon|null $created_at
 * @property Illuminate\Support\Carbon|null $updated_at
 */
class NewsArticle extends Model
{
	use HasFactory;

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
		'published_at' => 'datetime',
		'views' => 'integer',
		'is_breaking' => 'boolean',
		'created_at' => 'datetime',
		'updated_at' => 'datetime'
	];
}
