<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Client;
use App\Models\Appointment;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class DummyDataSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::firstOrCreate(
            ['email' => 'pro@example.com'],
            ['name' => 'Profesional Demo', 'password' => Hash::make('password')]
        );

        $client = Client::create([
            'user_id' => $user->id,
            'name' => 'Cliente Prueba',
            'email' => 'cliente@example.com',
            'phone' => '555-000-0000',
        ]);

        $start = Carbon::now('UTC')->addDay()->setTime(15,0); // mañana 15:00 UTC
        Appointment::create([
            'user_id' => $user->id,
            'client_id' => $client->id,
            'start_at' => $start,
            'end_at' => (clone $start)->addMinutes(30),
            'duration_minutes' => 30,
            'status' => 'confirmed',
            'service' => 'Consulta',
        ]);
    }
}
