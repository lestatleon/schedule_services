<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Collection;

class BranchController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): JsonResponse
    {
        return response()->json(
            $this->serializeBranches(
                Branch::query()
                    ->whereRelation('tenant', 'id', $request->header('Tenant'))
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
            // 'tenant_id' => ['required', 'integer', 'exists:tenants,id'],
            'name' => ['required', 'string', 'max:255'],
            'default' => ['required', 'boolean'],
        ]);

        $branch = Branch::create($validated);

        return response()->json($branch, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Branch $branch): JsonResponse
    {
        return response()->json($branch);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Branch $branch): JsonResponse
    {
        $validated = $request->validate([
            'tenant_id' => ['sometimes', 'integer', 'exists:tenants,id'],
            'name' => ['sometimes', 'string', 'max:255'],
            'default' => ['required', 'boolean'],
        ]);

        $branch->update($validated);

        return response()->json($branch->fresh());
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Branch $branch): JsonResponse
    {
        $branch->delete();

        return response()->json(status: 204);
    }

    private function serializeBranches(Collection $branches): array
    {
        return $branches
            ->map(fn (Branch $branch): array => $this->serializeBranch($branch))
            ->all();
    }

    private function serializeBranch(Branch $branch): array
    {
        return [
            'id' => $branch->uid,
            'name' => $branch->name,
            'default' => $branch->default,
        ];
    }
}
