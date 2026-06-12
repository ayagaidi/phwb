<?php

if (!function_exists('hasPermission')) {
    function hasPermission(?string $section, ?string $action = null): bool
    {
        $user = Illuminate\Support\Facades\Auth::user();

        if (!$user) {
            return false;
        }

        if (($user->role ?? null) === 'owner' || ($user->role ?? null) === 'admin') {
            return true;
        }

        $permissions = $user->permissions ?? [];

        if (!is_array($permissions)) {
            $permissions = json_decode($permissions, true) ?? [];
        }

        if (!isset($permissions[$section]) || !is_array($permissions[$section])) {
            return false;
        }

        if (empty($permissions[$section])) {
            return false;
        }

        if ($action === null) {
            return true;
        }

        return in_array($action, $permissions[$section], true);
    }
}
