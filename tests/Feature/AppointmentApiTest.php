<?php

namespace Tests\Feature;

use App\Models\Appointment;
use App\Models\Customer;
use App\Models\Tenant;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AppointmentApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_show_returns_uuid_as_id_without_internal_identifiers(): void
    {
        $tenant = Tenant::factory()->create();

        $customer = Customer::create([
            'tenant_id' => $tenant->id,
            'name' => 'Ada Lovelace',
            'email' => 'ada@example.com',
            'phone' => '5512345678',
            'mobile' => '5599999999',
            'isWhatsapp' => true,
        ]);

        $appointment = Appointment::create([
            'uuid' => '9f7d5ad0-5a52-4bb7-bb6d-2ec0c475cb11',
            'tenant_id' => $tenant->id,
            'customer_id' => $customer->id,
            'date' => '2026-06-11',
            'time' => '14:30:00',
            'duration' => 45,
        ]);

        $response = $this->getJson("/api/appointments/{$appointment->uuid}");

        $response
            ->assertOk()
            ->assertJson([
                'id' => $appointment->uuid,
                'tenant_id' => $tenant->id,
                'customer_id' => $customer->id,
                'date' => '2026-06-11',
                'time' => '14:30:00',
                'duration' => 45,
            ])
            ->assertJsonMissingPath('uuid');

        $this->assertSame(
            ['id', 'tenant_id', 'customer_id', 'date', 'time', 'duration'],
            array_keys($response->json())
        );
    }
}
