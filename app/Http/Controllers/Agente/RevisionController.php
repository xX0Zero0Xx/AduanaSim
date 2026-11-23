<?php

namespace App\Http\Controllers\Agente;

use App\Http\Controllers\Controller;
use App\Models\Cove;
use App\Models\Doda;
use App\Models\Pedimento;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class RevisionController extends Controller
{
    /** Lista unificada por estatus: enviado | validado | devuelto */
    public function index(Request $request, string $bandeja = 'pendientes'): View
    {
        $map = [
            'pendientes' => 'enviado',
            'validados' => 'validado',
            'devueltos' => 'devuelto',
            'historial' => null,
        ];

        abort_unless(array_key_exists($bandeja, $map), 404);

        $estatus = $map[$bandeja];
        $tipo = $request->get('tipo', 'todos');
        $items = $this->collectDocuments($estatus, $tipo, $bandeja === 'historial' ? 100 : 80);

        $titulos = [
            'pendientes' => 'Por revisar',
            'validados' => 'Documentos validados',
            'devueltos' => 'Documentos no validados',
            'historial' => 'Historial de revisiones',
        ];

        return view('agente.revisiones.index', [
            'bandeja' => $bandeja,
            'titulo' => $titulos[$bandeja],
            'items' => $items,
            'tipo' => $tipo,
            'estatusFiltro' => $estatus,
        ]);
    }

    public function show(string $tipo, int $id): View
    {
        $doc = $this->resolve($tipo, $id);
        $doc->loadMissing(['user']);

        if ($tipo === 'pedimento') {
            $doc->load('partidas');
        } elseif ($tipo === 'cove') {
            $doc->load(['facturas', 'mercancias', 'pedimento']);
        } elseif ($tipo === 'doda') {
            $doc->load('pedimentos');
        }

        return view('agente.revisiones.show', [
            'tipo' => $tipo,
            'doc' => $doc,
        ]);
    }

    public function validar(Request $request, string $tipo, int $id): RedirectResponse
    {
        $doc = $this->resolve($tipo, $id);
        abort_unless($doc->estatus === 'enviado', 422, 'Solo se pueden validar documentos en estatus enviado.');

        $doc->update([
            'estatus' => 'validado',
            'validado_at' => now(),
            'revisado_por' => Auth::id(),
            'observaciones_revision' => $request->input('observaciones_revision'),
        ]);

        return redirect()
            ->route('agente.revisiones.index', 'validados')
            ->with('status', ucfirst($tipo)." {$doc->folio} validado correctamente.");
    }

    public function devolver(Request $request, string $tipo, int $id): RedirectResponse
    {
        $data = $request->validate([
            'observaciones_revision' => ['required', 'string', 'min:5', 'max:2000'],
        ], [
            'observaciones_revision.required' => 'Debes indicar observaciones para devolver el documento.',
        ]);

        $doc = $this->resolve($tipo, $id);
        abort_unless(in_array($doc->estatus, ['enviado', 'validado'], true), 422, 'No se puede devolver este documento.');

        $doc->update([
            'estatus' => 'devuelto',
            'validado_at' => null,
            'revisado_por' => Auth::id(),
            'observaciones_revision' => $data['observaciones_revision'],
        ]);

        return redirect()
            ->route('agente.revisiones.index', 'devueltos')
            ->with('status', ucfirst($tipo)." {$doc->folio} devuelto con observaciones.");
    }

    private function collectDocuments(?string $estatus, string $tipo, int $limit)
    {
        $items = collect();

        $push = function ($docs, string $label, string $key) use ($items) {
            foreach ($docs as $doc) {
                $items->push([
                    'tipo' => $label,
                    'tipo_key' => $key,
                    'id' => $doc->id,
                    'folio' => $doc->folio,
                    'estatus' => $doc->estatus,
                    'etiqueta' => $doc->etiquetaEstatus(),
                    'fecha' => $doc->updated_at,
                    'enviado_at' => $doc->enviado_at,
                    'validado_at' => $doc->validado_at ?? null,
                    'capturista' => $doc->user->name ?? '—',
                    'extra' => match ($key) {
                        'pedimento' => $doc->nombre_operador,
                        'cove' => $doc->emisor_nombre,
                        'doda' => $doc->placa_o_identificacion,
                        default => null,
                    },
                    'url' => route('agente.revisiones.show', [$key, $doc->id]),
                ]);
            }
        };

        $queryLimit = (int) ceil($limit / 3) + 5;

        if ($tipo === 'todos' || $tipo === 'pedimento') {
            $q = Pedimento::with('user')->latest();
            if ($estatus) {
                $q->where('estatus', $estatus);
            } else {
                $q->whereIn('estatus', ['enviado', 'validado', 'devuelto']);
            }
            $push($q->limit($queryLimit)->get(), 'Pedimento', 'pedimento');
        }

        if ($tipo === 'todos' || $tipo === 'cove') {
            $q = Cove::with('user')->latest();
            if ($estatus) {
                $q->where('estatus', $estatus);
            } else {
                $q->whereIn('estatus', ['enviado', 'validado', 'devuelto']);
            }
            $push($q->limit($queryLimit)->get(), 'COVE', 'cove');
        }

        if ($tipo === 'todos' || $tipo === 'doda') {
            $q = Doda::with('user')->latest();
            if ($estatus) {
                $q->where('estatus', $estatus);
            } else {
                $q->whereIn('estatus', ['enviado', 'validado', 'devuelto']);
            }
            $push($q->limit($queryLimit)->get(), 'DODA', 'doda');
        }

        return $items->sortByDesc(fn ($i) => $i['fecha'])->values()->take($limit);
    }

    private function resolve(string $tipo, int $id)
    {
        return match ($tipo) {
            'pedimento' => Pedimento::findOrFail($id),
            'cove' => Cove::findOrFail($id),
            'doda' => Doda::findOrFail($id),
            default => abort(404),
        };
    }
}
