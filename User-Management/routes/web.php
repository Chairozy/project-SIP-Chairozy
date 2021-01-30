<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\GuestController;
use App\Http\Controllers\ExcelController;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ExcelExport;

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

Route::group(['middleware' => ['role:Admin']], function () {
    
});
//General
Route::get('/', [GuestController::class, 'index']);
Route::get('/home', [GuestController::class, 'index'])->name('home');
Route::get('/about', [GuestController::class, 'about']);
Route::get('/buku', [GuestController::class, 'bukufront']);

//Member
Route::get('/dashboard', [HomeController::class, 'index'])->name('dashboard');
Route::get('/memory', [HomeController::class, 'storage'])->name('memory');
Route::post('/upload', [HomeController::class, 'uploadFile']);
Route::get('/deletefile/{id}', [HomeController::class, 'deleteFile']);
Route::post('/deletefiles', [HomeController::class, 'deleteFiles']);
Route::get('/keluhan', [HomeController::class, 'keluhan']);


Route::get('/user', [HomeController::class, 'user'])->name('user');
Route::get('/user/detail', [HomeController::class, 'detail'])->name('detail');
Route::get('/direct/{id}', [HomeController::class, 'direct']);

Route::get('/data/buku', [HomeController::class, 'buku'])->name('buku');
Route::get('/buku/direct/{id}', [HomeController::class, 'buku_direct']);
Route::get('/buku/detail', [HomeController::class, 'buku_detail'])->name('buku_detail');



//Admin
Route::group(['middleware' => ['role:Admin']], function () {

    Route::post('/data/buku/send', [HomeController::class, 'sendBuku']);
    Route::get('/buku/add', [HomeController::class, 'addBuku']);

    Route::get('/data/buku/delete/{id}', [HomeController::class, 'bukudelete']);
    Route::post('/data/buku/deletes', [HomeController::class, 'bukudeletes']);
    Route::post('/data/buku/update', [HomeController::class, 'updateBuku']);

    Route::get('/user/add', [HomeController::class, 'addData']);

    Route::get('/delete/{id}', [HomeController::class, 'delete']);
    Route::post('/deletes', [HomeController::class, 'deletes']);
    Route::post('/update', [HomeController::class, 'updateUser']);

    Route::post('/user/send', [HomeController::class, 'sendUser']);

    //Excel
    Route::get('/export', [ExcelController::class, 'export']);
    Route::post('/import', [ExcelController::class, 'import']);
});