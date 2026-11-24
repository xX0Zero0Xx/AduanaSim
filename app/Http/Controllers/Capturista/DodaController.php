<?php

namespace App\Http\Controllers\Capturista;

use App\Http\Controllers\Controller;
use App\Models\Doda;
use App\Models\Pedimento;
use Illuminate\Http\RedirectResponse;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class DodaController extends Controller
{
    public function index(Request $request): View
    {
        $user = Auth::user();

        $dodas = Doda::visiblesPara($user)
            ->with(['user:id,name', 'pedimentos:id,folio'])
            ->when($request->estatus, fn ($q, $e) => $q->where('estatus', $e))
            ->when($request->q, fn ($q, $term) => $q->where('folio', 'like', "%{$term}%"))
            ->latest()
            ->paginate(12)
            ->withQueryString();

        return view('capturista.dodas.index', compact('dodas'));
    }

    public function create(): View
    {
        $user = Auth::user();

        return view('capturista.dodas.create', [
            'catalogos' => $this->catalogos(),
            'equipos' => $user->equipos()->where('activo', true)->get(),
            'pedimentos' => Pedimento::visiblesPara($user)
                ->whereIn('estatus', ['borrador', 'enviado', 'validado'])
                ->orderByDesc('id')
                ->limit(80)
                ->get(['id', 'folio', 'nombre_operador', 'estatus']),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validateDoda($request);
        $pedimentoIds = $request->input('pedimento_ids', []);

        $doda = DB::transaction(function () use ($data, $pedimentoIds) {
            $doda = Doda::create([
                ...$data,
                'user_id' => Auth::id(),
                'folio' => Doda::generarFolio(),
                'estatus' => 'borrador',
            ]);

            $doda->pedimentos()->sync(array_filter($pedimentoIds));
            $doda->regenerarCadenas();

            return $doda;
        });

        return redirect()
            ->route('capturista.dodas.show', $doda)
            ->with('status', "DODA {$doda->folio} creado como borrador.");
    }

    public function show(Doda $doda): View
    {
        $this->authorizeVisible($doda);
        $doda->load(['pedimentos', 'user:id,name', 'revisor:id,name']);

        return view('capturista.dodas.show', compact('doda'));
    }

    public function edit(Doda $doda): View|RedirectResponse
    {
        $this->authorizeVisible($doda);

        if (! $doda->puedeEditarse()) {
            return redirect()->route('capturista.dodas.show', $doda)
                ->with('error', 'Solo se pueden editar DODA en borrador o devueltos.');
        }

        $user = Auth::user();
        $doda->load('pedimentos');

        return view('capturista.dodas.edit', [
            'doda' => $doda,
            'catalogos' => $this->catalogos(),
            'equipos' => $user->equipos()->where('activo', true)->get(),
            'pedimentos' => Pedimento::visiblesPara($user)->orderByDesc('id')->limit(80)->get(['id', 'folio', 'nombre_operador', 'estatus']),
        ]);
    }

    public function update(Request $request, Doda $doda): RedirectResponse
    {
        $this->authorizeVisible($doda);

        if (! $doda->puedeEditarse()) {
            return back()->with('error', 'Este DODA ya no puede editarse.');
        }

        $data = $this->validateDoda($request);
        $pedimentoIds = $request->input('pedimento_ids', []);

        DB::transaction(function () use ($doda, $data, $pedimentoIds) {
            $doda->update([
                ...$data,
                'observaciones_revision' => null,
            ]);
            $doda->pedimentos()->sync(array_filter($pedimentoIds));
            $doda->regenerarCadenas();
        });

        return redirect()
            ->route('capturista.dodas.show', $doda)
            ->with('status', 'DODA actualizado.');
    }

    public function destroy(Doda $doda): RedirectResponse
    {
        $this->authorizeVisible($doda);

        if ($doda->estatus !== 'borrador') {
            return back()->with('error', 'Solo se pueden eliminar borradores.');
        }

        $folio = $doda->folio;
        $doda->pedimentos()->detach();
        $doda->delete();

        return redirect()
            ->route('capturista.dodas.index')
            ->with('status', "DODA {$folio} eliminado.");
    }

    public function enviar(Doda $doda): RedirectResponse
    {
        $this->authorizeVisible($doda);

        if (! $doda->puedeEnviarse()) {
            return back()->with('error', 'Este DODA no puede enviarse a validación.');
        }

        if ($doda->pedimentos()->count() === 0) {
            return back()->with('error', 'Asocia al menos un pedimento antes de enviar.');
        }

        $doda->update([
            'estatus' => 'enviado',
            'enviado_at' => now(),
            'observaciones_revision' => null,
        ]);

        return back()->with('status', "DODA {$doda->folio} enviado a validación.");
    }


    public function pdf(Doda $doda): Response
    {
        $this->authorizeVisible($doda);
        $doda->load(['pedimentos', 'user']);

        $pdf = Pdf::loadView('pdf.doda', ['doda' => $doda])
            ->setPaper('letter', 'portrait');

        return $pdf->stream("doda-{$doda->folio}.pdf");
    }

    private function validateDoda(Request $request): array
    {
        return $request->validate([
            'equipo_id' => ['nullable', 'exists:equipos,id'],
            'aduana_clave' => ['nullable', 'string', 'max:10'],
            'patente' => ['nullable', 'string', 'max:20'],
            'numero_operacion' => ['nullable', 'string', 'max:40'],
            'fecha_operacion' => ['nullable', 'date'],
            'medio_transporte_clave' => ['nullable', 'string', 'max:10'],
            'placa_o_identificacion' => ['nullable', 'string', 'max:80'],
            'observaciones' => ['nullable', 'string', 'max:2000'],
            'pedimento_ids' => ['nullable', 'array'],
            'pedimento_ids.*' => ['integer', 'exists:pedimentos,id'],
        ]);
    }

    private function catalogos(): array
    {
        $out = [
            'aduanas' => collect(),
            'medios' => collect(),
        ];

        if (DB::getSchemaBuilder()->hasTable('cat_aduanas')) {
            $out['aduanas'] = DB::table('cat_aduanas')->where('activo', true)->orderBy('denominacion')->get(['clave', 'denominacion as nombre']);
        }

        if (DB::getSchemaBuilder()->hasTable('cat_medios_transporte')) {
            $out['medios'] = DB::table('cat_medios_transporte')->where('activo', true)->orderBy('descripcion')->get(['clave', 'descripcion as nombre']);
        }

        return $out;
    }

    private function authorizeVisible(Doda $doda): void
    {
        $visible = Doda::visiblesPara(Auth::user())->whereKey($doda->id)->exists();
        abort_unless($visible, 403);
    }
}
