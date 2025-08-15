<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\PunchController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ReportController;

Route::get('/', function () {
    return view('welcome');
});

/*Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');*/

Route::get('/dashboard', [\App\Http\Controllers\PunchController::class, 'index'])
    ->middleware(['auth'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // ===== Funcionário =====
    // Tela para ver e marcar ponto
    Route::get('/ponto', [PunchController::class, 'index'])->name('punch.index');
    // Ação de marcar ponto (POST)
    Route::post('/ponto', [PunchController::class, 'store'])->name('punch.store');

});

Route::middleware('admin')->group(function () {
        Route::resource('employees', EmployeeController::class);
        Route::get('reports', [ReportController::class, 'index'])->name('reports.index');
    });

require __DIR__.'/auth.php';
