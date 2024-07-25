<?php

use App\Models\RoleUser;

if (! function_exists('checkAdmin')) {
    function checkAdmin($userId): bool
    {
        $adminRole = RoleUser::query()
            ->where('user_id', $userId)
            ->where('role_id', 1)
            ->first();

        return (bool)$adminRole;
    }
}
