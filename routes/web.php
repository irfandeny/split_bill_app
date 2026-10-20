<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TripController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TripMemberController;
use App\Http\Controllers\ExpenseController;


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

    Route::resource('trips', TripController::class);
    Route::post('/trips/{trip}/members', [TripMemberController::class, 'store'])->name('trips.members.store');
    Route::delete('/trips/{trip}/members/{member}', [TripMemberController::class, 'destroy'])->name('trips.members.destroy');
    Route::get('/trips/{trip}/expenses/create', [ExpenseController::class, 'create'])->name('expenses.create');
    Route::post('/trips/{trip}/expenses', [ExpenseController::class, 'store'])->name('expenses.store');
    Route::get('/trips/{trip}/expenses/{expense}/edit', [ExpenseController::class, 'edit'])->name('expenses.edit');
    Route::put('/trips/{trip}/expenses/{expense}', [ExpenseController::class, 'update'])->name('expenses.update');
    Route::delete('/trips/{trip}/expenses/{expense}', [ExpenseController::class, 'destroy'])->name('expenses.destroy');
});

require __DIR__.'/auth.php';