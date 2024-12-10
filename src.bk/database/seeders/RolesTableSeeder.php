<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Role; // Asegúrate de importar el modelo correcto

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
	Role::create(['name' => 'Administrador']);
        Role::create(['name' => 'Operador']);
        Role::create(['name' => 'Conductor']);
    }
}
