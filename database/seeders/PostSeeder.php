<?php

namespace Database\Seeders;

use App\Models\Post;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        Post::create([
            'title' => 'Lorem ipsum seeder example ',
            'description' => 'Lorem Ipsum typesetting industry. Lorem Ipsum seeder example '
        ]);
    }
}
