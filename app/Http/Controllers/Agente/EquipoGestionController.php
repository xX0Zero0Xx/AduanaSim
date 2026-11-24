<?php

namespace App\Http\Controllers\Agente;

use App\Http\Controllers\Controller;
use App\Models\Cove;
use App\Models\Departamento;
use App\Models\Doda;
use App\Models\Equipo;
use App\Models\Pedimento;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class EquipoGestionController extends Controller
{
    public function create(): View
    {
        $equiposExistentes = Equipo::with(['users.departamento'])
            ->orderBy('nombre')
            ->get()
            ->map(function ($equipo) {
                $departamentos = $equipo->users
                    ->map(fn($u) => $u->departamento?->clave ?? $u->departamento?->nombre)
                    ->filter()
                    ->unique()
                    ->values();

                return [
                    'nombre' => $equipo->nombre,
                    'departamento' => $departamentos->isNotEmpty() ? $departamentos->implode(', ') : 'Sin departamento',
                ];
            });

        return view('agente.equipos.create', compact('equiposExistentes'));
    }

    public function index(Request $request): View
    {
        $departamentoId = $request->get('departamento_id');

        $equipos = Equipo::with([
            'users' => fn($q) => $q->orderBy('name'),
            'users.departamento' => fn($q) => $q->orderBy('nombre'),
        ])
            ->when($departamentoId, function ($q) use ($departamentoId) {
                $q->whereHas('users', fn($u) => $u->where('departamento_id', $departamentoId));
            })
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

        // Agrupar equipos por departamento (si tienen miembros de distintos departamentos, aparecen en cada grupo)
        $gruposEquipos = collect();
        foreach ($equipos as $equipo) {
            $deps = $equipo->users
                ->map(fn($u) => $u->departamento)
                ->filter()
                ->unique('id');

            if ($deps->isEmpty()) {
                $claveGrupo = 'Sin departamento';
                $gruposEquipos[$claveGrupo] = ($gruposEquipos[$claveGrupo] ?? collect())->push($equipo);
            } else {
                foreach ($deps as $dep) {
                    $claveGrupo = $dep->clave ? "{$dep->clave} — {$dep->nombre}" : $dep->nombre;
                    $gruposEquipos[$claveGrupo] = ($gruposEquipos[$claveGrupo] ?? collect())->push($equipo);
                }
            }
        }

        $departamento = $departamentoId
            ? Departamento::find($departamentoId)
            : null;

        return view('agente.equipos.index', compact('equipos', 'gruposEquipos', 'stats', 'departamento'));
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
        $equipo->load(['users' => fn($q) => $q->orderBy('name')]);

        $departamentos = Departamento::where('activo', true)
            ->orderBy('nombre')
            ->get();

        $capturistas = User::query()
            ->with('departamento')
            ->where('rol', 'capturista')
            ->where('activo', true)
            ->orderBy('name')
            ->get();

        $stats = [
            'pedimentos' => Pedimento::where('equipo_id', $equipo->id)->count(),
            'coves' => Cove::where('equipo_id', $equipo->id)->count(),
            'dodas' => Doda::where('equipo_id', $equipo->id)->count(),
        ];

        return view('agente.equipos.show', compact('equipo', 'departamentos', 'capturistas', 'stats'));
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
