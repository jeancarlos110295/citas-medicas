<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RolesSeeder extends Seeder
{
    public function run(): void
    {
        $roles = [
            ['name' => User::NAME_ROL_MEDICO, 'guard_name' => 'sanctum'],
            ['name' => User::NAME_ROL_PACIENTE, 'guard_name' => 'sanctum'],
        ];

        foreach ($roles as $role) {
            Role::updateOrCreate(
                ['name' => $role['name'], 'guard_name' => $role['guard_name']]
            );
        }
    }
}
