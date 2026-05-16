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

    if(auth()->check()){
        return redirect()->route('dashboard');
    }

    return redirect()->route('login');

});


Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    // Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    // Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    // Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/dashboard',
        [PublikasiController::class,'index']
    )->name('dashboard');

    Route::get('/users',[UserController::class,'index'])
        ->name('users.index');

    Route::get('/users/{user}/edit',[UserController::class,'edit'])
        ->name('users.edit');

    Route::put('/users/{user}',[UserController::class,'update'])
        ->name('users.update');


    Route::delete(
        '/users/{user}',
        [UserController::class,'destroy']
    )->name('users.destroy');

    Route::get(
        '/users/create',
        [UserController::class,'create']
    )->name('users.create');

    Route::post(
        '/users',
        [UserController::class,'store']
    )->name('users.store');

    Route::get('/publikasi',[PublikasiController::class,'list'])
    ->name('publikasi.index');

    Route::get('/publikasi/create', [
        PublikasiController::class,
        'create'
    ])->name('publikasi.create');

    Route::post('/publikasi',
        [PublikasiController::class,'store']
    )->name('publikasi.store');

    Route::get('/publikasi/{publikasi}/edit',
        [PublikasiController::class,'edit'])
        ->name('publikasi.edit');

    Route::put('/publikasi/{publikasi}',
        [PublikasiController::class,'update'])
        ->name('publikasi.update');

    Route::delete('/publikasi/{publikasi}',
        [PublikasiController::class,'destroy'])
        ->name('publikasi.destroy');

    Route::get('/profile',[ProfileController::class,'edit'])
    ->name('profile.edit');

    Route::put('/profile/password',
    [ProfileController::class,'updatePassword'])
    ->name('profile.password');
    
    Route::get('/export-pdf',[PublikasiController::class,'exportPdf'])
    ->name('publikasi.export-pdf');
});

require __DIR__.'/auth.php';
