<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/test-broadcast', function () {
    \Log::info('=== BROADCAST TEST START ===');
    
    try {
        // Log configuration
        \Log::info('Broadcasting driver: ' . config('broadcasting.default'));
        \Log::info('Pusher App ID: ' . config('broadcasting.connections.pusher.app_id'));
        \Log::info('Pusher Key: ' . config('broadcasting.connections.pusher.key'));
        \Log::info('Pusher Cluster: ' . config('broadcasting.connections.pusher.options.cluster'));
        
        // Create event
        $event = new \App\Events\EventDeleted(999, 'Test Broadcast Event');
        
        \Log::info('Broadcasting event...');
        
        // Broadcast the event
        broadcast($event);
        
        \Log::info('Broadcast completed!');
        
    } catch (\Exception $e) {
        \Log::error('Broadcast ERROR: ' . $e->getMessage());
        \Log::error('Stack: ' . $e->getTraceAsString());
        return 'ERROR: ' . $e->getMessage();
    }
    
    \Log::info('=== BROADCAST TEST END ===');
    
    return 'Broadcast sent! Check Pusher Debug Console and storage/logs/laravel.log';
});



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
