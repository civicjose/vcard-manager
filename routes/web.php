<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VCardController;
use App\Http\Controllers\CompanyController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Aquí es donde puedes registrar las rutas web de tu aplicación. Estas
| rutas son cargadas por el RouteServiceProvider y todas serán asignadas
| al grupo "web". ¡Haz que tu aplicación funcione!
|
*/

// Página de bienvenida (pública)
Route::get('/', function () {
    return view('welcome');
});

// Grupo de rutas protegidas por el middleware 'auth'
// Solo usuarios autenticados pueden acceder a estas rutas
Route::middleware(['auth'])->group(function () {

    // Rutas para vCards
    Route::get('/vcards', [VCardController::class, 'index'])->name('vcards.index');
    Route::get('/vcards/create', [VCardController::class, 'create'])->name('vcards.create');
    Route::post('/vcards', [VCardController::class, 'store'])->name('vcards.store');
    Route::get('/vcards/{id}/edit', [VCardController::class, 'edit'])->name('vcards.edit');
    Route::put('/vcards/{id}', [VCardController::class, 'update'])->name('vcards.update');
    Route::delete('/vcards/{id}', [VCardController::class, 'destroy'])->name('vcards.destroy');
    Route::get('/vcards/{slug}', [VCardController::class, 'show'])->name('vcards.show');

    // Rutas para Companies (Empresas)
    Route::get('/companies', [CompanyController::class, 'index'])->name('companies.index');
    Route::get('/companies/create', [CompanyController::class, 'create'])->name('companies.create');
    Route::post('/companies', [CompanyController::class, 'store'])->name('companies.store');
    Route::get('/companies/{id}/edit', [CompanyController::class, 'edit'])->name('companies.edit');
    Route::put('/companies/{id}', [CompanyController::class, 'update'])->name('companies.update');
    Route::delete('/companies/{id}', [CompanyController::class, 'destroy'])->name('companies.destroy');

    Route::get('/profile/edit', function () {
        // Aquí puedes redirigir al dashboard o a otra vista, si no necesitas la edición de perfil
        return redirect()->route('vcards.index');
    })->name('profile.edit');
});

// Ruta del dashboard para usuarios autenticados
Route::get('/dashboard', function () {
    return redirect()->route('vcards.index');
})->middleware(['auth'])->name('dashboard');

// Incluir las rutas de autenticación de Laravel Breeze
require __DIR__.'/auth.php';
