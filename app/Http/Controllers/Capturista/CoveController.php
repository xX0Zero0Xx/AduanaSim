<?php

namespace App\Http\Controllers\Capturista;

use App\Http\Controllers\Controller;
use App\Models\Cove;
use App\Models\Pedimento;
use Illuminate\Http\RedirectResponse;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class CoveController extends Controller
{
    public function index(Request $request): View
    {
        $user = Auth::user();

        $coves = Cove::visiblesPara($user)
            ->with(['user:id,name', 'pedimento:id,folio'])
            ->when($request->estatus, fn ($q, $e) => $q->where('estatus', $e))
            ->when($request->q, function ($q, $term) {
                $q->where(function ($inner) use ($term) {
                    $inner->where('folio', 'like', "%{$term}%")
                        ->orWhere('emisor_nombre', 'like', "%{$term}%")
                        ->orWhere('destinatario_nombre', 'like', "%{$term}%");
                });
            })
            ->latest()
            ->paginate(12)
            ->withQueryString();

        return view('capturista.coves.index', compact('coves'));
    }

    public function create(Request $request): View
    {
        $user = Auth::user();

        return view('capturista.coves.create', [
            'catalogos' => $this->catalogos(),
            'equipos' => $user->equipos()->where('activo', true)->get(),
            'pedimentos' => Pedimento::visiblesPara($user)->whereIn('estatus', ['borrador', 'enviado', 'validado'])->orderByDesc('id')->limit(50)->get(['id', 'folio', 'nombre_operador']),
            'pedimento_id' => $request->integer('pedimento_id') ?: null,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validateCove($request);
        $facturas = $this->normalizeFacturas($request->input('facturas', []));
        $mercancias = $this->normalizeMercancias($request->input('mercancias', []));

        $cove = DB::transaction(function () use ($data, $facturas, $mercancias) {
            $valor = collect($facturas)->sum('valor');
            if ($valor <= 0) {
                $valor = collect($mercancias)->sum('valor');
            }

            $cove = Cove::create([
                ...$data,
                'user_id' => Auth::id(),
                'folio' => Cove::generarFolio(),
                'estatus' => 'borrador',
                'valor_total' => $valor,
            ]);

            foreach ($facturas as $factura) {
                $cove->facturas()->create($factura);
            }

            foreach ($mercancias as $i => $mercancia) {
                $cove->mercancias()->create([
                    ...$mercancia,
                    'secuencia' => $i + 1,
                ]);
            }

            return $cove;
        });

        return redirect()
            ->route('capturista.coves.show', $cove)
            ->with('status', "COVE {$cove->folio} creado como borrador.");
    }

    public function show(Cove $cove): View
    {
        $this->authorizeVisible($cove);
        $cove->load(['facturas', 'mercancias', 'pedimento:id,folio', 'user:id,name', 'revisor:id,name']);

        return view('capturista.coves.show', compact('cove'));
    }

    public function edit(Cove $cove): View|RedirectResponse
    {
        $this->authorizeVisible($cove);

        if (! $cove->puedeEditarse()) {
            return redirect()->route('capturista.coves.show', $cove)
                ->with('error', 'Solo se pueden editar COVE en borrador o devueltos.');
        }

        $user = Auth::user();
        $cove->load(['facturas', 'mercancias']);

        return view('capturista.coves.edit', [
            'cove' => $cove,
            'catalogos' => $this->catalogos(),
            'equipos' => $user->equipos()->where('activo', true)->get(),
            'pedimentos' => Pedimento::visiblesPara($user)->orderByDesc('id')->limit(50)->get(['id', 'folio', 'nombre_operador']),
        ]);
    }

    public function update(Request $request, Cove $cove): RedirectResponse
    {
        $this->authorizeVisible($cove);

        if (! $cove->puedeEditarse()) {
            return back()->with('error', 'Este COVE ya no puede editarse.');
        }

        $data = $this->validateCove($request);
        $facturas = $this->normalizeFacturas($request->input('facturas', []));
        $mercancias = $this->normalizeMercancias($request->input('mercancias', []));

        DB::transaction(function () use ($cove, $data, $facturas, $mercancias) {
            $valor = collect($facturas)->sum('valor');
            if ($valor <= 0) {
                $valor = collect($mercancias)->sum('valor');
            }

            $cove->update([
                ...$data,
                'valor_total' => $valor,
                'observaciones_revision' => null,
            ]);

            $cove->facturas()->delete();
            $cove->mercancias()->delete();

            foreach ($facturas as $factura) {
                $cove->facturas()->create($factura);
            }

            foreach ($mercancias as $i => $mercancia) {
                $cove->mercancias()->create([
                    ...$mercancia,
                    'secuencia' => $i + 1,
                ]);
            }
        });

        return redirect()
            ->route('capturista.coves.show', $cove)
            ->with('status', 'COVE actualizado.');
    }

    public function destroy(Cove $cove): RedirectResponse
    {
        $this->authorizeVisible($cove);

        if ($cove->estatus !== 'borrador') {
            return back()->with('error', 'Solo se pueden eliminar borradores.');
        }

        $folio = $cove->folio;
        $cove->delete();

        return redirect()
            ->route('capturista.coves.index')
            ->with('status', "COVE {$folio} eliminado.");
    }

    public function enviar(Cove $cove): RedirectResponse
    {
        $this->authorizeVisible($cove);

        if (! $cove->puedeEnviarse()) {
            return back()->with('error', 'Este COVE no puede enviarse a validación.');
        }

        $cove->update([
            'estatus' => 'enviado',
            'enviado_at' => now(),
            'observaciones_revision' => null,
        ]);

        return back()->with('status', "COVE {$cove->folio} enviado a validación.");
    }


    public function pdf(Cove $cove): Response
    {
        $this->authorizeVisible($cove);
        $cove->load(['facturas', 'mercancias', 'pedimento', 'user']);

        $pdf = Pdf::loadView('pdf.cove', ['cove' => $cove])
            ->setPaper('letter', 'portrait');

        return $pdf->stream("cove-{$cove->folio}.pdf");
    }

    private function validateCove(Request $request): array
    {
        return $request->validate([
            'pedimento_id' => ['nullable', 'exists:pedimentos,id'],
            'equipo_id' => ['nullable', 'exists:equipos,id'],
            'emisor_rfc' => ['nullable', 'string', 'max:20'],
            'emisor_nombre' => ['nullable', 'string', 'max:255'],
            'destinatario_rfc' => ['nullable', 'string', 'max:20'],
            'destinatario_nombre' => ['nullable', 'string', 'max:255'],
            'moneda_clave' => ['nullable', 'string', 'max:10'],
            'observaciones' => ['nullable', 'string', 'max:2000'],
        ]);
    }

    private function normalizeFacturas(array $raw): array
    {
        $out = [];

        foreach ($raw as $row) {
            if (! is_array($row)) {
                continue;
            }

            $numero = trim((string) ($row['numero_factura'] ?? ''));
            if ($numero === '' && empty($row['valor'])) {
                continue;
            }

            $out[] = [
                'numero_factura' => $numero ?: null,
                'fecha_factura' => $row['fecha_factura'] ?: null,
                'valor' => (float) ($row['valor'] ?? 0),
                'moneda_clave' => trim((string) ($row['moneda_clave'] ?? '')) ?: null,
            ];
        }

        return $out;
    }

    private function normalizeMercancias(array $raw): array
    {
        $out = [];

        foreach ($raw as $row) {
            if (! is_array($row)) {
                continue;
            }

            $descripcion = trim((string) ($row['descripcion'] ?? ''));
            if ($descripcion === '') {
                continue;
            }

            $out[] = [
                'descripcion' => $descripcion,
                'cantidad' => (float) ($row['cantidad'] ?? 0),
                'unidad' => trim((string) ($row['unidad'] ?? '')) ?: null,
                'valor' => (float) ($row['valor'] ?? 0),
                'fraccion' => trim((string) ($row['fraccion'] ?? '')) ?: null,
            ];
        }

        return $out;
    }

    private function catalogos(): array
    {
        $out = ['monedas' => collect()];

        if (DB::getSchemaBuilder()->hasTable('cat_monedas')) {
            $out['monedas'] = DB::table('cat_monedas')
                ->where('activo', true)
                ->orderBy('nombre')
                ->get(['clave', 'nombre']);
        }

        return $out;
    }

    private function authorizeVisible(Cove $cove): void
    {
        $visible = Cove::visiblesPara(Auth::user())->whereKey($cove->id)->exists();
        abort_unless($visible, 403);
    }
}
