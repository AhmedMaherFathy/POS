<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Modules\Product\Database\Seeders\ProductDatabaseSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => '',
            'otp_code' => '2001',
            'otp_expired_at' => '2024-08-15 14:30:00',
            'email_verified_at' => '2024-08-15 14:29:00',
        ]);
        $this->call([
            ProductDatabaseSeeder::class,
        ]);
    }
}
