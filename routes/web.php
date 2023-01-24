<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminDashController;
use App\Http\Controllers\Admin\settings\SettingsController;
use App\Http\Controllers\Admin\membership\MembershipController;

use App\Http\Controllers\Admin\users\HostController;
use App\Http\Controllers\Hosts\HostDashController;
use App\Http\Controllers\Hosts\HostAccountController;
use App\Http\Controllers\Authentication\AuthenticationController;
use App\Http\Controllers\Hosts\HostTagController;
use App\Http\Controllers\Hosts\HostMembershipController;
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
        Route::controller(HostController::class)->group(function(){
            Route::get('/host-list','hostList')->name('host-list');
        });
        Route::controller(HostController::class)->group(function(){
            Route::get('/host-details/{id}','hostDetail')->name('host-details');
        });
        Route::controller(HostController::class)->group(function(){
            Route::get('/host-delete/{id}','hostDelete');
        });
        Route::controller(HostController::class)->group(function(){
            Route::post('/host-generals-update','hostGeneralsUpdate');
        });
        Route::controller(SettingsController::class)->group(function(){
            Route::get('/general-settings','index');
        });
        Route::controller(SettingsController::class)->group(function(){
            Route::post('/admin-update','adminUpdate');
        });
        Route::controller(SettingsController::class)->group(function(){
            Route::post('/admin-profile-update','addProfilePic');
        });
        // create membership
        Route::controller(MembershipController::class)->group(function(){
            Route::get('/membership-list','index');
        });
        Route::controller(MembershipController::class)->group(function(){
            Route::get('/add-membership-tier','addMembershipTier');
        });
        Route::controller(MembershipController::class)->group(function(){
            Route::post('/insert-membership-tier','addMembershipTierProc');
        });
        // Route::controller(MembershipController::class)->group(function(){
        //     Route::get('/delete-membership-tier/{id}','deleteMembership'); //price can not be deleted in product 
        // });
        // Route::controller(MembershipController::class)->group(function(){
        //     Route::get('/update-membership-tier/{id}','updateMembership'); 
        // });
        
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
    
    // membership 
    Route::get('/{id}/membership',[HostMembershipController::class,'index'])->name('membership');
    
    Route::post('/{id}/subscribe',[HostMembershipController::class,'subscribe'])->name('subscribe');


});