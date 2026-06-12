<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            [
                'id' => 1,
                'uid' => '861a2a7e-e18c-4410-819e-9dd7084c03fa',
                'tenant_id' => 1,
                'name' => 'Admin',
                'email' => 'admin@example.com',
                'role' => 'admin',
                'email_verified_at' => null,
                'password' => Hash::make('password')
            ],
            [
                'id' => 2,
                'uid' => '66ee0de7-bb84-43fa-9b2d-9bddd75c7387',
                'tenant_id' => 1,
                'name' => 'Assistant 1',
                'email' => 'assistant@example.com',
                'role' => 'assistant',
                'email_verified_at' => null,
                'password' => Hash::make('password')
            ],
            [
                'id' => 3,
                'uid' => 'f629e599-89c1-46ec-919a-f9c38025f0f4',
                'tenant_id' => 2,
                'name' => 'Admin 2',
                'email' => 'admin2@example.com',
                'role' => 'admin',
                'email_verified_at' => null,
                'password' => Hash::make('password')
            ],
            [
                'id' => 4,
                'uid' => 'a5162013-320c-46c8-ada1-c2ee0959d44e',
                'tenant_id' => 2,
                'name' => 'Assistant 2',
                'email' => 'assistant2@example.com',
                'role' => 'assistant',
                'email_verified_at' => null,
                'password' => Hash::make('password')
            ],
        ]);
    }
}
