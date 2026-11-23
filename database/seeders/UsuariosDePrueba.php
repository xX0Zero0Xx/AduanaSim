<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Env;
use Illuminate\Support\Facades\DB;
use Nette\Utils\Process;

class UsuariosDePrueba extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            'name' => 'Admin',
            'email' => 'admin@AduanaSim.local',
            'password' => bcrypt('Panecito123'),
            //'password' => bcrypt(env('PASSWORD_ADMIN')),
            'rol' => 'admin'
        ]);

        DB::table('users')->insert([
            'name' => 'agente',
            'email' => 'agente@AduanaSim.local',
            'password' => bcrypt('Panecito123'),
            //'password' => bcrypt(env('PASSWORD_AGENTE')),
            'rol' => 'agente'
        ]);

        DB::table('users')->insert([
            'name' => 'capturista',
            'email' => 'capturista@AduanaSim.local',
            'password' => bcrypt('Panecito123'),
            //'password' => bcrypt(env('PASSWORD_CAPTURISTA')),
            'rol' => 'capturista'
        ]);
    }
}
