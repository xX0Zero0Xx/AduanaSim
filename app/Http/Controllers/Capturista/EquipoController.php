<?php

namespace App\Http\Controllers\Capturista;

use App\Http\Controllers\Controller;
use App\Models\Cove;
use App\Models\Doda;
use App\Models\Pedimento;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class EquipoController extends Controller
{
    public function index(): View
    {
        $user = Auth::user();

        $equipos = $user->equipos()
            ->where('equipos.activo', true)
            ->with(['users' => function ($q) {
                $q->select('users.id', 'users.name', 'users.email', 'users.rol', 'users.activo')
                    ->orderBy('users.name');
            }])
            ->get();

        $statsPorEquipo = [];

        foreach ($equipos as $equipo) {
            $statsPorEquipo[$equipo->id] = [
                'pedimentos' => Pedimento::where('equipo_id', $equipo->id)->count(),
                'coves' => Cove::where('equipo_id', $equipo->id)->count(),
                'dodas' => Doda::where('equipo_id', $equipo->id)->count(),
            ];
        }

        return view('capturista.equipo.index', compact('equipos', 'statsPorEquipo'));
    }
}
