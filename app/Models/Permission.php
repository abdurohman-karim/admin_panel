<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'guard_name'];

    // Roles that have the permission
    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }

    // Users that have the permission (optional)
    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    // Assign permission to a role
    public function assignRole($role)
    {
        if (is_string($role)) {
            $role = Role::where('name', $role)->firstOrFail();
        }
        $this->roles()->syncWithoutDetaching($role);
    }

    // Remove permission from a role
    public function removeRole($role)
    {
        if (is_string($role)) {
            $role = Role::where('name', $role)->first();
        }
        $this->roles()->detach($role);
    }
}
