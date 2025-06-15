<?php

namespace Database\Factories;

use App\Models\Article;
use Illuminate\Database\Eloquent\Factories\Factory;

class ArticleFactory extends Factory
{
	protected $model = Article::class;
    /**
     * @inheritDoc
     */
    public function definition()
    {
        return [
			'user_id' => \App\Models\User::factory(),
			'title' => $this->faker->sentence,
			'slug' => $this->faker->slug,
			'excerpt' => $this->faker->paragraph,
			'content' => $this->faker->text,
			'category' => $this->faker->word,
			'tags' => $this->faker->words(3, true),
			'featured_image' => $this->faker->imageUrl(),
			'published_at' => now(),
			'status' => $this->faker->randomElement(['draft', 'published']),
			'views' => $this->faker->numberBetween(0, 1000),
			'likes' => $this->faker->numberBetween(0, 500),
			'is_featured' => $this->faker->boolean(20), // 20% chance of being featured
		];
	}
}
