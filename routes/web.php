<?php

use App\Http\Controllers\EventController;
use App\Http\Controllers\EventManagerController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RegistrationController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Public Routes - Events (accessible to everyone)
Route::get('/', function () {
    return view('home');
})->name('home');
Route::get('/events', [EventController::class, 'index'])->name('events.index');
Route::get('/events/search', [EventController::class, 'search'])->name('events.search');
Route::get('/events/filter', [EventController::class, 'filter'])->name('events.filter');
Route::get('/events/{event}', [EventController::class, 'show'])->name('events.show');

// Authenticated Routes - Profile Management
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // User Dashboard (if needed, can redirect to events.index)
    Route::get('/dashboard', function () {
        return redirect()->route('events.index');
    })->middleware('verified')->name('dashboard');

    // Event Registration Routes
    Route::get('/registrations/my-events', [RegistrationController::class, 'myEvents'])
        ->name('registrations.my-events');
    Route::post('/registrations/register/{event}', [RegistrationController::class, 'register'])
        ->name('registrations.register');
    Route::delete('/registrations/unregister/{event}', [RegistrationController::class, 'unregister'])
        ->name('registrations.unregister');
});

// Event Manager Routes (requires authentication and event.manager middleware)
Route::middleware(['auth', 'event.manager'])->prefix('manager')->name('manager.')->group(function () {
    Route::get('/dashboard', [EventManagerController::class, 'dashboard'])->name('dashboard');
    
    // Event CRUD Routes
    Route::get('/events', [EventManagerController::class, 'index'])->name('events.index');
    Route::get('/events/create', [EventManagerController::class, 'create'])->name('events.create');
    Route::post('/events', [EventManagerController::class, 'store'])->name('events.store');
    Route::get('/events/{event}/edit', [EventManagerController::class, 'edit'])->name('events.edit');
    Route::put('/events/{event}', [EventManagerController::class, 'update'])->name('events.update');
    Route::delete('/events/{event}', [EventManagerController::class, 'destroy'])->name('events.destroy');
    
    // Participant Management Routes
    Route::get('/events/{event}/participants', [EventManagerController::class, 'participants'])
        ->name('events.participants');
    Route::patch('/events/{event}/participants/{user}', [EventManagerController::class, 'updateParticipantStatus'])
        ->name('events.participants.update');
});

require __DIR__.'/auth.php';
