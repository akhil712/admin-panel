<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'leader_id',
        'date',
        'deadline_date',
    ];

    public function leader()
    {
        return $this->belongsTo(User::class, 'leader_id', 'id');
    }


    public function projectUsers()
    {
        return $this->hasMany(ProjectUser::class, 'project_id', 'id');
    }

    public function developers()
    {
        return $this->projectUsers()->whereHas('role', function ($query) {
            $query->where('id', config('constants.roles.developer.id'));
        })->with('user');
    }

    public function testers()
    {
        return $this->projectUsers()->whereHas('role', function ($query) {
            $query->where('id', config('constants.roles.tester.id'));
        })->with('user');
    }

    public function clients()
    {
        return $this->projectUsers()->whereHas('role', function ($query) {
            $query->where('id', config('constants.roles.client.id'));
        })->with('user');
    }


}
