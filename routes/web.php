<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\User\CardController;
use App\Http\Controllers\User\HomeController;
use App\Http\Controllers\User\IncomeController;
use App\Http\Controllers\User\ReportController;
use App\Http\Controllers\User\WelcomeController;
use App\Http\Controllers\User\CategoryController;
use App\Http\Controllers\User\IncomeCategoryController;


Route::get('/', [WelcomeController::class, 'welcome'])->name('welcome');

Route::group(['prefix' => '/users' , 'namespace' => 'User'], function () {

    Route::get('/home', [HomeController::class, 'home'])->name('users.home');

// Card Routes =>
    Route::get('/cards', [CardController::class, 'index'])->name('users.cards.index');
    Route::get('/cards/create', [CardController::class, 'create'])->name('users.cards.create');
    Route::post('/cards/store', [CardController::class, 'store'])->name('users.cards.store');
    Route::get('/cards/{card_id}/show', [CardController::class, 'show'])->name('users.cards.show');
    Route::get('/cards/{card_id}/edit', [CardController::class, 'edit'])->name('users.cards.edit');
    Route::put('/cards/{card_id}/update', [CardController::class, 'update'])->name('users.cards.update');
    Route::get('/cards/{card_id}/delete', [CardController::class, 'delete'])->name('users.cards.delete');

    Route::get('/cards/{card_id}/checkTransactions', [CardController::class, 'checkTransactions'])->name('users.cards.checkTransactions');
    Route::get('/cards/{card_id}/transaction/select', [CardController::class, 'transactionSelect'])->name('users.cards.transaction.select');
    Route::get('/cards/{card_id}/incomes/create', [CardController::class, 'incomeCreate'])->name('users.cards.incomes.create');
    Route::post('/cards/{card_id}/incomes/store', [CardController::class, 'incomeStore'])->name('users.cards.incomes.store');
    Route::get('/cards/{card_id}/incomes', [CardController::class, 'incomes'])->name('users.cards.incomes.index');


// Category Route :
    Route::get('/categories', [CategoryController::Class, 'select'])->name('users.categories.select');


// Income Category Routes =>
    Route::get('/categories/incomes', [IncomeCategoryController::class, 'index'])->name('users.categories.incomes.index');
    Route::get('/categories/incomes/create', [IncomeCategoryController::class, 'create'])->name('users.categories.incomes.create');
    Route::post('/categories/incomes/store', [IncomeCategoryController::class, 'store'])->name('users.categories.incomes.store');
    Route::get('/categories/incomes/{category_id}/edit', [IncomeCategoryController::class, 'edit'])->name('users.categories.incomes.edit');
    Route::put('/categories/incomes/{category_id}/update', [IncomeCategoryController::class, 'update'])->name('users.categories.incomes.update');
    Route::get('/categories/incomes/{category_id}/delete', [IncomeCategoryController::class, 'delete'])->name('users.categories.incomes.delete');


// Income Routes =>
    Route::get('/incomes', [IncomeController::class, 'index'])->name('users.incomes.index');
    Route::get('/incomes/create', [IncomeController::class, 'create'])->name('users.incomes.create');
    Route::post('/incomes/store', [IncomeController::class, 'store'])->name('users.incomes.store');
    Route::get('/incomes/{income_id}/show', [IncomeController::class, 'show'])->name('users.incomes.show');
    Route::get('/incomes/{income_id}/edit', [IncomeController::class, 'edit'])->name('users.incomes.edit');
    Route::put('/incomes/{income_id}/update', [IncomeController::class, 'update'])->name('users.incomes.update');
    Route::get('/incomes/{income_id}/delete', [IncomeController::class, 'delete'])->name('users.incomes.delete');


// Reports Routes =>
    Route::get('/reports', [ReportController::class, 'select'])->name('users.reports.select');

// Reports Routes : Incomes =>
    Route::get('/reports/incomes', [ReportController::class, 'incomes'])->name('users.reports.incomes.select');






















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
