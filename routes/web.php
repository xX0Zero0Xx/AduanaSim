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
        }

        return view('dashboard', [
            'user' => $user,
            'registeredUserCount' => $user->isAdmin() ? User::query()->count() : null,
            'stats' => $stats,
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
