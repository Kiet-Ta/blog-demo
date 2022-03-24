<?php

namespace Database\Seeders;

use App\Models\Post;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\App;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if ( ! App::environment('testing')) {
            $count = (int)$this->command->ask('How many posts do you need?', 10);

            $this->command->info("Creating {$count} posts.");

            // Create posts
            Post::factory($count)->create();

            $this->command->info('Posts were created!');
        }
    }
}
