<?php

namespace App\Http\Controllers;

use App\Http\Requests\CustomerPostRequest;
use App\Models\Customer;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): JsonResponse
    {
        return response()->json(
            $this->serializeCustomers(
                Customer::query()
                    ->whereRelation('tenant', 'id', $request->header('Tenant'))
                    ->latest('id')
                    ->get()
            )
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CustomerPostRequest $request): JsonResponse
    {
        $validated = $request->validated();

        $validated['tenant_id'] = $request->header('Tenant');

        $customer = Customer::create($validated);

        return response()->json($this->serializeCustomer($customer), 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Customer $customer): JsonResponse
    {
        return response()->json($this->serializeCustomer($customer));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Customer $customer): JsonResponse
    {
        $validated = $request->validate([
            // 'tenant_id' => ['sometimes', 'integer', 'exists:tenants,id'],
            // 'name' => ['sometimes', 'string', 'max:255'],
            // 'email' => ['sometimes', 'email', 'max:255'],
            // 'phone' => ['sometimes', 'string', 'max:15'],
            // 'mobile' => ['sometimes', 'string', 'max:15'],
            // 'isWhatsapp' => ['sometimes', 'boolean'],

            'name' => ['required', 'string', 'max:255'],
            'email' => 'max:255',
            'mobile' => 'required|max:15',
            'isWhatsapp' => 'boolean:strict',
        ]);

        $validated['tenant_id'] = 1;

        $customer->update($validated);

        return response()->json($this->serializeCustomer($customer->fresh()));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Customer $customer): JsonResponse
    {
        $customer->delete();

        return response()->json(status: 204);
    }

    private function serializeCustomers(Collection $customers): array
    {
        return $customers
            ->map(fn (Customer $customer): array => $this->serializeCustomer($customer))
            ->all();
    }

    private function serializeCustomer(Customer $customer): array
    {
        return [
            'id' => $customer->uid,
            'tenant' => $customer->tenant_id,
            'name' => $customer->name,
            'email' => $customer->email,
            'phone' => $customer->phone,
            'mobile' => $customer->mobile,
            'isWhatsapp' => $customer->isWhatsapp,
        ];
    }
}
