<?php

use App\Http\Controllers\Capturista\CoveController;
use App\Http\Controllers\Capturista\DodaController;
use App\Http\Controllers\Capturista\EquipoController;
use App\Http\Controllers\Capturista\HistorialController;
use App\Http\Controllers\Capturista\PedimentoController;
use App\Http\Controllers\Agente\RevisionController;
use App\Http\Controllers\Agente\EquipoGestionController;
use App\Http\Controllers\Agente\UsuarioController;
use App\Http\Controllers\Agente\DepartamentoController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Models\Cove;
use App\Models\Doda;
use App\Models\Pedimento;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Schema;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::middleware(['auth', 'verified'])->group(function () {

    Route::get('/dashboard', function (Request $request) {
        $user = $request->user();

        $stats = null;
        $historialItems = collect();
        $equipos = collect();
        $statsPorEquipo = [];

        if ($user->isCapturista()) {
            $stats = [
                'borradores' => Pedimento::visiblesPara($user)->where('estatus', 'borrador')->count()
                    + Cove::visiblesPara($user)->where('estatus', 'borrador')->count()
                    + Doda::visiblesPara($user)->where('estatus', 'borrador')->count(),
                'enviados' => Pedimento::visiblesPara($user)->where('estatus', 'enviado')->count()
                    + Cove::visiblesPara($user)->where('estatus', 'enviado')->count()
                    + Doda::visiblesPara($user)->where('estatus', 'enviado')->count(),
                'validados' => Pedimento::visiblesPara($user)->where('estatus', 'validado')->count()
                    + Cove::visiblesPara($user)->where('estatus', 'validado')->count()
                    + Doda::visiblesPara($user)->where('estatus', 'validado')->count(),
            ];

            // Historial unificado (misma pestaña del panel)
            Pedimento::visiblesPara($user)->latest()->limit(40)->get()->each(function ($doc) use ($historialItems) {
                $historialItems->push([
                    'tipo' => 'Pedimento',
                    'folio' => $doc->folio,
                    'estatus' => $doc->estatus,
                    'etiqueta' => $doc->etiquetaEstatus(),
                    'fecha' => $doc->updated_at,
                    'url' => route('capturista.pedimentos.show', $doc),
                    'extra' => $doc->nombre_operador,
                ]);
            });
            Cove::visiblesPara($user)->latest()->limit(40)->get()->each(function ($doc) use ($historialItems) {
                $historialItems->push([
                    'tipo' => 'COVE',
                    'folio' => $doc->folio,
                    'estatus' => $doc->estatus,
                    'etiqueta' => $doc->etiquetaEstatus(),
                    'fecha' => $doc->updated_at,
                    'url' => route('capturista.coves.show', $doc),
                    'extra' => $doc->emisor_nombre,
                ]);
            });
            Doda::visiblesPara($user)->latest()->limit(40)->get()->each(function ($doc) use ($historialItems) {
                $historialItems->push([
                    'tipo' => 'DODA',
                    'folio' => $doc->folio,
                    'estatus' => $doc->estatus,
                    'etiqueta' => $doc->etiquetaEstatus(),
                    'fecha' => $doc->updated_at,
                    'url' => route('capturista.dodas.show', $doc),
                    'extra' => $doc->transporte_identificacion ?? null,
                ]);
            });
            $historialItems = $historialItems->sortByDesc(fn($i) => $i['fecha'])->values();

            // Equipos del capturista (misma pestaña del panel)
            if (method_exists($user, 'equipos')) {
                $equipos = $user->equipos()
                    ->where('equipos.activo', true)
                    ->with(['users' => function ($q) {
                        $q->select('users.id', 'users.name', 'users.email', 'users.rol', 'users.activo')
                            ->orderBy('users.name');
                    }])
                    ->get();

                foreach ($equipos as $equipo) {
                    $statsPorEquipo[$equipo->id] = [
                        'pedimentos' => Pedimento::where('equipo_id', $equipo->id)->count(),
                        'coves' => Cove::where('equipo_id', $equipo->id)->count(),
                        'dodas' => Doda::where('equipo_id', $equipo->id)->count(),
                    ];
                }
            }
        }


        $agentHistorial = collect();
        $agentDepartamentos = collect();
        if ($user->isAgente() || $user->isAdmin()) {
            $agentStats = [
                'pendientes' => Pedimento::where('estatus', 'enviado')->count()
                    + Cove::where('estatus', 'enviado')->count()
                    + Doda::where('estatus', 'enviado')->count(),
                'validados' => Pedimento::where('estatus', 'validado')->count()
                    + Cove::where('estatus', 'validado')->count()
                    + Doda::where('estatus', 'validado')->count(),
                'devueltos' => Pedimento::where('estatus', 'devuelto')->count()
                    + Cove::where('estatus', 'devuelto')->count()
                    + Doda::where('estatus', 'devuelto')->count(),
            ];

            // Historial rápido (solo validado / devuelto) para la pestaña del panel
            $pushHist = function ($docs, string $label, string $key) use ($agentHistorial) {
                foreach ($docs as $doc) {
                    $dept = $doc->user?->departamento;
                    $agentHistorial->push([
                        'tipo' => $label,
                        'folio' => $doc->folio,
                        'estatus' => $doc->estatus,
                        'etiqueta' => $doc->etiquetaEstatus(),
                        'capturista' => $doc->user->name ?? '—',
                        'departamento' => $dept->clave ?? '—',
                        'url' => route('agente.revisiones.show', [$key, $doc->id]),
                        'fecha' => $doc->updated_at,
                    ]);
                }
            };
            $userWith = method_exists(User::class, 'departamento') && \Schema::hasColumn('users', 'departamento_id')
                ? ['user.departamento']
                : ['user'];
            $pushHist(Pedimento::with($userWith)->whereIn('estatus', ['validado', 'devuelto'])->latest()->limit(30)->get(), 'Pedimento', 'pedimento');
            $pushHist(Cove::with($userWith)->whereIn('estatus', ['validado', 'devuelto'])->latest()->limit(30)->get(), 'COVE', 'cove');
            $pushHist(Doda::with($userWith)->whereIn('estatus', ['validado', 'devuelto'])->latest()->limit(30)->get(), 'DODA', 'doda');
            $agentHistorial = $agentHistorial->sortByDesc(fn($i) => $i['fecha'])->values()->take(40);
            $agentDepartamentos = \App\Models\Departamento::where('activo', true)->orderBy('clave')->get();
        } else {
            $agentStats = null;
        }

        return view('dashboard', [
            'user' => $user,
            'registeredUserCount' => $user->isAdmin() ? User::query()->count() : null,
            'stats' => $stats,
            'historialItems' => $historialItems,
            'equipos' => $equipos,
            'statsPorEquipo' => $statsPorEquipo,
            'agentStats' => $agentStats ?? null,
            'agentHistorial' => $agentHistorial ?? collect(),
            'agentDepartamentos' => $agentDepartamentos ?? collect(),
        ]);
    })->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Admin
    Route::middleware('role:admin')->prefix('admin')->name('admin.')->group(function () {
        Route::post('/usuarios', [UserController::class, 'store'])->name('usuarios.store');
        Route::put('/usuarios/{usuario}', [UserController::class, 'update'])->name('usuarios.update');
        Route::patch('/usuarios/{usuario}/suspend', [UserController::class, 'suspend'])->name('usuarios.suspend');
        Route::patch('/usuarios/{usuario}/activate', [UserController::class, 'activate'])->name('usuarios.activate');
        Route::delete('/usuarios/{usuario}', [UserController::class, 'destroy'])->name('usuarios.destroy');
    });


    // Agente — revisión y equipos
    Route::middleware('role:agente,admin')->prefix('agente')->name('agente.')->group(function () {
        Route::get('/revisiones/{bandeja}', [RevisionController::class, 'index'])
            ->whereIn('bandeja', ['pendientes', 'validados', 'devueltos', 'historial'])
            ->name('revisiones.index');
        Route::get('/revisiones', fn() => redirect()->route('agente.revisiones.index', 'pendientes'));
        Route::get('/documento/{tipo}/{id}', [RevisionController::class, 'show'])
            ->whereIn('tipo', ['pedimento', 'cove', 'doda'])
            ->name('revisiones.show');
        Route::post('/documento/{tipo}/{id}/validar', [RevisionController::class, 'validar'])
            ->whereIn('tipo', ['pedimento', 'cove', 'doda'])
            ->name('revisiones.validar');
        Route::post('/documento/{tipo}/{id}/devolver', [RevisionController::class, 'devolver'])
            ->whereIn('tipo', ['pedimento', 'cove', 'doda'])
            ->name('revisiones.devolver');

        Route::get('/equipos', [EquipoGestionController::class, 'index'])->name('equipos.index');
        Route::post('/equipos', [EquipoGestionController::class, 'store'])->name('equipos.store');
        Route::get('/equipos/{equipo}', [EquipoGestionController::class, 'show'])->name('equipos.show');
        Route::put('/equipos/{equipo}', [EquipoGestionController::class, 'update'])->name('equipos.update');
        Route::delete('/equipos/{equipo}', [EquipoGestionController::class, 'destroy'])->name('equipos.destroy');
        Route::post('/equipos/{equipo}/miembros', [EquipoGestionController::class, 'attachMember'])->name('equipos.attach');
        Route::delete('/equipos/{equipo}/miembros/{user}', [EquipoGestionController::class, 'detachMember'])->name('equipos.detach');

        // Usuarios capturista + departamentos
        Route::get('/usuarios', [UsuarioController::class, 'index'])->name('usuarios.index');
        Route::post('/usuarios', [UsuarioController::class, 'store'])->name('usuarios.store');
        Route::put('/usuarios/{usuario}', [UsuarioController::class, 'update'])->name('usuarios.update');
        // Agente no elimina usuarios
        // Route::delete('/usuarios/{usuario}', [UsuarioController::class, 'destroy'])->name('usuarios.destroy');
        Route::post('/departamentos', [DepartamentoController::class, 'store'])->name('departamentos.store');
        Route::put('/departamentos/{departamento}', [DepartamentoController::class, 'update'])->name('departamentos.update');
    });

    // Capturista (+ admin/agente para supervisión)
    Route::middleware('role:capturista,admin,agente')->prefix('capturista')->name('capturista.')->group(function () {
        Route::get('pedimentos/lookup', [PedimentoController::class, 'lookup'])->name('pedimentos.lookup');
        Route::resource('pedimentos', PedimentoController::class);
        Route::post('pedimentos/{pedimento}/enviar', [PedimentoController::class, 'enviar'])->name('pedimentos.enviar');
        Route::get('pedimentos/{pedimento}/pdf/{formato?}', [PedimentoController::class, 'pdf'])->name('pedimentos.pdf');
        Route::get('coves/{cove}/pdf', [CoveController::class, 'pdf'])->name('coves.pdf');
        Route::get('dodas/{doda}/pdf', [DodaController::class, 'pdf'])->name('dodas.pdf');

        Route::resource('coves', CoveController::class);
        Route::post('coves/{cove}/enviar', [CoveController::class, 'enviar'])->name('coves.enviar');

        Route::resource('dodas', DodaController::class);
        Route::post('dodas/{doda}/enviar', [DodaController::class, 'enviar'])->name('dodas.enviar');

        Route::get('historial', [HistorialController::class, 'index'])->name('historial.index');
        Route::get('equipo', [EquipoController::class, 'index'])->name('equipo.index');
    });
});

require __DIR__ . '/auth.php';
