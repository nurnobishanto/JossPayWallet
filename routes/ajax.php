<?php

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;

Route::get('get-stores/{user_id}',[\App\Http\Controllers\AjaxController::class,'getStoresByUserId']);
Route::get('get-withdraw-accounts/{user_id}',[\App\Http\Controllers\AjaxController::class,'getWithdrawAccountsByUserId']);
Route::get('get-store-balance/{store_id}',[\App\Http\Controllers\AjaxController::class,'getStoreBalanceByStoreId']);

