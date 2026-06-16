<?php

namespace App\Http\Middleware;

use App\Models\Tenant;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;

class TenantMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $tenantIdentifier = $request->header('Tenant');

        if (blank($tenantIdentifier) || ! Str::isUuid($tenantIdentifier)) {
            return response()->json([
                'message' => 'Tenant session is invalid.',
            ], 401);
        }

        $tenant = Tenant::query()->where('uid', (string) $tenantIdentifier)->first();

        if ($tenant === null) {
            return response()->json([
                'message' => 'Tenant session is invalid.',
            ], 401);
        }

        // $request->attributes->set('tenant', $tenant);
        // $request->attributes->set('tenant_id', $tenant->id);
        $request->headers->set('Tenant', (string) $tenant->id);

        return $next($request);
    }
}
