<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;
use App\Models\Permission;
use App\Models\RoleHasPermission;
use App\Models\RoleRelation;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        foreach (config('constants.roles') as $key => $value) {
            Role::create($value);
        }
        User::create([
            'name' => 'Developer',
            'email' => 'developer@techsagacrm.in',
            'phone' => '7377867897',
            'developer' => true,
            'password' => Hash::make('dev@techsaga@123'),
        ]);
    }
}
