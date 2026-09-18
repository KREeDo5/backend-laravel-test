<?php

namespace Database\Seeders;

use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Администратор
        $admin = User::factory()->admin()->create([
            'name' => 'Administrator',
            'email' => 'admin@test.test',
            'password' => '1234',
        ]);

        // Посты администратора
        Post::factory()->count(5)->create(['author_id' => $admin->id]);

        // Обычные пользователи, у каждого по 2 поста
        User::factory()
            ->count(3)
            ->has(Post::factory()->count(2), 'posts')
            ->create();
    }
}
