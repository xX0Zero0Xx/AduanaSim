<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', function (Request $request) {
        return view('dashboard', [
            'user' => $request->user(),
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
        return view('dashboard', [
            'user' => $request->user(),
        ]);
    })->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Solo Admin
    Route::middleware('role:admin')->prefix('admin')->name('admin.')->group(function () {
        // Route::get('/usuarios', ...)->name('usuarios.index');
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
