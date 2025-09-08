<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Music>
 */
class MusicFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {

        $fakeId = $this->faker->regexify('[A-Za-z0-9_-]{11}');

        return [
            'title' => $this->faker->sentence(3),
            'views' => $this->faker->numberBetween(0, 10000),
            'youtube_id' => $fakeId,
            'youtube_link' => 'https://www.youtube.com/watch?v=' . $fakeId,
            'thumb' => 'https://img.youtube.com/vi/' . $fakeId . '/hqdefault.jpg',
            'status' => 'active',
            'user_id' => User::factory()->create()->id, // cria automaticamente um usuário relacionado
        ];
    }
}
