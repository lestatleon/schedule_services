<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AppointmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('appointments')->insert([
            [
                'id' => 1,
                'uid' => '1f10be30-f9e3-4ebd-b6e4-0f0ef53f1001',
                'tenant_id' => 1,
                'customer_id' => 1,
                'branch_id' => 1,
                'date' => '2026-06-15',
                'time' => '09:00:00',
                'duration' => 60
            ],
            [
                'id' => 2,
                'uid' => '1f10be30-f9e3-4ebd-b6e4-0f0ef53f1002',
                'tenant_id' => 1,
                'customer_id' => 2,
                'branch_id' => 1,
                'date' => '2026-06-15',
                'time' => '10:00:00',
                'duration' => 60
            ],
            [
                'id' => 3,
                'uid' => '1f10be30-f9e3-4ebd-b6e4-0f0ef53f1003',
                'tenant_id' => 1,
                'customer_id' => 3,
                'branch_id' => 1,
                'date' => '2026-06-16',
                'time' => '12:30:00',
                'duration' => 60
            ],
            [
                'id' => 4,
                'uid' => '1f10be30-f9e3-4ebd-b6e4-0f0ef53f1004',
                'tenant_id' => 1,
                'customer_id' => 4,
                'branch_id' => 2,
                'date' => '2026-06-17',
                'time' => '15:15:00',
                'duration' => 60
            ],
            [
                'id' => 5,
                'uid' => '1f10be30-f9e3-4ebd-b6e4-0f0ef53f1005',
                'tenant_id' => 1,
                'customer_id' => 5,
                'branch_id' => 2,
                'date' => '2026-06-18',
                'time' => '17:00:00',
                'duration' => 60
            ],
        ]);
    }
}
