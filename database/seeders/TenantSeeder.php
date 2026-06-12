<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TenantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('tenants')->insert([
            [
                'id' => 1,
                'uid' =>  '048d73d1-9455-4664-81fa-b9b4eb0ec854',
                'name' => 'Tenant Basic',
                'plan' => 'Basic'
            ],
            [
                'id' => 2,
                'uid' => '41dc9e42-ed6a-4268-a1d9-2e14f2beaebd',
                'name' => 'Tenant Premium',
                'plan' => 'Premium'
            ],
        ]);
    }
}
