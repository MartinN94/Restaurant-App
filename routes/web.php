<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\FoodController;

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
Auth::routes(['register'=>false]);

Route::get('/', [FoodController::class, 'listFood']);

Route::resource('/category', CategoryController::class)->middleware('auth');

Route::resource('/food', FoodController::class)->middleware('auth');

Route::get('/foods/{id}', [FoodController::class, 'view'])->name('food.view');
