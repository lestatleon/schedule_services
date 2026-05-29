<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class BranchSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('branches')->insert([
            [
                'uid' =>  Str::uuid()->toString(),
                'tenant_id' => 1,
                'name' => 'Main',
            ],
            [
                'uid' =>  Str::uuid()->toString(),
                'tenant_id' => 1,
                'name' => 'Second',
            ],
            [
                'uid' =>  Str::uuid()->toString(),
                'tenant_id' => 2,
                'name' => 'Main',
            ],
        ]);
    }
}
