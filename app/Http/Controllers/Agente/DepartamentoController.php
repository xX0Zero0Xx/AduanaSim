<?php

namespace App\Http\Controllers\Agente;

use App\Http\Controllers\Controller;
use App\Models\Departamento;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class DepartamentoController extends Controller
{
    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'clave' => ['required', 'string', 'max:40', 'unique:departamentos,clave', 'regex:/^[A-Za-z0-9\-]+$/'],
            'nombre' => ['required', 'string', 'max:120'],
            'descripcion' => ['nullable', 'string', 'max:500'],
        ], [
            'clave.regex' => 'La clave solo puede contener letras, números y guiones.',
            'clave.unique' => 'Ya existe un departamento con esa clave.',
        ]);

        Departamento::create([
            'clave' => strtoupper(trim($data['clave'])),
            'nombre' => $data['nombre'],
            'descripcion' => $data['descripcion'] ?? null,
            'activo' => true,
            'created_by' => Auth::id(),
        ]);

        return back()->with('status', "Departamento {$data['clave']} creado.");
    }

    public function update(Request $request, Departamento $departamento): RedirectResponse
    {
        $data = $request->validate([
            'nombre' => ['required', 'string', 'max:120'],
            'descripcion' => ['nullable', 'string', 'max:500'],
            'activo' => ['nullable', 'boolean'],
        ]);

        $departamento->update([
            'nombre' => $data['nombre'],
            'descripcion' => $data['descripcion'] ?? null,
            'activo' => $request->boolean('activo', $departamento->activo),
        ]);

        return back()->with('status', 'Departamento actualizado.');
    }
}
