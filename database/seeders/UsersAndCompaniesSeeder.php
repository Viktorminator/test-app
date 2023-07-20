<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\User;
use Illuminate\Database\Seeder;

class UsersAndCompaniesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->info('Creating sample user...');
        $user = User::factory()->create();
        Company::factory()->count(3)->for($user)->create();
        $this->command->info("User was created with email {$user->email}, \npassword is 'secret'");
    }
}
