<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\TransactionController;
use Illuminate\Support\Facades\Route;

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
    return redirect()->route('login');
});

Auth::routes();

Route::middleware('auth')->group(function () {
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::resource('category', CategoryController::class);
    Route::resource('transaction', TransactionController::class);

    // cari kategori berdasarkan jenis transaksi
    Route::get('type_category/{id}', [TransactionController::class, 'get_category']);

    // cari transaksi berdasarkan tanggal
    Route::get('filter', [TransactionController::class, 'filter_transaction'])->name('fiter.date');
});
