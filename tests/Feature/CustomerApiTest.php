<?php

namespace Tests\Feature;

use App\Models\Customer;
use App\Models\Tenant;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class CustomerApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_store_rejects_missing_tenant_header(): void
    {
        Sanctum::actingAs(User::factory()->create());

        $response = $this->postJson('/api/customers', [
            'name' => 'Ada Lovelace',
            'email' => 'ada@example.com',
            'mobile' => '5599999999',
            'isWhatsapp' => true,
        ]);

        $response
            ->assertUnauthorized()
            ->assertExactJson([
                'message' => 'Tenant session is invalid.',
            ]);
    }

    public function test_store_rejects_unknown_tenant_header(): void
    {
        Sanctum::actingAs(User::factory()->create());

        $response = $this
            ->withHeader('Tenant', '00000000-0000-0000-0000-000000000000')
            ->postJson('/api/customers', [
                'name' => 'Ada Lovelace',
                'email' => 'ada@example.com',
                'mobile' => '5599999999',
                'isWhatsapp' => true,
            ]);

        $response
            ->assertUnauthorized()
            ->assertExactJson([
                'message' => 'Tenant session is invalid.',
            ]);
    }

    public function test_show_returns_uid_as_id_without_internal_identifiers(): void
    {
        $tenant = Tenant::factory()->create();
        Sanctum::actingAs(User::factory()->create([
            'tenant_id' => $tenant->id,
        ]));

        $customer = Customer::create([
            'uid' => '5d8c6e8c-bf7a-4c8d-b4a7-7d1a6d7e3f10',
            'tenant_id' => $tenant->id,
            'name' => 'Ada Lovelace',
            'email' => 'ada@example.com',
            'phone' => '5512345678',
            'mobile' => '5599999999',
            'isWhatsapp' => true,
        ]);

        $response = $this
            ->withHeader('Tenant', $tenant->uid)
            ->getJson("/api/customers/{$customer->uid}");

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
