<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            [
                'uid' =>  Str::uuid()->toString(),
                'tenant_id' => 1,
                'name' => 'Admin',
                'email' => 'admin@example.com',
                'role' => 'admin',
                'email_verified_at' => null,
                'password' => 'password',
            ],
            [
                'uid' =>  Str::uuid()->toString(),
                'tenant_id' => 1,
                'name' => 'Assistant 1',
                'email' => 'assistant@example.com',
                'role' => 'assistant',
                'email_verified_at' => null,
                'password' => 'password',
            ],
            [
                'uid' =>  Str::uuid()->toString(),
                'tenant_id' => 2,
                'name' => 'Admin 2',
                'email' => 'admin2@example.com',
                'role' => 'admin',
                'email_verified_at' => null,
                'password' => 'password',
            ],
            [
                'uid' =>  Str::uuid()->toString(),
                'tenant_id' => 2,
                'name' => 'Assistant 2',
                'email' => 'assistant2@example.com',
                'role' => 'assistant',
                'email_verified_at' => null,
                'password' => 'password',
            ],
        ]);
    }
}
