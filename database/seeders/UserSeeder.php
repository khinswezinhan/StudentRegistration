<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'may',
            'email' => 'may@gmail.com',
            'password' => bcrypt('may1234567890'),
            'role_id' => 1,
        ]);

        User::factory()->create([
            'name' => 'yuri',
            'email' => 'yuri@gmail.com',
            'password' => bcrypt('yuri1234567890'),
            'role_id' => 2,
        ]);
    }


}
