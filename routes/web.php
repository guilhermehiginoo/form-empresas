<?php

use App\Http\Controllers\{CategoryController, CompanyController};
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome');
})->name('home');

Route::get('dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth', 'verified'])->group(function () {
    #region Company Routes
    Route::get('/company/create', [CompanyController::class, 'create'])->name('company.create');
    Route::post('/company/store', [CompanyController::class, 'store'])->name('company.store');
    #endregion

    #region Category Routes
    Route::post('/category/store', [CategoryController::class, 'store'])->name('category.store');
    Route::get('/category/view', [CategoryController::class, 'index'])->name('category.index');
    #endregion
});

require __DIR__ . '/settings.php';

require __DIR__ . '/auth.php';
