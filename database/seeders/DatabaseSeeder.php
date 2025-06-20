<?php

namespace Database\Seeders;

use App\Models\Game;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

       /*  User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]); */

        Game::create([
            'name'     => 'Questions',
            'slug'     => 'questions',
        ]);

        Game::create([
            'name'     => 'Predections',
            'slug'     => 'predections',
        ]);
    }
}
