<?php

namespace App\Http\Controllers\Agente;

use App\Http\Controllers\Controller;
use App\Models\Cove;
use App\Models\Doda;
use App\Models\Equipo;
use App\Models\Pedimento;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class EquipoGestionController extends Controller
{
    public function index(): View
    {
        $equipos = Equipo::with(['users' => fn ($q) => $q->orderBy('name')])
            ->orderBy('nombre')
            ->get();

        $stats = [];
        foreach ($equipos as $equipo) {
            $stats[$equipo->id] = [
                'pedimentos' => Pedimento::where('equipo_id', $equipo->id)->count(),
                'coves' => Cove::where('equipo_id', $equipo->id)->count(),
                'dodas' => Doda::where('equipo_id', $equipo->id)->count(),
                'miembros' => $equipo->users->count(),
            ];
        }

        return view('agente.equipos.index', compact('equipos', 'stats'));
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'nombre' => ['required', 'string', 'max:120'],
            'descripcion' => ['nullable', 'string', 'max:500'],
        ]);

        $equipo = Equipo::create([
            'nombre' => $data['nombre'],
            'descripcion' => $data['descripcion'] ?? null,
            'activo' => true,
        ]);

        return redirect()
            ->route('agente.equipos.show', $equipo)
            ->with('status', "Equipo «{$equipo->nombre}» creado.");
    }

    public function show(Equipo $equipo): View
    {
        $equipo->load(['users' => fn ($q) => $q->orderBy('name')]);

        $capturistas = User::query()
            ->where('rol', 'capturista')
            ->where('activo', true)
            ->orderBy('name')
            ->get();

        $stats = [
            'pedimentos' => Pedimento::where('equipo_id', $equipo->id)->count(),
            'coves' => Cove::where('equipo_id', $equipo->id)->count(),
            'dodas' => Doda::where('equipo_id', $equipo->id)->count(),
        ];

        return view('agente.equipos.show', compact('equipo', 'capturistas', 'stats'));
    }

    public function update(Request $request, Equipo $equipo): RedirectResponse
    {
        $data = $request->validate([
            'nombre' => ['required', 'string', 'max:120'],
            'descripcion' => ['nullable', 'string', 'max:500'],
            'activo' => ['nullable', 'boolean'],
        ]);

        $equipo->update([
            'nombre' => $data['nombre'],
            'descripcion' => $data['descripcion'] ?? null,
            'activo' => $request->boolean('activo', $equipo->activo),
        ]);

        return back()->with('status', 'Equipo actualizado.');
    }

    public function destroy(Equipo $equipo): RedirectResponse
    {
        $nombre = $equipo->nombre;
        $equipo->users()->detach();
        $equipo->delete();

        return redirect()
            ->route('agente.equipos.index')
            ->with('status', "Equipo «{$nombre}» eliminado.");
    }

    public function attachMember(Request $request, Equipo $equipo): RedirectResponse
    {
        $data = $request->validate([
            'user_id' => ['required', 'exists:users,id'],
            'rol_en_equipo' => ['nullable', 'in:lider,miembro'],
        ]);

        $user = User::findOrFail($data['user_id']);
        abort_unless($user->rol === 'capturista', 422, 'Solo se pueden agregar capturistas al equipo.');

        $equipo->users()->syncWithoutDetaching([
            $user->id => ['rol_en_equipo' => $data['rol_en_equipo'] ?? 'miembro'],
        ]);

        return back()->with('status', "{$user->name} agregado al equipo.");
    }

    public function detachMember(Equipo $equipo, User $user): RedirectResponse
    {
        $equipo->users()->detach($user->id);

        return back()->with('status', "{$user->name} removido del equipo.");
    }
}
