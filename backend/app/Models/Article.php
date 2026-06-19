<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use MongoDB\Laravel\Eloquent\Model;

/**
 * App\Models\Article
 * @property string $title
 * @property string $slug
 * @property string $excerpt
 * @property string $content
 * @property string $category
 * @property array $tags
 * @property string $featured_image
 * @property \Illuminate\Support\Carbon|null $published_at
 * @property string $status
 * @property int $views
 * @property int $likes
 * @property bool $is_featured
 * @property string $author
 * @property string $reading_time
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 */
class Article extends Model
{
    use HasFactory;

    protected $connection = 'mongodb';
    protected $collection = 'articles';

    protected $fillable = [
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
        'is_featured',
        'author',
        'reading_time'
    ];

    protected $casts = [
        'published_at'  => 'datetime',
        'views'         => 'integer',
        'likes'         => 'integer',
        'is_featured'   => 'boolean',
        'created_at'    => 'datetime',
        'updated_at'    => 'datetime'
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class, 'name', 'author')->first()->name;
    }
}
