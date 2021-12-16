<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Controller;

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





Auth::routes();

// ログイン前のルーティング
Route::get('/', [Controller::class, 'index'])->name('index');
Route::get('/unauth_contact', [Controller::class, 'contact'])->name('unauth_contact');

// ログイン後のルーティング
Route::get('/home', [HomeController::class, 'home'])->name('home');
Route::get('/dashboard', [HomeController::class, 'dashboard'])->name('dashboard');
Route::get('/hold', [HomeController::class, 'hold'])->name('hold');
Route::post('/hold_post', [HomeController::class, 'hold_post'])->name('hold_post');
Route::get('competition_detail', [HomeController::class, 'competition_detail'])->name('competition_detail');
Route::get('/competition', [HomeController::class, 'competition'])->name('competition');
Route::post('/entry', [HomeController::class, 'entry'])->name('entry');
Route::get('/players', [HomeController::class, 'players'])->name('players');
Route::post('/players_post', [HomeController::class, 'players_post'])->name('players_post');
Route::get('/chat/{name}', [HomeController::class, 'chat'])->name('chat');
Route::post('/chat_post/{name}', [HomeController::class, 'chat_post'])->name('chat_post');
Route::get('/contact', [HomeController::class, 'contact'])->name('contact');

