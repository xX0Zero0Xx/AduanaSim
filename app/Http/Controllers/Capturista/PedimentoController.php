<?php

namespace App\Http\Controllers\Capturista;

use App\Http\Controllers\Controller;
use App\Models\Pedimento;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\Response;

class PedimentoController extends Controller
{
    public function index(Request $request): View
    {
        $user = Auth::user();

        $pedimentos = Pedimento::visiblesPara($user)
            ->with(['user:id,name', 'equipo:id,nombre'])
            ->when($request->estatus, fn ($q, $e) => $q->where('estatus', $e))
            ->when($request->q, function ($q, $term) {
                $q->where(function ($inner) use ($term) {
                    $inner->where('folio', 'like', "%{$term}%")
                        ->orWhere('nombre_operador', 'like', "%{$term}%")
                        ->orWhere('rfc_operador', 'like', "%{$term}%");
                });
            })
            ->latest()
            ->paginate(12)
            ->withQueryString();

        return view('capturista.pedimentos.index', compact('pedimentos'));
    }

    public function create(): View
    {
        return view('capturista.pedimentos.create', [
            'catalogos' => $this->catalogos(),
            'equipos' => Auth::user()->equipos()->where('activo', true)->get(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validatePedimento($request);
        $partidas = $this->normalizePartidas($request->input('partidas', []));

        $pedimento = DB::transaction(function () use ($data, $partidas) {
            $pedimento = Pedimento::create([
                ...$data,
                'user_id' => Auth::id(),
                'folio' => Pedimento::generarFolio($data['tipo'] ?? 'tradicional'),
                'estatus' => 'borrador',
                'valor_comercial' => collect($partidas)->sum('valor_comercial') ?: ($data['valor_comercial'] ?? 0),
                'valor_aduana' => collect($partidas)->sum('valor_aduana') ?: ($data['valor_aduana'] ?? 0),
            ]);

            foreach ($partidas as $i => $partida) {
                $pedimento->partidas()->create([...$partida, 'secuencia' => $i + 1]);
            }

            return $pedimento;
        });

        return redirect()
            ->route('capturista.pedimentos.show', $pedimento)
            ->with('status', "Pedimento {$pedimento->folio} creado como borrador.");
    }

    public function show(Pedimento $pedimento): View
    {
        $this->authorizeVisible($pedimento);
        $pedimento->load(['partidas', 'user:id,name', 'equipo:id,nombre', 'revisor:id,name']);

        return view('capturista.pedimentos.show', compact('pedimento'));
    }

    public function edit(Pedimento $pedimento): View|RedirectResponse
    {
        $this->authorizeVisible($pedimento);

        if (! $pedimento->puedeEditarse()) {
            return redirect()
                ->route('capturista.pedimentos.show', $pedimento)
                ->with('error', 'Solo se pueden editar pedimentos en borrador o devueltos.');
        }

        $pedimento->load('partidas');

        return view('capturista.pedimentos.edit', [
            'pedimento' => $pedimento,
            'catalogos' => $this->catalogos(),
            'equipos' => Auth::user()->equipos()->where('activo', true)->get(),
        ]);
    }

    public function update(Request $request, Pedimento $pedimento): RedirectResponse
    {
        $this->authorizeVisible($pedimento);

        if (! $pedimento->puedeEditarse()) {
            return redirect()
                ->route('capturista.pedimentos.show', $pedimento)
                ->with('error', 'Este pedimento ya no puede editarse.');
        }

        $data = $this->validatePedimento($request);
        $partidas = $this->normalizePartidas($request->input('partidas', []));

        DB::transaction(function () use ($pedimento, $data, $partidas) {
            $pedimento->update([
                ...$data,
                'valor_comercial' => collect($partidas)->sum('valor_comercial') ?: ($data['valor_comercial'] ?? 0),
                'valor_aduana' => collect($partidas)->sum('valor_aduana') ?: ($data['valor_aduana'] ?? 0),
                'observaciones_revision' => null,
            ]);

            $pedimento->partidas()->delete();
            foreach ($partidas as $i => $partida) {
                $pedimento->partidas()->create([...$partida, 'secuencia' => $i + 1]);
            }
        });

        return redirect()
            ->route('capturista.pedimentos.show', $pedimento)
            ->with('status', 'Pedimento actualizado.');
    }

    public function destroy(Pedimento $pedimento): RedirectResponse
    {
        $this->authorizeVisible($pedimento);

        if ($pedimento->estatus !== 'borrador') {
            return back()->with('error', 'Solo se pueden eliminar borradores.');
        }

        $folio = $pedimento->folio;
        $pedimento->delete();

        return redirect()
            ->route('capturista.pedimentos.index')
            ->with('status', "Pedimento {$folio} eliminado.");
    }

    public function enviar(Pedimento $pedimento): RedirectResponse
    {
        $this->authorizeVisible($pedimento);

        if (! $pedimento->puedeEnviarse()) {
            return back()->with('error', 'Este pedimento no puede enviarse a validación.');
        }

        if ($pedimento->partidas()->count() === 0) {
            return back()->with('error', 'Agrega al menos una partida antes de enviar.');
        }

        $pedimento->update([
            'estatus' => 'enviado',
            'enviado_at' => now(),
            'observaciones_revision' => null,
        ]);

        return back()->with('status', "Pedimento {$pedimento->folio} enviado a validación.");
    }

    public function pdf(Pedimento $pedimento, string $formato = 'tradicional'): Response
    {
        $this->authorizeVisible($pedimento);
        $pedimento->load('partidas');

        $formato = $formato === 'simplificado' ? 'simplificado' : 'tradicional';
        $view = $formato === 'simplificado'
            ? 'pdf.pedimento_simplificado'
            : 'pdf.pedimento_tradicional';

        $pdf = Pdf::loadView($view, ['pedimento' => $pedimento])
            ->setPaper('letter', 'portrait');

        $filename = "pedimento-{$pedimento->folio}-{$formato}.pdf";

        return $pdf->stream($filename);
    }

    /** Lookup por folio para autollenado de COVE/DODA */
    public function lookup(Request $request)
    {
        $folio = trim((string) $request->query('folio', ''));
        abort_if($folio === '', 422, 'Indica un folio.');

        $pedimento = Pedimento::visiblesPara(Auth::user())
            ->where('folio', $folio)
            ->with('partidas')
            ->first();

        if (! $pedimento) {
            return response()->json(['found' => false, 'message' => 'No se encontró un pedimento con ese folio.'], 404);
        }

        return response()->json([
            'found' => true,
            'pedimento' => $pedimento->toAutofillPayload(),
        ]);
    }

    private function validatePedimento(Request $request): array
    {
        return $request->validate([
            'tipo' => ['required', 'in:tradicional,simplificado'],
            'tipo_operacion' => ['required', 'in:importacion,exportacion'],
            'destino_clave' => ['nullable', 'string', 'max:10'],
            'tipo_cambio' => ['nullable', 'numeric'],
            'peso_bruto' => ['nullable', 'numeric'],
            'aduana_clave' => ['nullable', 'string', 'max:10'],
            'seccion_aduanera' => ['nullable', 'string', 'max:20'],
            'clave_pedimento' => ['nullable', 'string', 'max:10'],
            'regimen_clave' => ['nullable', 'string', 'max:10'],
            'patente' => ['nullable', 'string', 'max:20'],
            'rfc_operador' => ['nullable', 'string', 'max:20'],
            'nombre_operador' => ['nullable', 'string', 'max:255'],
            'curp_operador' => ['nullable', 'string', 'max:20'],
            'domicilio_operador' => ['nullable', 'string', 'max:500'],
            'medio_transporte_clave' => ['nullable', 'string', 'max:10'],
            'medio_entrada_clave' => ['nullable', 'string', 'max:10'],
            'medio_arribo_clave' => ['nullable', 'string', 'max:10'],
            'medio_salida_clave' => ['nullable', 'string', 'max:10'],
            'pais_origen_clave' => ['nullable', 'string', 'max:10'],
            'pais_destino_clave' => ['nullable', 'string', 'max:10'],
            'moneda_clave' => ['nullable', 'string', 'max:10'],
            'incoterm_clave' => ['nullable', 'string', 'max:10'],
            'valor_comercial' => ['nullable', 'numeric'],
            'valor_aduana' => ['nullable', 'numeric'],
            'valor_dolares' => ['nullable', 'numeric'],
            'precio_pagado' => ['nullable', 'numeric'],
            'val_seguros' => ['nullable', 'numeric'],
            'seguros' => ['nullable', 'numeric'],
            'fletes' => ['nullable', 'numeric'],
            'embalajes' => ['nullable', 'numeric'],
            'otros_incrementables' => ['nullable', 'numeric'],
            'codigo_aceptacion' => ['nullable', 'string', 'max:40'],
            'codigo_barras_pedimento' => ['nullable', 'string', 'max:80'],
            'marcas_bultos' => ['nullable', 'string', 'max:255'],
            'total_bultos' => ['nullable', 'integer'],
            'proveedor_id_fiscal' => ['nullable', 'string', 'max:30'],
            'proveedor_nombre' => ['nullable', 'string', 'max:255'],
            'proveedor_domicilio' => ['nullable', 'string', 'max:500'],
            'vinculacion' => ['nullable', 'string', 'max:5'],
            'cfdi_numero' => ['nullable', 'string', 'max:50'],
            'cfdi_fecha' => ['nullable', 'date'],
            'cfdi_valor_moneda' => ['nullable', 'numeric'],
            'cfdi_factor_moneda' => ['nullable', 'numeric'],
            'cfdi_valor_dolares' => ['nullable', 'numeric'],
            'agente_nombre' => ['nullable', 'string', 'max:255'],
            'agente_rfc' => ['nullable', 'string', 'max:20'],
            'agente_curp' => ['nullable', 'string', 'max:20'],
            'agente_patente' => ['nullable', 'string', 'max:20'],
            'equipo_id' => ['nullable', 'exists:equipos,id'],
            'observaciones' => ['nullable', 'string', 'max:5000'],
        ]);
    }

    private function normalizePartidas(array $raw): array
    {
        $partidas = [];

        foreach ($raw as $row) {
            if (! is_array($row)) {
                continue;
            }

            $descripcion = trim((string) ($row['descripcion'] ?? ''));
            $fraccion = trim((string) ($row['fraccion'] ?? ''));

            if ($descripcion === '' && $fraccion === '') {
                continue;
            }

            $partidas[] = [
                'fraccion' => $fraccion ?: null,
                'nico' => trim((string) ($row['nico'] ?? '')) ?: null,
                'descripcion' => $descripcion ?: null,
                'cantidad' => (float) ($row['cantidad'] ?? 0),
                'unidad' => trim((string) ($row['unidad'] ?? '')) ?: null,
                'umc' => trim((string) ($row['umc'] ?? '')) ?: null,
                'cantidad_umc' => isset($row['cantidad_umc']) && $row['cantidad_umc'] !== '' ? (float) $row['cantidad_umc'] : null,
                'umt' => trim((string) ($row['umt'] ?? '')) ?: null,
                'cantidad_umt' => isset($row['cantidad_umt']) && $row['cantidad_umt'] !== '' ? (float) $row['cantidad_umt'] : null,
                'metodo_valoracion' => trim((string) ($row['metodo_valoracion'] ?? '')) ?: null,
                'vinculacion' => trim((string) ($row['vinculacion'] ?? '')) ?: null,
                'valor_comercial' => (float) ($row['valor_comercial'] ?? 0),
                'valor_aduana' => (float) ($row['valor_aduana'] ?? 0),
                'precio_unitario' => isset($row['precio_unitario']) && $row['precio_unitario'] !== '' ? (float) $row['precio_unitario'] : null,
                'val_adu_usd' => isset($row['val_adu_usd']) && $row['val_adu_usd'] !== '' ? (float) $row['val_adu_usd'] : null,
                'pais_origen_clave' => trim((string) ($row['pais_origen_clave'] ?? '')) ?: null,
                'pais_vendedor_clave' => trim((string) ($row['pais_vendedor_clave'] ?? '')) ?: null,
                'marca' => trim((string) ($row['marca'] ?? '')) ?: null,
                'modelo' => trim((string) ($row['modelo'] ?? '')) ?: null,
                'codigo_producto' => trim((string) ($row['codigo_producto'] ?? '')) ?: null,
                'observaciones_partida' => trim((string) ($row['observaciones_partida'] ?? '')) ?: null,
            ];
        }

        return $partidas;
    }

    private function catalogos(): array
    {
        $tables = [
            'aduanas' => ['cat_aduanas', 'clave', 'denominacion'],
            'claves_pedimento' => ['cat_claves_pedimento', 'clave', 'descripcion'],
            'regimenes' => ['cat_regimenes', 'clave', 'descripcion'],
            'medios' => ['cat_medios_transporte', 'clave', 'descripcion'],
            'paises' => ['cat_paises', 'clave_saai_m3', 'nombre'],
            'monedas' => ['cat_monedas', 'clave', 'nombre'],
            'incoterms' => ['cat_incoterms', 'clave', 'descripcion'],
            'destinos' => ['cat_destinos', 'clave', 'descripcion'],
        ];

        $out = [];

        foreach ($tables as $key => [$table, $code, $label]) {
            if (! DB::getSchemaBuilder()->hasTable($table)) {
                $out[$key] = collect();
                continue;
            }

            $out[$key] = DB::table($table)
                ->where('activo', true)
                ->orderBy($label)
                ->get([$code . ' as clave', $label . ' as nombre']);
        }

        return $out;
    }

    private function authorizeVisible(Pedimento $pedimento): void
    {
        $visible = Pedimento::visiblesPara(Auth::user())->whereKey($pedimento->id)->exists();
        abort_unless($visible, 403, 'No tienes acceso a este pedimento.');
    }
}
