<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RestaurantController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\TableController;
use App\Http\Controllers\PublicMenuController;

/*
|--------------------------------------------------------------------------
| Route publique
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome');
});

// Menu numérique public (accessible sans connexion)
Route::get('/menu/{slug}', [PublicMenuController::class, 'show'])
    ->name('public.menu');

/*
|--------------------------------------------------------------------------
| Routes protégées (authentification)
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'verified'])->group(function () {

    // Dashboard
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    /*
    |--------------------------------------------------------------------------
    | Restaurant
    |--------------------------------------------------------------------------
    */

    Route::get('/restaurant', [RestaurantController::class, 'index'])
        ->name('restaurant.index');

    Route::post('/restaurant', [RestaurantController::class, 'store'])
        ->name('restaurant.store');

    /*
    |--------------------------------------------------------------------------
    | Catégories
    |--------------------------------------------------------------------------
    */

    Route::resource('categories', CategoryController::class)
        ->except(['create', 'show', 'edit']);

    /*
    |--------------------------------------------------------------------------
    | Produits
    |--------------------------------------------------------------------------
    */

    Route::resource('products', ProductController::class);

    /*
    |--------------------------------------------------------------------------
    | Tables & QR Codes
    |--------------------------------------------------------------------------
    */

    Route::resource('tables', TableController::class)
        ->only(['index', 'store', 'destroy']);
});

/*
|--------------------------------------------------------------------------
| Profil utilisateur
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');
});

require __DIR__ . '/auth.php';