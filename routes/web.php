<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AttendeesController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('/reset', function (){
    Artisan::call('route:clear');
    Artisan::call('cache:clear');
    Artisan::call('config:clear');
    Artisan::call('config:cache');
    return 'Done';
});

Route::get('/migrate', function (){
    Artisan::call('migrate');
    return 'Migrated :)';
});

Route::get('/fresh', function (){
    Artisan::call('migrate:fresh');
    return 'Migrated :)';
});

Route::get('/', function () {
    return view('home');
});

Route::get('/dashboard', [App\Http\Controllers\AttendeesController::class, 'index'])->name('/dashboard');

// Route::resource('attendees',AttendeesController::class)->names('attendees');
// Route::get('attendees', [AttendeesController::class, 'index']);

// Route::get('attendees/create', [AttendeesController::class, 'create']);

Route::post('/store', [AttendeesController::class, 'store'])->name('/store');

// Route::get('attendees/{attendee}/edit', [AttendeesController::class, 'edit']);

// Route::put('attendees/{attendee}', [AttendeesController::class, 'update']);

// Route::get('attendees/{attendee}', [AttendeesController::class, 'show']);

// Route::delete('attendees/{attendee}', [AttendeesController::class, 'destroy']);