<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;

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

Route::get('/competition', function () {
    return view('home');
});

Auth::routes();

// ログイン後のルーティング
Route::get('/home', [HomeController::class, 'home'])->name('home');
Route::get('/dashboard', [HomeController::class, 'dashboard'])->name('dashboard');
Route::get('/hold', [HomeController::class, 'hold'])->name('hold');
Route::get('/competition', [HomeController::class, 'competition'])->name('competition');
Route::get('/players', [HomeController::class, 'players'])->name('players');
Route::get('/contact', [HomeController::class, 'contact'])->name('contact');

