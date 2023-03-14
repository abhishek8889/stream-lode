<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TestController;

use App\Http\Controllers\Front\HomeController;
use App\Http\Controllers\Front\FrontMembershipController;
use App\Http\Controllers\Front\FrontAboutController;
use App\Http\Controllers\Front\SearchHostController;
use App\Http\Controllers\Hosts\HostMessageController;
use App\Http\Controllers\Front\ApplyDiscountController;
use App\Http\Controllers\Front\MeetingController;
use App\Http\Controllers\Admin\AdminDashController;
use App\Http\Controllers\Admin\settings\SettingsController;
use App\Http\Controllers\Admin\membership\MembershipController;
use App\Http\Controllers\Admin\membership\MembershipPayments;
use App\Http\Controllers\Admin\membership\MembershipFeatureController;
use App\Http\Controllers\Admin\postnotification\PostNotificationController;

use App\Http\Controllers\Admin\users\HostController;
use App\Http\Controllers\Admin\users\GuestController;

use App\Http\Controllers\Admin\discount\DiscountController;
use App\Http\Controllers\Admin\mettings\MeetingsController;



use App\Http\Controllers\Hosts\HostDashController;
use App\Http\Controllers\Hosts\HostAccountController;
use App\Http\Controllers\Authentication\AuthenticationController;
use App\Http\Controllers\Hosts\HostTagController;
use App\Http\Controllers\Hosts\HostMembershipController;
use App\Http\Controllers\Hosts\HostCalendar;
use App\Http\Controllers\Hosts\AppoinmentsController;
use Google\Service\ServiceConsumerManagement\Authentication;

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

// Route::get('/', function () {
//     return view('welcome');
// });
Route::get('host-register-email',function(){
    return view('Emails.host_registration');
});

Route::get('learn-area',[TestController::class,'index'])->name('learn-area');


// Authentication
Route::get('login',[AuthenticationController::class,'login'])->name('login');
Route::get('register',[AuthenticationController::class,'register'])->name('register');
Route::post('loginProc',[AuthenticationController::class,'loginProcess'])->name('loginProc');
Route::post('registerProc',[AuthenticationController::class,'registerProcess'])->name('registerProc');
Route::post('/{id}/update-password',[AuthenticationController::class,'updatePassword'])->name('update-password');
Route::get('logout',[AuthenticationController::class,'logout'])->name('logout');
// Route::get('testing',[AuthenticationController::class,'paymentStatus'])->name('testing');

Route::get('forgotten-password',[AuthenticationController::class,'forgottenPassword']);
Route::post('forgottenProc',[AuthenticationController::class,'ForgottenProcess']);
Route::get('reset-password/{email}/{token}',[AuthenticationController::class,'newpassword']);

// Front Routes 
Route::get('/',[HomeController::class,'index'])->name('/');
Route::get('/membership',[FrontMembershipController::class,'index'])->name('membership');
Route::get('/membership-payment/{slug}',[FrontMembershipController::class,'membershipPayment']);
Route::get('/registration-status',[FrontMembershipController::class,'registrationResponse']);


Route::get('/about-support',[FrontAboutController::class,'index'])->name('about-support');
Route::get('/search-host',[SearchHostController::class,'index'])->name('search-host');
Route::get('/details/{id}',[SearchHostController::class,'hostDetail']);
Route::post('/schedule-meeting',[SearchHostController::class,'scheduleMeeting']);
Route::post('/searchhost',[SearchHostController::class,'searchhost']);

Route::get('/trycode',[SearchHostController::class,'trycode']);

//Meetings
Route::get('/scheduledmeeting',[MeetingController::class,'index']);



Route::get('/coupon-for-host',[ApplyDiscountController::class,'couponForHost'])->name('coupon-for-host');



