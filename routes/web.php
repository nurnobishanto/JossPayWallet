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

Route::post('/request',[\App\Http\Controllers\PaymentController::class,'request']);
Route::post('/success',[\App\Http\Controllers\PaymentController::class,'success'])->name('success');
Route::post('/fail',[\App\Http\Controllers\PaymentController::class,'fail'])->name('fail');
Route::post('/cancel',[\App\Http\Controllers\PaymentController::class,'cancel'])->name('cancel');

Route::get('/test',function (){
    $withdrawals = WithdrawAccount::where('status', 'pending')
        ->where('user_id', 1)
        ->get(['id', 'bank_name', 'account_name']);

    $data = [];
    foreach ($withdrawals as $withdrawal){
        $data[$withdrawal->id] = $withdrawal->bank_name.' - '.$withdrawal->account_name;
    }

    return $data;
});
Route::get('/qr', function () {
    $qrCodes = [];
    $qrCodes['simple'] = QrCode::size(120)->generate('https://www.binaryboxtuts.com/');
    $qrCodes['changeColor'] = QrCode::size(120)->color(255, 0, 0)->generate('https://www.binaryboxtuts.com/');
    $qrCodes['changeBgColor'] = QrCode::size(120)->backgroundColor(255, 0, 0)->generate('https://www.binaryboxtuts.com/');

    $qrCodes['styleDot'] = QrCode::size(120)->style('dot')->generate('https://www.binaryboxtuts.com/');
    $qrCodes['styleSquare'] = QrCode::size(120)->style('square')->generate('https://www.binaryboxtuts.com/');
    $qrCodes['styleRound'] = QrCode::size(120)->style('round')->generate('https://www.binaryboxtuts.com/');

    $qrCodes['withImage'] = QrCode::size(200)->format('png')->merge('/public/vendor/adminlte/dist/img/AdminLTELogo.png', .4)->generate('https://www.binaryboxtuts.com/');

    return view('qr', $qrCodes);
});
