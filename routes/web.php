<?php

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
    return view('welcome');
});
Route::get('/imprint', function () {
    return view('imprint');
})->name('imprint');

Route::resource('invoice','App\Http\Controllers\InvoiceController'); // Achtung: APP groß
Route::get('api/invoice-data','App\Http\Controllers\InvoiceController@InvoiceData')->name('getInvoiceData');
Route::put('user-clearing','App\Http\Controllers\InvoiceController@UpdateUserClearing')->name('updateUserClearing');