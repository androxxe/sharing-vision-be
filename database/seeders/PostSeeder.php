<?php

namespace Database\Seeders;

use App\Models\Post;
use Illuminate\Database\Seeder;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 1; $i <= 50; $i++) {
            // Create dummy data using faker
            Post::create([
                'title' => fake()->sentence(6),
                'content' => fake()->paragraph(100),
                'category' => fake()->randomElement(['Berita', 'Tutorial', 'Tips']),
                'status' => fake()->randomElement(['Publish', 'Draft', 'Trash']),
            ]);
        }
    }
}
