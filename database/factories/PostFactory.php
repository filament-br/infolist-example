<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $user = User::inRandomOrder()->first()->id;

        $title = fake()->sentence();

        return [
            'author_id' => $user,
            'title' => $title,
            'slug' => Str::slug($title),
            'content' => '<h1 class="text-lg font-bold text-gray-950 dark:text-white py-4">What is Lorem Ipsum?</h1><p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p><p><h1 class="text-lg font-bold text-gray-950 dark:text-white py-4">Why do we use it?</h1><p>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using \'Content here, content here\', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for \'lorem ipsum\' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).</p>',
            'tags' => fake()->randomElements(['laravel', 'php', 'database', 'framework', 'testing', 'unit'], rand(1, 6)),
            'published' => true,
            'published_at' => fake()->dateTimeThisYear(),
            'created_at' => fake()->dateTimeThisYear(),
            'image' => '5t6WpPO5VHlmxuRcTju9JmMUivdnP6-metabWluaW1hbGlzbS00ay1mb3ItbWFjLWRlc2t0b3Atd2FsbHBhcGVyLXByZXZpZXcuanBn-.jpg'
        ];
    }
}
