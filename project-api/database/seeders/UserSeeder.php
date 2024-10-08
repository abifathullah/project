<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        User::firstOrCreate([
            'name' => 'Administrator',
            'email' => 'admin@admin.com',
        ], [
            'password' => Hash::make('HSgXjbpwayJQu5Gn'),
        ]);
    }
}
