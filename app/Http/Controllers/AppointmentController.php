<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Branch;
use App\Models\Customer;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class AppointmentController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): JsonResponse
    {
        return response()->json(
            $this->serializeAppointments(
                Appointment::query()
                    ->whereRelation('tenant', 'id', $request->header('Tenant'))
                    ->with(['branch', 'customer'])
                    ->latest('id')
                    ->get()
            )
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'customer_id' => ['required'],
            'branch_id' => ['required'],
            'date' => ['required', 'date'],
            'time' => ['required', 'regex:/^\d{2}:\d{2}(:\d{2})?$/'],
            'duration' => ['required', 'integer', 'min:1'],
            'notes' => ['max:250'],
        ]);

        $customer = $this->resolveCustomer($validated['customer_id']);
        $branch = $this->resolveBranch($validated['branch_id']);

        $validated['time'] = $this->normalizeTime($validated['time']);
        $validated['customer_id'] = $customer->id;
        $validated['branch_id'] = $branch->id;
        $validated['tenant_id'] = $this->resolveTenantId($customer, $branch);

        $appointment = Appointment::create($validated);

        return response()->json(
            $this->serializeAppointment(
                $appointment->load(['tenant', 'branch', 'customer'])
            ), 201
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(Appointment $appointment): JsonResponse
    {
        return response()->json($this->serializeAppointment($appointment->loadMissing(['tenant', 'branch', 'customer'])));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Appointment $appointment): JsonResponse
    {
        $validated = $request->validate([
            'customer_id' => ['sometimes'],
            'branch_id' => ['sometimes'],
            'date' => ['sometimes', 'date'],
            'time' => ['sometimes', 'regex:/^\d{2}:\d{2}(:\d{2})?$/'],
            'duration' => ['sometimes', 'integer', 'min:1'],
            'notes' => ['max:250']
        ]);

        if (isset($validated['time'])) {
            $validated['time'] = $this->normalizeTime($validated['time']);
        }

        if (isset($validated['customer_id']) || isset($validated['branch_id'])) {
            $customer = isset($validated['customer_id'])
                ? $this->resolveCustomer($validated['customer_id'])
                : $appointment->customer;

            $branch = isset($validated['branch_id'])
                ? $this->resolveBranch($validated['branch_id'])
                : $appointment->branch;

            $validated['customer_id'] = $customer->id;
            $validated['branch_id'] = $branch->id;
            $validated['tenant_id'] = $this->resolveTenantId($customer, $branch);
        }

        $appointment->update($validated);

        return response()->json(
            $this->serializeAppointment(
                $appointment->fresh()->load(['tenant', 'branch', 'customer'])
            )
        );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Appointment $appointment): JsonResponse
    {
        $appointment->delete();

        return response()->json(status: 204);
    }

    /**
     * Undocumented function
     */
    private function serializeAppointments(Collection $appointments): array
    {
        return $appointments
            ->map(fn (Appointment $appointment): array => $this->serializeAppointment($appointment))
            ->all();
    }

    /**
     * Undocumented function
     */
    private function serializeAppointment(Appointment $appointment): array
    {
        $appointment->loadMissing(['tenant', 'branch', 'customer']);

        return [
            'id' => $appointment->uid,
            // 'tenant_id' => $appointment->tenant?->uid ?? (string) $appointment->tenant_id,
            'branch_id' => $appointment->branch?->uid ?? (string) $appointment->branch_id,
            'customer_id' => $appointment->customer?->uid ?? (string) $appointment->customer_id,
            'customer_name' => $appointment->customer?->name,
            'date' => $appointment->date?->format('Y-m-d'),
            'time' => $appointment->time,
            'notes' => $appointment->notes,
            'duration' => $appointment->duration,
        ];
    }

    /**
     *
     */
    private function normalizeTime(string $time): string
    {
        return strlen($time) === 5 ? "{$time}:00" : $time;
    }

    /**
     *
     */
    private function resolveTenantId(Customer $customer, Branch $branch): int
    {
        if ($customer->tenant_id !== $branch->tenant_id) {
            throw ValidationException::withMessages([
                'branch_id' => ['The selected branch does not belong to the same tenant as the customer.'],
            ]);
        }

        return $customer->tenant_id;
    }

    /**
     *
     */
    private function resolveCustomer(mixed $identifier): Customer
    {
        return $this->resolveModel(Customer::query(), $identifier, 'customer_id', 'uid');
    }

    /**
     *
     */
    private function resolveBranch(mixed $identifier): Branch
    {
        return $this->resolveModel(Branch::query(), $identifier, 'branch_id', 'uid');
    }

    /**
     * Undocumented function
     *
     */
    private function resolveModel($query, mixed $identifier, string $field, string $publicKey)
    {
        $model = is_numeric($identifier)
            ? $query->whereKey($identifier)->orWhere($publicKey, (string) $identifier)->first()
            : $query->where($publicKey, (string) $identifier)->first();

        if ($model !== null) {
            return $model;
        }

        throw ValidationException::withMessages([
            $field => ['The selected value is invalid.'],
        ]);
    }
}
