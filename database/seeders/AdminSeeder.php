<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\User;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->info('Creating API test user...');
        $admin = new User();
        $admin->first_name = 'Viktor';
        $admin->last_name = 'Matushevskyi';
        $admin->email = 'admin@mail.com';
        $admin->password = 'secret';
        $admin->phone = '12345567789';
        $admin->api_token = 'api_token';
        $admin->email_token = 'email_token';
        $admin->save();
        Company::factory()->count(3)->create(['user_id' => 1]);
        $this->command->info("User was created with email {$admin->email}, \npassword is 'secret'");
    }
}
