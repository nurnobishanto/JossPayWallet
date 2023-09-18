<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\UserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


Route::get('/', [DashboardController::class,'index'])->name('dashboard');
Route::resource('/roles',RoleController::class)->middleware('permission:role_manage');
Route::resource('/permissions',PermissionController::class)->middleware('permission:permission_manage');

//Admin
Route::get('/admins/trashed',[AdminController::class,'trashed_list'])->middleware('permission:admin_manage')->name('admins.trashed');
Route::get('/admins/trashed/{admin}/restore',[AdminController::class,'restore'])->middleware('permission:admin_manage')->name('admins.restore');
Route::get('/admins/trashed/{admin}/delete',[AdminController::class,'force_delete'])->middleware('permission:admin_manage')->name('admins.force_delete');
Route::resource('/admins',AdminController::class)->middleware('permission:admin_manage');

//User
Route::get('/users/trashed',[UserController::class,'trashed_list'])->middleware('permission:user_manage')->name('users.trashed');
Route::get('/users/trashed/{user}/restore',[UserController::class,'restore'])->middleware('permission:user_manage')->name('users.restore');
Route::get('/users/trashed/{user}/delete',[UserController::class,'force_delete'])->middleware('permission:user_manage')->name('users.force_delete');
Route::resource('/users',UserController::class)->middleware('permission:user_manage');

//Store
Route::get('/stores/trashed',[AdminController::class,'trashed_list'])->middleware('permission:store_manage')->name('stores.trashed');
Route::get('/stores/trashed/{store}/restore',[AdminController::class,'restore'])->middleware('permission:store_manage')->name('stores.restore');
Route::get('/stores/trashed/{store}/delete',[AdminController::class,'force_delete'])->middleware('permission:store_manage')->name('stores.force_delete');
Route::resource('/stores',AdminController::class)->middleware('permission:store_manage');
