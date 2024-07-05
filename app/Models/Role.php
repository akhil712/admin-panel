<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Role extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'role_has_permissions')
                    ->withTimestamps()
                    ->using(RoleHasPermission::class);
    }

    public function childRoles()
    {
        return $this->belongsToMany(Role::class, 'role_relations', 'role_id', 'child_role_id')
                    ->withTimestamps()
                    ->withPivot('id');
    }

    public function parentRoles()
    {
        return $this->belongsToMany(Role::class, 'role_relations', 'child_role_id', 'role_id')
                    ->withTimestamps()
                    ->withPivot('id');
    }


    public $timestamps = true;
}
