<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\User\CardController;
use App\Http\Controllers\User\CostController;
use App\Http\Controllers\User\HomeController;
use App\Http\Controllers\User\GuideController;
use App\Http\Controllers\User\IncomeController;
use App\Http\Controllers\User\ReportController;
use App\Http\Controllers\User\DeletedController;
use App\Http\Controllers\User\WelcomeController;
use App\Http\Controllers\User\CategoryController;
use App\Http\Controllers\User\CostCategoryController;
use App\Http\Controllers\User\IncomeCategoryController;


Route::get('/', [WelcomeController::class, 'welcome'])->name('welcome');

Route::group(['prefix' => '/users' , 'namespace' => 'User'], function () {

    Route::get('/home', [HomeController::class, 'home'])->name('users.home');

    Route::get('/guide', [GuideController::class, 'guide'])->name('users.guide');

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

// Card Transaction Income Route =>
    Route::get('/cards/{card_id}/incomes/create', [CardController::class, 'incomeCreate'])->name('users.cards.incomes.create');
    Route::post('/cards/{card_id}/incomes/store', [CardController::class, 'incomeStore'])->name('users.cards.incomes.store');
    Route::get('/cards/{card_id}/incomes', [CardController::class, 'incomes'])->name('users.cards.incomes.index');

// Card Transaction Cost Route =>
    Route::get('/cards/{card_id}/costs/create', [CardController::class, 'costCreate'])->name('users.cards.costs.create');
    Route::post('/cards/{card_id}/costs/store', [CardController::class, 'costStore'])->name('users.cards.costs.store');
    Route::get('/cards/{card_id}/costs', [CardController::class, 'costs'])->name('users.cards.costs.index');


// Category Route =>
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


// Cost Category Routes =>
    Route::get('/categories/costs', [CostCategoryController::class, 'index'])->name('users.categories.costs.index');
    Route::get('/categories/costs/create', [CostCategoryController::class, 'create'])->name('users.categories.costs.create');
    Route::post('/categories/costs/store', [CostCategoryController::class, 'store'])->name('users.categories.costs.store');
    Route::get('/categories/costs/{category_id}/edit', [CostCategoryController::class, 'edit'])->name('users.categories.costs.edit');
    Route::put('/categories/costs/{category_id}/update', [CostCategoryController::class, 'update'])->name('users.categories.costs.update');
    Route::get('/categories/costs/{category_id}/delete', [CostCategoryController::class, 'delete'])->name('users.categories.costs.delete');


// Cost Routes =>
    Route::get('/costs', [CostController::class, 'index'])->name('users.costs.index');
    Route::get('/costs/create', [CostController::class, 'create'])->name('users.costs.create');
    Route::post('/costs/store', [CostController::class, 'store'])->name('users.costs.store');
    Route::get('/costs/{cost_id}/show', [CostController::class, 'show'])->name('users.costs.show');
    Route::get('/costs/{cost_id}/edit', [CostController::class, 'edit'])->name('users.costs.edit');
    Route::put('/costs/{cost_id}/update', [CostController::class, 'update'])->name('users.costs.update');
    Route::get('/costs/{cost_id}/delete', [CostController::class, 'delete'])->name('users.costs.delete');


// Reports Routes =>
    Route::get('/reports', [ReportController::class, 'select'])->name('users.reports.select');

// Reports Routes : Incomes =>
    Route::get('/reports/incomes', [ReportController::class, 'incomes'])->name('users.reports.incomes.select');
    Route::get('/reports/incomes/time', [ReportController::class, 'incomeTimeSelect'])->name('users.reports.incomes.timeSelect');
    Route::get('/reports/incomes/day', [ReportController::class, 'incomesDay'])->name('users.reports.incomes.time.day');
    Route::get('/reports/incomes/week', [ReportController::class, 'incomesWeek'])->name('users.reports.incomes.time.week');
    Route::get('/reports/incomes/month', [ReportController::class, 'incomesMonth'])->name('users.reports.incomes.time.month');


// Reports Routes : Costs =>
    Route::get('/reports/costs', [ReportController::class, 'costs'])->name('users.reports.costs.select');
    Route::get('/reports/costs/day', [ReportController::class, 'costsDay'])->name('users.reports.costs.day');
    Route::get('/reports/costs/week', [ReportController::class, 'costsWeek'])->name('users.reports.costs.week');
    Route::get('/reports/costs/month', [ReportController::class, 'costsMonth'])->name('users.reports.costs.month');


// Reports Routes : Deleted =>
    Route::get('/deleted', [DeletedController::class, 'select'])->name('users.deleted.select');

    Route::get('/deleted/incomes', [DeletedController::class, 'incomes'])->name('users.deleted.incomes');
    Route::get('/deleted/incomes/{income_id}/restore', [DeletedController::class, 'restore'])->name('users.deleted.incomes.restore');
    Route::get('/deleted/incomes/{income_id}/forceDelete', [DeletedController::class, 'forceDelete'])->name('users.deleted.incomes.forceDelete');























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
