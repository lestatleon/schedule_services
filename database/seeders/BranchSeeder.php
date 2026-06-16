<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BranchSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('branches')->insert([
            [
                'id' => 1,
                'uid' =>  '86477471-6029-4087-a3a5-d26b3455153f',
                'tenant_id' => 1,
                'name' => 'Pricipal',
            ],
            [
                'id' => 2,
                'uid' =>  '85778051-55ce-424b-a1e3-8b96b58ef139',
                'tenant_id' => 1,
                'name' => 'Foranea',
            ],
            [
                'id' => 3,
                'uid' =>  'a7468073-f3be-41cc-8c06-036cb85ccf2d',
                'tenant_id' => 2,
                'name' => 'Principal',
            ],
        ]);
    }
}
