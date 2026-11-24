<?php

namespace App\Http\Controllers\Agente;

use App\Http\Controllers\Controller;
use App\Models\Departamento;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\View\View;

class UsuarioController extends Controller
{
    public const DEFAULT_PASSWORD = 'AduanaSim@UPTex2026';

    public function index(Request $request): View
    {
        $departamentoId = $request->get('departamento_id');

        $departamentos = Departamento::orderBy('clave')->get();

        $capturistas = User::query()
            ->where('rol', 'capturista')
            ->with('departamento')
            ->when($departamentoId, fn ($q) => $q->where('departamento_id', $departamentoId))
            ->orderBy('name')
            ->get();

        return view('agente.usuarios.index', [
            'departamentos' => $departamentos,
            'capturistas' => $capturistas,
            'departamentoId' => $departamentoId,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'primer_nombre' => ['required', 'string', 'max:60'],
            'segundo_nombre' => ['nullable', 'string', 'max:60'],
            'apellido_paterno' => ['required', 'string', 'max:60'],
            'apellido_materno' => ['required', 'string', 'max:60'],
            'departamento_id' => ['required', 'exists:departamentos,id'],
        ], [
            'primer_nombre.required' => 'El primer nombre es obligatorio.',
            'apellido_paterno.required' => 'El apellido paterno es obligatorio.',
            'apellido_materno.required' => 'El apellido materno es obligatorio.',
            'departamento_id.required' => 'Debes asociar el capturista a un departamento.',
        ]);

        $partesNombre = array_filter([
            trim($data['primer_nombre']),
            trim($data['segundo_nombre'] ?? ''),
            trim($data['apellido_paterno']),
            trim($data['apellido_materno']),
        ]);
        $nombreCompleto = implode(' ', $partesNombre);

        $email = $this->generarEmailUnico(
            $data['primer_nombre'],
            $data['apellido_paterno']
        );

        User::create([
            'name' => $nombreCompleto,
            'email' => $email,
            'password' => Hash::make(self::DEFAULT_PASSWORD),
            'rol' => 'capturista',
            'activo' => true,
            'departamento_id' => $data['departamento_id'],
            'email_verified_at' => now(),
        ]);

        return back()->with(
            'status',
            "Capturista «{$nombreCompleto}» creado. Correo: {$email} · Contraseña inicial: ".self::DEFAULT_PASSWORD
        );
    }

    public function update(Request $request, User $usuario): RedirectResponse
    {
        abort_unless($usuario->rol === 'capturista', 403);

        $data = $request->validate([
            'name' => ['required', 'string', 'max:120'],
            'departamento_id' => ['required', 'exists:departamentos,id'],
            'activo' => ['nullable', 'boolean'],
        ]);

        $usuario->name = $data['name'];
        $usuario->departamento_id = $data['departamento_id'];
        $usuario->activo = $request->boolean('activo', $usuario->activo);
        $usuario->save();

        return back()->with('status', 'Usuario actualizado.');
    }

    /** El agente no elimina usuarios. */
    public function destroy(User $usuario): RedirectResponse
    {
        abort(403, 'El agente no puede eliminar usuarios.');
    }

    private function generarEmailUnico(string $nombre, string $apellido): string
    {
        $n = Str::of($nombre)->ascii()->lower()->replaceMatches('/[^a-z0-9]/', '')->toString();
        $a = Str::of($apellido)->ascii()->lower()->replaceMatches('/[^a-z0-9]/', '')->toString();

        if ($n === '') {
            $n = 'capturista';
        }
        if ($a === '') {
            $a = 'user';
        }

        $base = "{$n}.{$a}";
        $email = "{$base}@aduanasim.com";
        $i = 1;

        while (User::where('email', $email)->exists()) {
            $email = "{$base}{$i}@aduanasim.com";
            $i++;
        }

        return $email;
    }
}
