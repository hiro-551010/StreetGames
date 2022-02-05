<?php

use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\OfficialController;

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
Route::get('/unauth_competition', [Controller::class, 'unauth_competition'])->name('unauth_competition');


// ログイン後のルーティング

Route::get('/home', [HomeController::class, 'home'])->name('home');
// ダッシュボード
Route::get('/dashboard', [HomeController::class, 'dashboard'])->name('dashboard');
// 大会開催
Route::get('/hold', [HomeController::class, 'hold'])->name('hold');
Route::post('/hold_post', [HomeController::class, 'hold_post'])->name('hold_post');
// 大会一覧
Route::match(['get', 'post'], '/competition', [HomeController::class, 'competition'])->name('competition');
Route::get('competition_detail/{id}', [HomeController::class, 'competition_detail'])->name('competition_detail');
// 応募、参加関係
Route::post('/entry', [HomeController::class, 'entry'])->name('entry');
Route::get('/competition_detail/{hold_id}/players/{id}', [OfficialController::class, 'competition_detail_players']);
Route::get('/competition_detail/{hold_id}/host/{id}', [OfficialController::class, 'competition_detail_host'])->name('competition_detail_host');
Route::post('/host_admin_post/{hold_id}/{id}', [OfficialController::class, 'host_admin_post'])->name('host_admin_post');
Route::post('/host_bracket_post/{hold_id}/{id}', [OfficialController::class, 'host_bracket_post'])->name('host_bracket_post');
// チーム関係
Route::get('/team', [HomeController::class, 'team'])->name('team');
Route::post('/team_create_post', [HomeController::class, 'team_create_post'])->name('team_create_post');
Route::post('/team_join_post', [HomeController::class, 'team_join_post'])->name('team_join_post');
Route::get('/team_edit', [HomeController::class, 'team_edit'])->name('team_edit');
Route::post('/team_edit_post', [HomeController::class, 'team_edit_post'])->name('team_edit_post');
// チャット
Route::get('/chat/{name}', [HomeController::class, 'chat'])->name('chat');
Route::post('/chat_post/{name}', [HomeController::class, 'chat_post'])->name('chat_post');
// お問い合わせ
Route::get('/contact', [HomeController::class, 'contact'])->name('contact');
// admin
Route::get('/admin', [AdminController::class, 'admin'])->name('admin');
Route::post('/admin_post_topics', [AdminController::class, 'admin_post_topics'])->name('admin_post_topics');
Route::post('/admin_post_events', [AdminController::class, 'admin_post_events'])->name('admin_post_events');
// チャットページ表示
Route::get('/competition_chat/{hold_id}/{id}/{player_id}', [OfficialController::class, 'competition_chat'])->name('competition_chat');
// チャット送信
Route::post('/chat_add/{hold_id}/{id}', [OfficialController::class, 'chat_add'])->name('chat_add');

