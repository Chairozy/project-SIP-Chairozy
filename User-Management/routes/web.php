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

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/user', [HomeController::class, 'index'])->name('user');

Route::get('/user/add', [HomeController::class, 'addData']);
Route::get('/user/detail', [HomeController::class, 'detail'])->name('detail');

Route::get('/direct/{id}', [HomeController::class, 'direct']);

Route::get('/delete/{id}', [HomeController::class, 'delete']);
Route::post('/update', [HomeController::class, 'updateUser']);

Route::post('/user/send', [HomeController::class, 'sendUser']);

Route::view('/test', 'test');
