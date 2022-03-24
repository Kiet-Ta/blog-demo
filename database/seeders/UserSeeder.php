<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\App;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if ( ! App::environment('testing')) {
            $count = (int)$this->command->ask('How many users do you need?', 10);

            $this->command->info("Creating {$count} users.");

            // Create users
            User::factory($count)->create();

            $this->command->info('Users were created!');
        }
    }
}
