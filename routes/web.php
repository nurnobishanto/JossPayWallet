<?php

use App\Models\Store;
use App\Models\WithdrawAccount;
use Illuminate\Support\Facades\Route;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
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


Route::get('/wp-pay',[\App\Http\Controllers\PaymentController::class,'request_wp']);
Route::get('/payment/{id}',[\App\Http\Controllers\PaymentController::class,'transaction_pay']);

Route::post('/request',[\App\Http\Controllers\PaymentController::class,'request'])->name('payment_request');
Route::post('/success',[\App\Http\Controllers\PaymentController::class,'success'])->name('success');
Route::post('/fail',[\App\Http\Controllers\PaymentController::class,'fail'])->name('fail');
Route::get('/cancel',[\App\Http\Controllers\PaymentController::class,'cancel'])->name('cancel');
Route::get('qr/{store}/default-payment',[\App\Http\Controllers\PLController::class,'default_payment_link_qr_code']);
Route::get('{store}/default-payment',[\App\Http\Controllers\PLController::class,'default_payment_link']);
Route::get('qr/{store}/d-pay',[\App\Http\Controllers\PLController::class,'default_payment_link_qr_code'])->name('store.default_payment_link_qr_code');
Route::get('{store}/d-pay',[\App\Http\Controllers\PLController::class,'default_payment_link'])->name('store.default_payment_link');
Route::post('payment-status',[\App\Http\Controllers\PLController::class,'payment_status'])->name('payment_status');

