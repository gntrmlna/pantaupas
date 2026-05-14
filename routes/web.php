<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\UserController;
use App\Http\Controllers\PublikasiController;

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

Route::get('/', function () {
    return view('auth.login');
});


Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/dashboard',
        [PublikasiController::class,'index']
    )->name('dashboard');

    Route::get(
        '/users/create',
        [UserController::class,'create']
    )->name('users.create');


    Route::post(
        '/users',
        [UserController::class,'store']
    )->name('users.store');

    Route::get('/publikasi/create', [
        PublikasiController::class,
        'create'
    ])->name('publikasi.create');

    Route::post('/publikasi',
        [PublikasiController::class,'store']
    )->name('publikasi.store');
});

require __DIR__.'/auth.php';
