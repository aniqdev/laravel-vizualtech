<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use \App\Models\{Author, Publisher, Book, User};

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

        User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@admin.com',
            'password' => bcrypt('password'),
        ]);

        User::factory(10)->create();

        Author::factory(10)->create();

        Publisher::factory(10)->create();

        $publishers = Publisher::all()->pluck('id');

        $authors = Publisher::all()->pluck('id');

        for ($i=0; $i < 100; $i++) {
            $book = Book::create([
                'publisher_id' => $publishers->random(),
                'title' => fake()->sentence,
            ]);

            $book->authors()->attach(
                $authors->random(rand(1, 3))->toArray()
            );
        }
    }
}
