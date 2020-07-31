<?php


namespace App\Traits;


use App\Models\Permission;
use App\Models\Role;

trait HasRolesAndPermissions
{
    public function roles()
    {
        return $this->belongsToMany(Role::class, 'users_roles');
    }

    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'users_permissions');
    }

    public function hasRole(...$roles)
    {
        foreach ($roles as $role) {
            if ($this->roles->contains('slug', $role)) {
                return true;
            };
        }
        return false;
    }

    protected function hasPermission($permission)
    {
        return (bool)$this->permissions->whereSlug($permission->slug)->count();
    }

    protected function hasPermissionTo($permission)
    {
        return $this->hasPermissionThroughRole($permission) || $this->hasPermission($permission);
    }

    public function hasPermissionThroughRole($permission)
    {
        foreach ($permission->roles as $role) {
            if ($this->roles->contains($role)) {
                return true;
            }
        }

        return false;
    }

    protected function getAllPermission(array $permissions)
    {
        return Permission::whereIn('slug', $permissions)->get();
    }

    public function givePermissionsTo(...$permissions)
    {
        $permissions = $this->getAllPermission($permissions);
        if (is_null($permissions)) {
            return $this;
        }

        $this->permissions()->saveMany($permissions);
        return $this;
    }

    public function deletePermissions(...$permissions){
        $permissions = $this->getAllPermission($permissions);
        $this->permissions()->detach($permissions);
        return $this;
    }

    public function refreshPermissions(...$permissions)
    {
        $this->permissions()->detach();
        return $this->givePermissionsTo($permissions);
    }
}
