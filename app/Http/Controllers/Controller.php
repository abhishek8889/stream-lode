<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use App\Models\HostStripeAccount;
use Auth;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    protected $user_name;
    protected $user_id ; 
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            // $this->user_name = Auth::user()->first_name;
            // $this->user_id  = Auth::user()->id; 
            // $this->checkHostAccountRegisterStatus($this->user_id);
            
            return $next($request);
        });
        // echo $this->user_name;
    }
    // public function checkMembershipActivateStatus(){
    //     // return "hellpo i am stripe function";
    // }
    // // Host account is that which host create for get payments from guest : 
    // public function checkHostAccountRegisterStatus($host_id){
    //     if(!empty($host_id)){
    //         $account_details = HostStripeAccount::where('host_id',$host_id)->first();
    //         $host_stripe_acc_num = $account_details['stripe_account_num'];
    //     }
    // }
}
