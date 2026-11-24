<?php

namespace Database\Seeders;

use App\Models\Departamento;
use App\Models\Equipo;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

class departamentos extends Seeder
{
    /**
     * Crea 2 departamentos, 4 equipos (2 por departamento) y 12 alumnos:
     * - Departamento 1 (6 alumnos): Equipo 1 (3 alumnos) y Equipo 2 (3 alumnos)
     * - Departamento 2 (6 alumnos): Equipo 3 (3 alumnos) y Equipo 4 (3 alumnos)
     */
    public function run(): void
    {
        $password = Hash::make('Panecito123');

        // Buscar agente existente para created_by (opcional)
        $agente = User::where('rol', 'agente')->first();

        // 1. Crear los 2 Departamentos
        $departamentos = [];
        if (Schema::hasTable('departamentos')) {
            $departamentos[1] = Departamento::updateOrCreate(
                ['clave' => 'DEP-ALU-01'],
                [
                    'nombre' => 'Departamento Alumnos 1',
                    'descripcion' => 'Departamento académico 1 (Alumnos 01 al 06)',
                    'activo' => true,
                    'created_by' => $agente?->id,
                ]
            );

            $departamentos[2] = Departamento::updateOrCreate(
                ['clave' => 'DEP-ALU-02'],
                [
                    'nombre' => 'Departamento Alumnos 2',
                    'descripcion' => 'Departamento académico 2 (Alumnos 07 al 12)',
                    'activo' => true,
                    'created_by' => $agente?->id,
                ]
            );
        }

        // 2. Crear los 4 Equipos (2 por departamento)
        $equipos = [];
        for ($eq = 1; $eq <= 4; $eq++) {
            $depIndex = $eq <= 2 ? 1 : 2;
            $attrsEquipo = [
                'descripcion' => "Equipo {$eq} - Departamento {$depIndex}",
                'activo' => true,
            ];

            // Por si la tabla equipos tiene llave foránea a departamento_id
            if (isset($departamentos[$depIndex]) && Schema::hasColumn('equipos', 'departamento_id')) {
                $attrsEquipo['departamento_id'] = $departamentos[$depIndex]->id;
            }

            $equipos[$eq] = Equipo::updateOrCreate(
                ['nombre' => "Equipo {$eq}"],
                $attrsEquipo
            );
        }

        // 3. Crear los 12 Alumnos y distribuirlos
        $asignacionesEquipo = [1 => [], 2 => [], 3 => [], 4 => []];

        for ($i = 1; $i <= 12; $i++) {
            $numero = str_pad((string) $i, 2, '0', STR_PAD_LEFT); // 01, 02 ... 12
            $depIndex = $i <= 6 ? 1 : 2;                          // 1..6 -> Dep 1 | 7..12 -> Dep 2
            $equipoIndex = (int) ceil($i / 3);                    // 1..3 -> Eq 1 | 4..6 -> Eq 2 | 7..9 -> Eq 3 | 10..12 -> Eq 4

            $attrsUser = [
                'name' => "Alumno{$numero}",
                'password' => $password,
                'rol' => 'capturista',
                'activo' => true,
                'email_verified_at' => now(),
            ];

            if (isset($departamentos[$depIndex]) && Schema::hasColumn('users', 'departamento_id')) {
                $attrsUser['departamento_id'] = $departamentos[$depIndex]->id;
            }

            $user = User::updateOrCreate(
                ['email' => "alumno{$numero}@aduanasim.local"],
                $attrsUser
            );

            // El primer alumno de cada tercia queda como líder del equipo
            $esLider = ($i % 3 === 1);
            $asignacionesEquipo[$equipoIndex][$user->id] = [
                'rol_en_equipo' => $esLider ? 'lider' : 'miembro',
            ];
        }

        // 4. Sincronizar alumnos en sus equipos correspondientes
        foreach ($equipos as $eqIndex => $equipoModel) {
            $equipoModel->users()->syncWithoutDetaching($asignacionesEquipo[$eqIndex]);
        }

        $this->command?->info('AlumnosSeeder ejecutado con éxito:');
        $this->command?->info('  DEP-ALU-01: Equipo 1 (Alumno01-03) y Equipo 2 (Alumno04-06)');
        $this->command?->info('  DEP-ALU-02: Equipo 3 (Alumno07-09) y Equipo 4 (Alumno10-12)');
        $this->command?->info('  Credenciales: alumno01@aduanasim.local … alumno12@aduanasim.local / Panecito123');
    }
}
