<?php

namespace Tests\Feature;

use App\Models\Customer;
use App\Models\Tenant;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CustomerApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_show_returns_uid_as_id_without_internal_identifiers(): void
    {
        $tenant = Tenant::factory()->create();

        $customer = Customer::create([
            'uid' => '5d8c6e8c-bf7a-4c8d-b4a7-7d1a6d7e3f10',
            'tenant_id' => $tenant->id,
            'name' => 'Ada Lovelace',
            'email' => 'ada@example.com',
            'phone' => '5512345678',
            'mobile' => '5599999999',
            'isWhatsapp' => true,
        ]);

        $response = $this->getJson("/api/customers/{$customer->uid}");

        $response
            ->assertOk()
            ->assertJson([
                'id' => $customer->uid,
                'name' => 'Ada Lovelace',
                'email' => 'ada@example.com',
                'phone' => '5512345678',
                'mobile' => '5599999999',
                'isWhatsapp' => true,
            ])
            ->assertJsonMissingPath('uid');

        $this->assertSame(
            ['id', 'name', 'email', 'phone', 'mobile', 'isWhatsapp'],
            array_keys($response->json())
        );
    }
}
