<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Permission extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'type', 'category'];

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'role_has_permissions')
                    ->withTimestamps()
                    ->withPivot('id')
                    ->using(RoleHasPermission::class);
    }

    public $timestamps = true;
}

