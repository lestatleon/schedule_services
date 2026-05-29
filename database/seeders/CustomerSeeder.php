<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('customers')->insert([
            [
                'uid' =>  Str::uuid()->toString(),
                'tenant_id' => 1,
                'name' => 'Adele Adkins',
                'email' => 'adele.adkins92@fakemail.com',
                'mobile' => '5512346789',
                'isWhatsapp' => true,
                'phone' => '',
            ],
            [
                'uid' =>  Str::uuid()->toString(),
                'tenant_id' => 1,
                'name' => 'Drake Graham',
                'email' => 'drake.graham77@mockmail.net',
                'mobile' => '5587654321',
                'isWhatsapp' => true,
                'phone' => '',
            ],
            [
                'uid' =>  Str::uuid()->toString(),
                'tenant_id' => 1,
                'name' => 'Shakira Mebarak',
                'email' => 'shakira.mebarak21@testinbox.org',
                'mobile' => '5543219876',
                'isWhatsapp' => false,
                'phone' => '',
            ],
            [
                'uid' =>  Str::uuid()->toString(),
                'tenant_id' => 1,
                'name' => 'Bruno Hernandez',
                'email' => 'bruno.hernandez88@demoemail.net',
                'mobile' => '5598761234',
                'isWhatsapp' => false,
                'phone' => '',
            ],
            [
                'uid' =>  Str::uuid()->toString(),
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










