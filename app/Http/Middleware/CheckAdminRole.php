<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckAdminRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param  string  ...$roles
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        if (! Auth::guard('admin')->check()) {
            if ($request->expectsJson()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Unauthenticated.',
                ], 401);
            }

            return redirect()->route('admin.login')
                ->with('error', 'Silakan login terlebih dahulu untuk mengakses panel admin.');
        }

        $admin = Auth::guard('admin')->user();

        // If no role specified, any authenticated admin is allowed
        if (empty($roles)) {
            return $next($request);
        }

        // Super Admin has access to all modules and routes
        if ($admin->isSuperAdmin()) {
            return $next($request);
        }

        // Handle "module" prefix: e.g. "admin.role:module,esport"
        if ($roles[0] === 'module' && isset($roles[1])) {
            $module = $roles[1];
            if ($admin->canAccessModule($module)) {
                return $next($request);
            }

            return $this->forbiddenResponse($request, "Akses ditolak. Anda tidak memiliki izin untuk mengakses modul {$module}.");
        }

        // Handle list of allowed roles: e.g. "admin.role:admin_buku_tamu,admin_esport"
        if ($admin->hasRole($roles)) {
            return $next($request);
        }

        return $this->forbiddenResponse($request, 'Akses ditolak. Peran Anda tidak memiliki izin untuk halaman ini.');
    }

    /**
     * Return forbidden response based on request expectation.
     */
    protected function forbiddenResponse(Request $request, string $message): Response
    {
        if ($request->expectsJson()) {
            return response()->json([
                'status' => 'error',
                'message' => $message,
            ], 403);
        }

        abort(403, $message);
    }
}
