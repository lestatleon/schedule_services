<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class TenantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('tenants')->insert([
            [
                'uid' =>  Str::uuid()->toString(),
                'name' => 'Tenant Test',
                'plan' => 'basic'
            ],
            [
                'uid' => Str::uuid()->toString(),
                'name' => 'Tenant Test 2',
                'plan' => 'premium'
            ],
        ]);
    }
}
