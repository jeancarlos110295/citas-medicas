<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RolesSeeder extends Seeder
{
    public function run(): void
    {
        // Crear los roles si no existen
        Role::firstOrCreate(['name' => 'medico']);
        Role::firstOrCreate(['name' => 'paciente']);
    }
}
