<?php

namespace App\Http\DataLayer;

use App\Models\Role;

class RoleDataLayer
{
    public function getAll()
    {
        $roles = Role::orderBy('id', 'ASC')->get();
        return $roles->isEmpty() ? [] : $roles;
    }
}
