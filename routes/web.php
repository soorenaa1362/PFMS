<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\User\CardController;
use App\Http\Controllers\User\HomeController;
use App\Http\Controllers\User\WelcomeController;


Route::get('/', [WelcomeController::class, 'welcome'])->name('welcome');

Route::group(['prefix' => '/users' , 'namespace' => 'User'], function () {

    Route::get('/home', [HomeController::class, 'home'])->name('users.home');

    Route::get('/cards', [CardController::class, 'index'])->name('users.cards.index');
    Route::get('/cards/create', [CardController::class, 'create'])->name('users.cards.create');
    Route::post('/cards/store', [CardController::class, 'store'])->name('users.cards.store');
    Route::get('/cards/{card_id}/show', [CardController::class, 'show'])->name('users.cards.show');

})->middleware(['auth']);



// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

// Route::middleware('auth')->group(function () {
//     Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
//     Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
//     Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
// });

require __DIR__.'/auth.php';
