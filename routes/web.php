<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RestaurantController;
use App\Http\Controllers\CategoryController;

Route::middleware(['auth', 'verified'])->group(function () {
    // ... routes précédentes (dashboard, restaurant)

    // Routes de gestion des catégories
    Route::resource('categories', CategoryController::class)->except(['create', 'show', 'edit']);
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // Routes du restaurant
    Route::get('/restaurant', [RestaurantController::class, 'index'])->name('restaurant.index');
    Route::post('/restaurant', [RestaurantController::class, 'store'])->name('restaurant.store');
});

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
});

require __DIR__.'/auth.php';
