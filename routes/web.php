<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Event routes (protected by auth middleware)
    Route::resource('events', \App\Http\Controllers\EventController::class);

    // XML Export/Import routes
    Route::get('/events-export', [\App\Http\Controllers\EventController::class, 'export'])->name('events.export');
    Route::get('/events-import', [\App\Http\Controllers\EventController::class, 'import'])->name('events.import');
    Route::post('/events-import', [\App\Http\Controllers\EventController::class, 'processImport'])->name('events.process-import');
});


require __DIR__ . '/auth.php';
