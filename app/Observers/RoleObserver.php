<?php

namespace App\Observers;

use App\Models\Role;
use Illuminate\Support\Str;

class RoleObserver
{
    public function creating(Role $role)
    {
        $role->slug = Str::slug($role->name);
    }
}
