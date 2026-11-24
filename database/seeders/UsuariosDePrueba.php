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

        /*
        $users = [
            ['name' => 'capturista',  'email' => 'capturista@AduanaSim.local'],
            ['name' => 'capturista2', 'email' => 'capturista2@AduanaSim.local'],
            ['name' => 'capturista3', 'email' => 'capturista3@AduanaSim.local'],
            ['name' => 'capturista4', 'email' => 'capturista4@AduanaSim.local'],
        ];

        foreach ($users as $user) {
            DB::table('users')->insert([
                'name'     => $user['name'],
                'email'    => $user['email'],
                'password' => bcrypt('Panecito123'),
                'rol'      => 'capturista',
            ]);
        }
    }
}


/*
<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsuariosDePrueba extends Seeder
{
    public function run(): void
    {
        // Admin y Agente (una sola inserción)
        DB::table('users')->insert([
            [
                'name'     => 'admin',
                'email'    => 'admin@AduanaSim.local',
                'password' => bcrypt('Panecito123'),
                'rol'      => 'admin',
            ],
            [
                'name'     => 'agente',
                'email'    => 'agente@AduanaSim.local',
                'password' => bcrypt('Panecito123'),
                'rol'      => 'agente',
            ],
        ]);

        // Capturistas (bucle)
        for ($i = 1; $i <= 5; $i++) {
            DB::table('users')->insert([
                'name'     => "capturista{$i}",
                'email'    => "capturista{$i}@AduanaSim.local",
                'password' => bcrypt('Panecito123'),
                'rol'      => 'capturista',
            ]);
        }
    }
}   
*/