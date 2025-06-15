<?php

namespace Database\Factories;

use App\Models\NewsArticle;
use Illuminate\Database\Eloquent\Factories\Factory;

class NewsArticleFactory extends Factory
{
	protected $model = NewsArticle::class;

    /**
     * @inheritDoc
     */
    public function definition()
    {
        return [
			'title' => $this->faker->sentence,
			'slug' => $this->faker->slug,
			'excerpt' => $this->faker->paragraph,
			'content' => $this->faker->text,
			'category' => $this->faker->word,
			'tags' => $this->faker->words(3, true),
			'featured_image' => $this->faker->imageUrl(),
			'author_name' => $this->faker->name,
			'source_url' => $this->faker->url,
			'published_at' => now(),
			'status' => $this->faker->randomElement(['draft', 'published']),
			'views' => $this->faker->numberBetween(0, 1000),
			'is_breaking' => $this->faker->boolean(10), // 10% chance of being breaking news
		];
    }
}
