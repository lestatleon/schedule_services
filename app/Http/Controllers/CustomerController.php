<?php

namespace App\Http\Controllers;

use App\Http\Requests\CustomerPostRequest;
use App\Models\Customer;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        return response()->json(Customer::query()->latest('id')->get(
            [
                'uid',
                'name',
                'email',
                'phone',
                'mobile',
                'isWhatsapp',
            ]
        ));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CustomerPostRequest $request): JsonResponse
    {
        $validated = $request->validated();
        // dump($validated);

        // $validated->mergeIfMissing(['email' => 0]);

        $validated['tenant_id'] = 1;

        $customer = Customer::create($validated);

        return response()->json($customer, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Customer $customer): JsonResponse
    {
        return response()->json($customer);
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

        return response()->json($customer->fresh());
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Customer $customer): JsonResponse
    {
        $customer->delete();

        return response()->json(status: 204);
    }
}
