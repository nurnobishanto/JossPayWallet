<?php

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
Route::post('/cancel',[\App\Http\Controllers\PaymentController::class,'cancel'])->name('cancel');

Route::get('qr/{store}/default-payment',[\App\Http\Controllers\PLController::class,'default_payment_link_qr_code'])->name('store.default_payment_link_qr_code');
Route::get('{store}/default-payment',[\App\Http\Controllers\PLController::class,'default_payment_link'])->name('store.default_payment_link');
Route::post('payment-status',[\App\Http\Controllers\PLController::class,'payment_status'])->name('payment_status');
Route::get('/qr', function () {
    $qrCodes = [];
    $qrCodes['simple'] = QrCode::size(120)->generate('https://josspaywallet.com/');
    $qrCodes['changeColor'] = QrCode::size(120)->color(255, 0, 0)->generate('https://josspaywallet.com/');
    $qrCodes['changeBgColor'] = QrCode::size(120)->backgroundColor(255, 0, 0)->generate('https://josspaywallet.com/');

    $qrCodes['styleDot'] = QrCode::size(120)->style('dot')->generate('https://josspaywallet.com/');
    $qrCodes['styleSquare'] = QrCode::size(120)->style('square')->generate('https://josspaywallet.com/');
    $qrCodes['styleRound'] = QrCode::size(120)->style('round')->generate('https://josspaywallet.com/');

    $qrCodes['withImage'] = QrCode::size(200)->format('png')->merge('/public/vendor/adminlte/dist/img/AdminLTELogo.png', .4)->generate('https://josspaywallet.com/');

    return view('qr', $qrCodes);
});
