<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VCardController;
use App\Http\Controllers\CompanyController;
<<<<<<< HEAD
use App\Http\Controllers\AuthController;
=======
use App\Http\Controllers\UserController;
>>>>>>> 2736f2f813a1498ed8ccc38039a773e44d63b147

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
    return view('auth.login');
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

    // Ruta para mostrar el formulario de crear usuario
    Route::get('admin/users/create', [UserController::class, 'create'])->name('admin.users.create');
    
    // Ruta para procesar el formulario y guardar el nuevo usuario
    Route::post('admin/users', [UserController::class, 'store'])->name('admin.users.store');

    Route::get('/profile/edit', function () {
        // Aquí puedes redirigir al dashboard o a otra vista, si no necesitas la edición de perfil
        return redirect()->route('vcards.index');
    })->name('profile.edit');

    
});

// Rutas de autenticación
Route::get('login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('login', [AuthController::class, 'login']);
Route::post('logout', [AuthController::class, 'logout'])->name('logout');

// Rutas protegidas solo para el administrador
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('admin/dashboard', function() {
        return view('admin.dashboard');
    })->name('admin.dashboard');

    // Ruta para mostrar el formulario de registro y gestionar usuarios
    Route::get('admin/users', [AuthController::class, 'showRegisterForm'])->name('admin.users');
    Route::post('admin/users', [AuthController::class, 'register']);
});



// Rutas protegidas solo para el administrador
Route::middleware(['auth'])->group(function () {
    Route::get('admin/users/create', [UserController::class, 'create'])->name('admin.users.create');
    Route::post('admin/users', [UserController::class, 'store'])->name('admin.users.store');
});


// Ruta del dashboard para usuarios autenticados
Route::get('/dashboard', function () {
    return redirect()->route('vcards.index');
})->middleware(['auth'])->name('dashboard');

// Incluir las rutas de autenticación de Laravel Breeze
require __DIR__.'/auth.php';

Route::get('register', function () {
    abort(403, 'Acceso denegado.');
})->name('register');