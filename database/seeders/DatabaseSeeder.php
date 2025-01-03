<?php

namespace Database\Seeders;

use App\Models\Employee;
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
        // User::factory(15)->create();

        // User::factory()->create([
        //     'username' => 'admin',
        //     'email' => 'email.admin@example.com',
        // ]);

        // $this->call(DivisionSeeder::class);

        Employee::factory(25)->create();
    }
}
