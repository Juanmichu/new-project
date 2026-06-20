<?php

namespace Database\Factories;

use App\Http\Constants\UserProfile;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name'                  => fake()->name(),
            'email'                 => fake()->unique()->safeEmail(),
            'email_verified_at'     => now(),
            'password'              => static::$password ??= Hash::make('password'),
            'remember_token'        => Str::random(10),
            'age'                   => $this->faker->numberBetween(18, 100),
            'weight'                => $this->faker->numberBetween(50, 180),
            'height'                => $this->faker->numberBetween(110, 250),
            'fitness_level'         => $this->faker->randomElement(UserProfile::FITNESS_LEVEL),
            'goals'                 => $this->faker->randomElements(UserProfile::FITNESS_GOALS),
            'avatar'                => $this->faker->optional(0.5)->sentence,
            'preferences'           => $this->faker->optional(0.5)->sentence,
            'role'                  => $this->faker->randomElement(['user', 'admin']),
            'is_active'             => $this->faker->boolean(80)
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
