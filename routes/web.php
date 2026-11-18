<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', function (Request $request) {
        $user = $request->user();

        return view('dashboard', [
            'user' => $user,
            'registeredUserCount' => $user->isAdmin() ? User::query()->count() : null,
        ]);
    })->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::middleware(['auth', 'verified'])->group(function () {

    // Accesible por cualquier rol autenticado
    Route::get('/dashboard', function (Request $request) {
        $user = $request->user();

        return view('dashboard', [
            'user' => $user,
            'registeredUserCount' => $user->isAdmin() ? User::query()->count() : null,
        ]);
    })->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Solo Admin
    Route::middleware('role:admin')->prefix('admin')->name('admin.')->group(function () {
        Route::post('/usuarios', [UserController::class, 'store'])->name('usuarios.store');
        Route::put('/usuarios/{usuario}', [UserController::class, 'update'])->name('usuarios.update');
        Route::patch('/usuarios/{usuario}/suspend', [UserController::class, 'suspend'])->name('usuarios.suspend');
        Route::patch('/usuarios/{usuario}/activate', [UserController::class, 'activate'])->name('usuarios.activate');
        Route::delete('/usuarios/{usuario}', [UserController::class, 'destroy'])->name('usuarios.destroy');
        // Route::get('/catalogos', ...)->name('catalogos.index');
    });

    // Solo Agente
    Route::middleware('role:agente')->prefix('agente')->name('agente.')->group(function () {
        // Route::get('/pendientes', ...)->name('pendientes');
    });

    // Solo Capturista
    Route::middleware('role:capturista')->prefix('capturista')->name('capturista.')->group(function () {
        // Route::get('/pedimentos', ...)->name('pedimentos.index');
    });

    // Varios roles permitidos
    Route::middleware('role:admin,agente')->group(function () {
        // Rutas compartidas entre admin y agente
    });
});

require __DIR__ . '/auth.php';




require __DIR__ . '/auth.php';
