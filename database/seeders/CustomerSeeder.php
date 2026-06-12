<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('customers')->insert([
            [
                'id' => 1,
                'uid' => 'ee91177a-1908-4f87-9693-146654d878df',
                'tenant_id' => 1,
                'name' => 'Adele Adkins',
                'email' => 'adele.adkins92@fakemail.com',
                'mobile' => '5512346789',
                'isWhatsapp' => true,
                'phone' => '',
            ],
            [
                'id' => 2,
                'uid' => 'c882ba45-f89a-45a2-8abd-1c9d82dcf15b',
                'tenant_id' => 1,
                'name' => 'Drake Graham',
                'email' => 'drake.graham77@mockmail.net',
                'mobile' => '5587654321',
                'isWhatsapp' => true,
                'phone' => '',
            ],
            [
                'id' => 3,
                'uid' => '40799009-a9fd-4991-a104-c251b05bf7f9',
                'tenant_id' => 1,
                'name' => 'Shakira Mebarak',
                'email' => 'shakira.mebarak21@testinbox.org',
                'mobile' => '5543219876',
                'isWhatsapp' => false,
                'phone' => '',
            ],
            [
                'id' => 4,
                'uid' => '557ba2af-0929-4d46-bf81-15acf1176f5d',
                'tenant_id' => 1,
                'name' => 'Bruno Hernandez',
                'email' => 'bruno.hernandez88@demoemail.net',
                'mobile' => '5598761234',
                'isWhatsapp' => false,
                'phone' => '',
            ],
            [
                'id' => 5,
                'uid' => '15da5704-6541-471e-9ac1-2ae2ad6ceb19',
                'tenant_id' => 1,
                'name' => 'Taylor Swift',
                'email' => 'taylor.swift13@samplemail.org',
                'mobile' => '5534567890',
                'isWhatsapp' => true,
                'phone' => '',
            ],
        ]);
    }
}
