<?php

use App\Http\Controllers\Capturista\CoveController;
use App\Http\Controllers\Capturista\DodaController;
use App\Http\Controllers\Capturista\EquipoController;
use App\Http\Controllers\Capturista\HistorialController;
use App\Http\Controllers\Capturista\PedimentoController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Models\Cove;
use App\Models\Doda;
use App\Models\Pedimento;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

        return view('dashboard', [
            'user' => $user,
            'registeredUserCount' => $user->isAdmin() ? User::query()->count() : null,
            'stats' => $stats,
            'historialItems' => $historialItems,
            'equipos' => $equipos,
            'statsPorEquipo' => $statsPorEquipo,
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

    // Capturista (+ admin/agente para supervisión)
    Route::middleware('role:capturista,admin,agente')->prefix('capturista')->name('capturista.')->group(function () {
        Route::get('pedimentos/lookup', [PedimentoController::class, 'lookup'])->name('pedimentos.lookup');
        Route::resource('pedimentos', PedimentoController::class);
        Route::post('pedimentos/{pedimento}/enviar', [PedimentoController::class, 'enviar'])->name('pedimentos.enviar');
        Route::get('pedimentos/{pedimento}/pdf/{formato?}', [PedimentoController::class, 'pdf'])->name('pedimentos.pdf');

        Route::resource('coves', CoveController::class);
        Route::post('coves/{cove}/enviar', [CoveController::class, 'enviar'])->name('coves.enviar');

        Route::resource('dodas', DodaController::class);
        Route::post('dodas/{doda}/enviar', [DodaController::class, 'enviar'])->name('dodas.enviar');

        Route::get('historial', [HistorialController::class, 'index'])->name('historial.index');
        Route::get('equipo', [EquipoController::class, 'index'])->name('equipo.index');
    });
});

require __DIR__ . '/auth.php';