// Admin Routes
Route::group(['middleware'=>['auth','Admin']],function(){
    Route::group(['prefix' => 'admin'],function(){
        Route::controller(AdminDashController::class)->group(function(){
            Route::get('/dashboard','index')->name('admin-dashboard');
        });
        // Host list
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
        Route::controller(HostController::class)->group(function(){
            Route::post('/message','message');
        });
        // Guest list
        Route::controller(GuestController::class)->group(function(){
            Route::get('/guest-list','guestlist')->name('guest-list');
        });
        // Route::controller(GuestController::class)->group(function(){
        //     Route::get('/host-details/{id}','hostDetail')->name('host-details');
        // });
        // Route::controller(GuestController::class)->group(function(){
        //     Route::get('/host-delete/{id}','hostDelete');
        // });
        // Route::controller(GuestController::class)->group(function(){
        //     Route::post('/host-generals-update','hostGeneralsUpdate');
        // });
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
        Route::controller(MembershipController::class)->group(function(){
            Route::get('/edit-membership-tier/{slug}','edit');
        });
        // Route::controller(MembershipController::class)->group(function(){
        //     Route::post('/update-membership-tier','editproc')->name('update-membership-tier');
        // });
        Route::controller(MembershipController::class)->group(function(){
            Route::get('/delete-membership-tier/{id}','deleteMembership'); //price can not be deleted in product 
        });
        Route::controller(MembershipController::class)->group(function(){
            Route::get('/activate/{id}','activateMembership'); //price can not be deleted in product 
        });
        Route::controller(MembershipController::class)->group(function(){
            Route::post('/update-membership-tier','updateMembership')->name('update-membership-tier'); 
        });
        Route::controller(MembershipPayments::class)->group(function(){
            Route::get('/membership-payment-list','membershipPaymentList')->name('membership-payment-list');
        });
        Route::controller(MembershipPayments::class)->group(function(){
            Route::get('/membership-payment-details/{slug}','membershipPaymentDetails')->name('membership-payment-details');
        });
        Route::controller(MembershipPayments::class)->group(function(){
            Route::get('/membership-payment-refund/{id}','refund');
        });
        //search
        Route::controller(MembershipPayments::class)->group(function(){
            Route::post('/paymentsearch','search')->name('paymentsearch');
        });
    

        // Discount 

        Route::controller(DiscountController::class)->group(function(){
            Route::get('/generate-discount','index')->name('generate-discount');
        });
        Route::controller(DiscountController::class)->group(function(){
            Route::get('/discount-coupon-list','discountList')->name('discount-coupon-list');
        });
        Route::controller(DiscountController::class)->group(function(){
            Route::post('/create-discount','createDiscount')->name('create-discount');
        });
        Route::controller(MeetingsController::class)->group(function(){
            Route::get('/meetings','index')->name('meetings');
        });
        Route::controller(PostNotificationController::class)->group(function(){
            Route::get('/postnotice','index')->name('postnotification');
        });
        Route::controller(PostNotificationController::class)->group(function(){
            Route::post('/sendnotice','sendmessage')->name('sendnotice');
        });
        Route::controller(MembershipFeatureController::class)->group(function(){
            Route::get('/features','index')->name('features');
        });
        Route::controller(MembershipFeatureController::class)->group(function(){
            Route::post('/featureadd','featureadd')->name('featureadd');
        });
        Route::controller(MembershipFeatureController::class)->group(function(){
            Route::post('/featureedit','edit')->name('featureedit');
        });
        
    });
});
// Host Routes

Route::group(['middleware'=>['auth','Host']],function(){
 
    Route::get('/{id}',[HostDashController::class,'index'])->name('host-dashboard');
    // Account Details
    Route::get('/{id}/general-settings',[HostAccountController::class,'index'])->name('general-settings');
    Route::post('/{id}/add-user-meta',[HostAccountController::class,'addUserMeta'])->name('add-user-meta');
    Route::post('/{id}/add-profile-picture',[HostAccountController::class,'addProfilePic'])->name('add-profile-picture');
    Route::get('/{id}/change-password',[HostAccountController::class,'changePassword'])->name('change-password');

    // Tags
    Route::get('/{id}/tags',[HostTagController::class,'index'])->name('tags');
    Route::post('/{id}/add-tags',[HostTagController::class,'addTags'])->name('add-tags');
    Route::post('/{id}/edit-tags',[HostTagController::class,'editTags'])->name('edit-tags');
    Route::post('/{id}/delete-tags',[HostTagController::class,'deleteTags'])->name('delete-tags');
    
    // membership 
    Route::get('/{id}/membership',[HostMembershipController::class,'index'])->name('membership');
    Route::get('/{id}/membership-details',[HostMembershipController::class,'membershipDetail'])->name('membership-details');
    Route::get('/{id}/upgrade-membership',[HostMembershipController::class,'membershipDetail'])->name('upgrade-membership');
    Route::get('/{id}/get-invoice',[HostMembershipController::class,'getInvoice'])->name('get-invoice');
    Route::get('/{id}/subscribe/{slug}',[HostMembershipController::class,'subscribe'])->name('subscribe');
    // Route::post('/{id}/create-subscription',[HostMembershipController::class,'createSubscription'])->name('create-subscription');
    Route::post('create-subscription',[HostMembershipController::class,'createSubscription'])->name('create-subscription');
    Route::get('/{id}/upgrade-subscription',[HostMembershipController::class,'upgradeSubscription'])->name('upgrade-subscription');
    Route::get('/{id}/upgrade-subscription/{slug}',[HostMembershipController::class,'upgradeSubscriptionDetail'])->name('upgrade-subscription');
    Route::post('/{id}/upgrade-to-new-subscription',[HostMembershipController::class,'upgradeSubscriptionProcess'])->name('upgrade-to-new-subscription');
    
    // Calendar
    // Route::get('/{id}/calendar',[HostCalendar::class,'index'])->name('host-calendar');
    // Route::post('/{id}/insert-schedule',[HostCalendar::class,'insertSchedule']); old
      
    Route::get('/{id}/calendar',[HostCalendar::class,'index']);
    Route::post('/{id}/calendar-response',[HostCalendar::class,'ajax']);

    //hostMessage
    Route::get('/{id}/message',[HostMessageController::class,'index']);
    Route::post('host/updatemessage',[HostMessageController::class,'update']);
   
    //Appoinments
    Route::get('{id}/Appoinments',[AppoinmentsController::class,'index']);

});

// Email Template 
