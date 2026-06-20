<?php

namespace Database\Factories;

use App\Http\Constants\Articles;
use App\Models\Article;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ArticleFactory extends Factory
{
    protected $model = Article::class;
    /**
     * @inheritDoc
     */
    public function definition(): array
    {
        return [
            'user_id'           => User::factory(),
            'title'             => $this->faker->sentence,
            'slug'              => $this->faker->slug,
            'excerpt'           => $this->faker->paragraph,
            'content'           => $this->faker->text,
            'category'          => $this->faker->randomElement(Articles::CATEGORIES),
            'tags'              => $this->faker->randomElements(['AI', 'Technology', 'Fitness Apps', 'Study', 'Morning', 'Metabolism'], 3),
            'featured_image'    => $this->faker->imageUrl(),
            'published_at'      => now(),
            'status'            => $this->faker->randomElement(['draft', 'published']),
            'views'             => $this->faker->numberBetween(0, 1000),
            'likes'             => $this->faker->numberBetween(0, 500),
            'is_featured'       => false, // 20% chance of being featured
            'author'            => fn (array $attributes) => User::find($attributes['user_id'])->name,
            'reading_time'      => $this->faker->numberBetween(1, 10),
        ];
    }
}
