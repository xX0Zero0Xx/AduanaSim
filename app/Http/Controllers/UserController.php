<?php

/*
linea 152 cambiar form,ato del correo
linea 56 cambiar contraseña por defecto
linea 43 contraseña segura o algo asi xd no me acuerdo
*/

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function index(): RedirectResponse
    {
        return redirect()->route('dashboard', ['tab' => 'usuarios']);
    }

    // Compatibility for old links. User forms now live in dashboard modals.
    public function create(): RedirectResponse
    {
        return redirect()->route('dashboard', ['tab' => 'usuarios']);
    }

    public function edit(User $usuario): RedirectResponse
    {
        return redirect()->route('dashboard', ['tab' => 'usuarios']);
    }

    public function store(Request $request): RedirectResponse
    {
        $validator = Validator::make($request->all(), [
            'nombres' => ['required', 'string', 'max:120'],
            'apellidos' => ['required', 'string', 'max:120'],
            'rol' => ['required', Rule::in(['admin', 'agente', 'capturista'])],
            //'password' => ['required', 'string', 'min:10', 'confirmed'],
        ]);
        if ($validator->fails()) {
            return redirect()->route('dashboard', ['tab' => 'usuarios'])->withErrors($validator)->withInput();
        }
        $validated = $validator->validated();

        $name = trim($validated['nombres'] . ' ' . $validated['apellidos']);
        $email = $this->generarEmailInstitucional($validated['nombres'], $validated['apellidos']);

        $user = User::create([
            'name' => $name,
            'email' => $email,
            // 'password' => Hash::make($validated['password']),
            'password' => Hash::make('AduanaSim@2026_UPTex'), // contraseña por defecto pa vitar p2
            'rol' => $validated['rol'],
            'activo' => true,
            'email_verified_at' => now(),
        ]);

        return $this->usersRedirect()->with('status', "Usuario «{$user->name}» creado. Correo asignado: {$user->email}.");
    }


    public function update(Request $request, User $usuario): RedirectResponse
    {
        if ($usuario->id === Auth::id()) {
            return $this->usersRedirect()->with('error', 'No puedes editar tu propia cuenta desde esta sección.');
        }

        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', Rule::unique('users', 'email')->ignore($usuario->id)],
            'rol' => ['required', Rule::in(['admin', 'agente', 'capturista'])],
        ]);
        if ($validator->fails()) {
            return redirect()->route('dashboard', ['tab' => 'usuarios'])->withErrors($validator)->withInput();
        }
        $validated = $validator->validated();

        // Never remove or demote the last active administrator.
        if ($usuario->isAdmin() && ($validated['rol'] !== 'admin' || !($usuario->activo ?? true))) {
            $remainingAdmins = User::where('rol', 'admin')->where('activo', true)->where('id', '!=', $usuario->id)->count();
            if ($remainingAdmins < 1 && $validated['rol'] !== 'admin') {
                return $this->usersRedirect()->with('error', 'No puedes retirar el rol del último administrador activo.');
            }
        }

        $usuario->update($validated);

        return $this->usersRedirect()->with('status', 'Usuario actualizado correctamente.');
    }


    public function suspend(User $usuario): RedirectResponse
    {
        if ($usuario->id === Auth::id()) {
            return $this->usersRedirect()->with('error', 'No puedes suspender tu propia sesión.');
        }


        if ($usuario->isAdmin()) {
            $activeAdmins = User::where('rol', 'admin')->where('activo', true)->count();
            if (($usuario->activo ?? true) && $activeAdmins <= 1) {
                return $this->usersRedirect()->with('error', 'No se puede suspender al último administrador activo.');
            }
        }


        $usuario->update(['activo' => false]);
        return $this->usersRedirect()->with('status', "Usuario «{$usuario->name}» suspendido.");
    }


    public function activate(User $usuario): RedirectResponse
    {
        $usuario->update(['activo' => true]);
        return $this->usersRedirect()->with('status', "Usuario «{$usuario->name}» reactivado.");
    }


    public function destroy(User $usuario): RedirectResponse
    {
        if ($usuario->id === Auth::id()) {
            return $this->usersRedirect()->with('error', 'No puedes eliminar tu propia cuenta desde esta sección.');
        }

        if ($usuario->isAdmin()) {
            $activeAdmins = User::where('rol', 'admin')->where('activo', true)->count();
            $deletingActiveAdmin = ($usuario->activo ?? true);
            if ($deletingActiveAdmin && $activeAdmins <= 1) {
                return $this->usersRedirect()->with('error', 'No puedes eliminar al último administrador activo.');
            }
        }


        $name = $usuario->name;
        $usuario->equipos()->detach();
        $usuario->delete();

        return $this->usersRedirect()->with('status', "Usuario «{$name}» eliminado.");
    }


    private function usersRedirect(): RedirectResponse
    {
        return redirect()->route('dashboard', ['tab' => 'usuarios']);
    }


    private function generarEmailInstitucional(string $nombres, string $apellidos): string
    {
        $firstName = $this->normalizarToken($this->primerToken($nombres));
        $firstLastName = $this->normalizarToken($this->primerToken($apellidos));
        $base = $firstName . '.' . $firstLastName;
        $domain = '@aduanasim.com';
        $email = $base . $domain;
        $suffix = 1;

        while (User::where('email', $email)->exists()) {
            $suffix++;
            $email = $base . $suffix . $domain;
        }

        return $email;
    }


    private function primerToken(string $texto): string
    {
        $partes = preg_split('/\s+/u', trim($texto)) ?: [];
        return $partes[0] ?? 'usuario';
    }


    private function normalizarToken(string $texto): string
    {
        $texto = mb_strtolower(trim($texto));
        $texto = strtr($texto, [
            'á' => 'a',
            'à' => 'a',
            'ä' => 'a',
            'â' => 'a',
            'é' => 'e',
            'è' => 'e',
            'ë' => 'e',
            'ê' => 'e',
            'í' => 'i',
            'ì' => 'i',
            'ï' => 'i',
            'î' => 'i',
            'ó' => 'o',
            'ò' => 'o',
            'ö' => 'o',
            'ô' => 'o',
            'ú' => 'u',
            'ù' => 'u',
            'ü' => 'u',
            'û' => 'u',
            'ñ' => 'n',
            'ç' => 'c',
        ]);
        $texto = preg_replace('/[^a-z0-9]/', '', $texto) ?? '';
        return $texto !== '' ? $texto : 'usuario';
    }
}
