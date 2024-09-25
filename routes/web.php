<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

use App\Http\Controllers\VCardController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\AuthController;

// Rutas para vCards
Route::get('/vcards', [VCardController::class, 'index'])->name('vcards.index');
Route::get('/vcards/create', [VCardController::class, 'create'])->name('vcards.create');
Route::post('/vcards', [VCardController::class, 'store'])->name('vcards.store');
Route::get('/vcards/{id}/edit', [VCardController::class, 'edit'])->name('vcards.edit');
Route::put('/vcards/{id}', [VCardController::class, 'update'])->name('vcards.update');
Route::delete('/vcards/{id}', [VCardController::class, 'destroy'])->name('vcards.destroy');
// Ruta para ver la vCard en detalle
Route::get('/vcards/{slug}', [VCardController::class, 'show'])->name('vcards.show');

// Rutas para Empresas
Route::get('/companies', [CompanyController::class, 'index'])->name('companies.index');
Route::get('/companies/create', [CompanyController::class, 'create'])->name('companies.create');
Route::post('/companies', [CompanyController::class, 'store'])->name('companies.store');
Route::get('/companies/{id}/edit', [CompanyController::class, 'edit'])->name('companies.edit');
Route::put('/companies/{id}', [CompanyController::class, 'update'])->name('companies.update');
Route::delete('/companies/{id}', [CompanyController::class, 'destroy'])->name('companies.destroy');

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



