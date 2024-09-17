<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

use App\Http\Controllers\VCardController;
use App\Http\Controllers\CompanyController;

// Rutas para vCards
Route::get('/vcards', [VCardController::class, 'index'])->name('vcards.index');
Route::get('/vcards/create', [VCardController::class, 'create'])->name('vcards.create');
Route::post('/vcards', [VCardController::class, 'store'])->name('vcards.store');
Route::get('/vcards/{id}/edit', [VCardController::class, 'edit'])->name('vcards.edit');
Route::put('/vcards/{id}', [VCardController::class, 'update'])->name('vcards.update');
Route::delete('/vcards/{id}', [VCardController::class, 'destroy'])->name('vcards.destroy');
// Ruta para ver la vCard en detalle
Route::get('/vcards/{id}', [VCardController::class, 'show'])->name('vcards.show');

// Rutas para Empresas
Route::get('/companies', [CompanyController::class, 'index'])->name('companies.index');
Route::get('/companies/create', [CompanyController::class, 'create'])->name('companies.create');
Route::post('/companies', [CompanyController::class, 'store'])->name('companies.store');
Route::get('/companies/{id}/edit', [CompanyController::class, 'edit'])->name('companies.edit');
Route::put('/companies/{id}', [CompanyController::class, 'update'])->name('companies.update');
Route::delete('/companies/{id}', [CompanyController::class, 'destroy'])->name('companies.destroy');



