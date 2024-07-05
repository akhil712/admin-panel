<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class RoleRelation extends Pivot
{
    use HasFactory;
    protected $table = 'role_relations'; 

    protected $fillable = ['role_id', 'child_role_id'];

    public $timestamps = true;
}

