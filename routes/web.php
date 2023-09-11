<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BarcodeController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
})->name('barcode.index');

Route::post('/add', [BarcodeController::class, 'store'])->name('barcode.store');

Route::get('/archive', [BarcodeController::class, 'archive'])->name('barcode.archive');

Route::get('/archive/{barcode}', [BarcodeController::class, 'show'])->name('barcode.show');
