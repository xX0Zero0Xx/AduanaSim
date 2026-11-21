<?php

namespace App\Http\Controllers\Capturista;

use App\Http\Controllers\Controller;
use App\Models\Cove;
use App\Models\Doda;
use App\Models\Pedimento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class HistorialController extends Controller
{
    public function index(Request $request): View
    {
        $user = Auth::user();
        $tipo = $request->get('tipo', 'todos');
        $estatus = $request->get('estatus');

        $items = collect();

        if ($tipo === 'todos' || $tipo === 'pedimento') {
            Pedimento::visiblesPara($user)
                ->when($estatus, fn ($q) => $q->where('estatus', $estatus))
                ->latest()
                ->limit(50)
                ->get()
                ->each(function ($doc) use ($items) {
                    $items->push([
                        'tipo' => 'Pedimento',
                        'folio' => $doc->folio,
                        'estatus' => $doc->estatus,
                        'etiqueta' => $doc->etiquetaEstatus(),
                        'fecha' => $doc->updated_at,
                        'url' => route('capturista.pedimentos.show', $doc),
                        'extra' => $doc->nombre_operador,
                    ]);
                });
        }

        if ($tipo === 'todos' || $tipo === 'cove') {
            Cove::visiblesPara($user)
                ->when($estatus, fn ($q) => $q->where('estatus', $estatus))
                ->latest()
                ->limit(50)
                ->get()
                ->each(function ($doc) use ($items) {
                    $items->push([
                        'tipo' => 'COVE',
                        'folio' => $doc->folio,
                        'estatus' => $doc->estatus,
                        'etiqueta' => $doc->etiquetaEstatus(),
                        'fecha' => $doc->updated_at,
                        'url' => route('capturista.coves.show', $doc),
                        'extra' => $doc->emisor_nombre,
                    ]);
                });
        }

        if ($tipo === 'todos' || $tipo === 'doda') {
            Doda::visiblesPara($user)
                ->when($estatus, fn ($q) => $q->where('estatus', $estatus))
                ->latest()
                ->limit(50)
                ->get()
                ->each(function ($doc) use ($items) {
                    $items->push([
                        'tipo' => 'DODA',
                        'folio' => $doc->folio,
                        'estatus' => $doc->estatus,
                        'etiqueta' => $doc->etiquetaEstatus(),
                        'fecha' => $doc->updated_at,
                        'url' => route('capturista.dodas.show', $doc),
                        'extra' => $doc->numero_operacion,
                    ]);
                });
        }

        $items = $items->sortByDesc('fecha')->values();

        return view('capturista.historial.index', [
            'items' => $items,
            'tipo' => $tipo,
            'estatus' => $estatus,
        ]);
    }
}
