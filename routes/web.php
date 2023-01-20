<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminDashController;
use App\Http\Controllers\Admin\UserListController;

use App\Http\Controllers\Hosts\HostDashController;
use App\Http\Controllers\Hosts\HostAccountController;
use App\Http\Controllers\Authentication\AuthenticationController;
use App\Http\Controllers\Hosts\HostTagController;
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
// Authentication
Route::get('login',[AuthenticationController::class,'login'])->name('login');
Route::get('register',[AuthenticationController::class,'register'])->name('register');
Route::post('loginProc',[AuthenticationController::class,'loginProcess'])->name('loginProc');
Route::post('registerProc',[AuthenticationController::class,'registerProcess'])->name('registerProc');
Route::post('/{id}/update-password',[AuthenticationController::class,'updatePassword'])->name('update-password');
Route::get('logout',[AuthenticationController::class,'logout'])->name('logout');
// Admin Routes
Route::group(['middleware'=>['auth','Admin']],function(){
    Route::group(['prefix' => 'admin'],function(){
        Route::controller(AdminDashController::class)->group(function(){
            Route::get('/dashboard','index')->name('admin-dashboard');
        });
        Route::controller(UserListController::class)->group(function(){
            Route::get('/host-list','hostList')->name('host-list');
        });
        Route::controller(UserListController::class)->group(function(){
            Route::get('/host-details/{id}','hostDetail')->name('host-details');
        });
         Route::controller(UserListController::class)->group(function(){
            Route::get('/host-delete/{id}','hostDelete');
        });
    });
});
// Host Routes
Route::group(['middleware'=>['auth','Host']],function(){
    // Route::group(['prefix' => 'host'],function(){
        Route::controller(HostDashController::class)->group(function(){
            Route::get('/{id}','index')->name('host-dashboard');
        });
    // });
    Route::get('/{id}/general-settings',[HostAccountController::class,'index'])->name('general-settings');
    Route::post('/{id}/add-user-meta',[HostAccountController::class,'addUserMeta'])->name('add-user-meta');
    Route::post('/{id}/add-profile-picture',[HostAccountController::class,'addProfilePic'])->name('add-profile-picture');
    Route::get('/{id}/change-password',[HostAccountController::class,'changePassword'])->name('change-password');

    Route::get('/{id}/tags',[HostTagController::class,'index'])->name('tags');
    Route::post('/{id}/add-tags',[HostTagController::class,'addTags'])->name('add-tags');
    Route::post('/{id}/edit-tags',[HostTagController::class,'editTags'])->name('edit-tags');
    Route::post('/{id}/delete-tags',[HostTagController::class,'deleteTags'])->name('delete-tags');
});