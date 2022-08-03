<?php

use App\Http\Controllers\EventController;
use App\Http\Controllers\GoogleAccountController;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

Route::prefix('google')->group(function () {
    Route::get('/', [GoogleAccountController::class, 'index'])->name('google.dashboard');
    Route::get('/oauth', [GoogleAccountController::class, 'store'])->name('google.store');
    Route::delete('/{googleAccount}', [GoogleAccountController::class, 'destroy'])->name('google.destroy');
});

Route::get('/events', [EventController::class, 'index'])->name('google.event');

require __DIR__ . '/auth.php';
