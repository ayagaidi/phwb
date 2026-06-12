<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminPermission
{
    public function handle(Request $request, Closure $next, string $section, ?string $action = null)
    {
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('admin.login');
        }

        if ($user->role === 'owner') {
            return $next($request);
        }

        $permissions = $user->permissions ?? [];

        if (!is_array($permissions)) {
            $permissions = json_decode($permissions, true) ?? [];
        }

        if (!isset($permissions[$section])) {
            abort(403, __('admin.no_permission'));
        }

        if ($action && !in_array($action, $permissions[$section])) {
            abort(403, __('admin.no_permission'));
        }

        return $next($request);
    }
}
