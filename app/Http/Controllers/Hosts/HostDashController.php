<?php

namespace App\Http\Controllers\Hosts;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MembershipTier;
use App\Models\MembershipPaymentsData;
use App\Models\{HostAppointments,MeetingCharge,StreamPayment};
use App\Models\User;
use App\Models\HostStripeAccount;
use Carbon\Carbon;
use App\Models\HostSubscriptions;
class HostDashController extends Controller
{
    public function index(){
        $membership_details = '';
        $membership_name = '';
        if(isset(auth()->user()->membership_id) && !empty(auth()->user()->membership_id))
        {
            $membership_details = MembershipTier::Where('_id',auth()->user()->membership_id)->first();
            $membership_name = $membership_details['name'];
           
        }
        // Check whether host account registered or not or if register then active or not ///////////////
        $this->checkHostStripeAccountRegisterStatus(auth()->user()->id);

        if(isset(auth()->user()->subscription_id) && !empty(auth()->user()->subscription_id)){
            $stripe = new \Stripe\StripeClient(env('STRIPE_SEC_KEY'));
            $subscription_details =  $stripe->subscriptions->retrieve(
                auth()->user()->subscription_id,
                []
              );
            //  dd($subscription_details);
            // #####################  Host Subscription table update  ###################
            // $host_subscription = HostSubscriptions::where('host_id',auth()->user()->id)->first();
            // if($host_subscription['subscription_status'] != 'paused'){
            //     $host_subscription['subscription_status'] = 'active';
            // }
            // ############################   End   ############################
            // dd($subscription_details);
            if(!empty($subscription_details)){
                $product_id = $subscription_details->plan->product;
                if($subscription_details->status == 'active' && !empty($product_id)){
                    $membership_details = MembershipTier::where('membership_tier_id',$product_id)->first();
                    $host_user = User::where('_id',auth()->user()->id)->update(['membership_id'=>$membership_details['id'],'active_status' => 1]);
                    $user_membership_payment_data = MembershipPaymentsData::where([['user_id','=',auth()->user()->id],['membership_id','=',auth()->user()->membership_id]])->latest()->update(['payment_status'=>'succesfull']); // 
                    // #####################  Host Subscription table update  ###################
                    $host_subscription = HostSubscriptions::where('host_id',auth()->user()->id)->first();
                    if($host_subscription['subscription_status'] != 'paused'){
                        $host_subscription['subscription_status'] = 'active';
                    }
                    $host_subscription->update();
                    // ############################   End   ############################
                }else{
                    $host_user = User::where('_id',auth()->user()->id)->update(['membership_id'=>$membership_details['id'],'active_status' => 0]);
                    // #####################  Host Subscription table update  ###################
                    $host_subscription = HostSubscriptions::where('host_id',auth()->user()->id)->first();
                    $host_subscription['subscription_status'] = $subscription_details->status;
                    $host_subscription->update();
                    // ############################   End   ############################
                }
            }
        }
       $CurrentDate = date('Y-m-d');
       $TotalAppoitments =  HostAppointments::where('host_id',auth()->user()->id)->get()->count();
       $TodayAppoitments = HostAppointments::where('start','LIKE',"%{$CurrentDate}%")->where('host_id',auth()->user()->id)->count(); 
       $StreamPayment = StreamPayment::where('host_id',auth()->user()->id)->get(['total'])->toArray();
       $duration = HostAppointments::where('host_id',auth()->user()->id)->get(['total_duration'])->toArray();
       $Total_duration = array();
       for($i=0;$i< count($duration); $i++){
        if(count($duration[$i]) == 2){
            $Total_duration[]= $duration[$i]['total_duration'];
        }
       }              
    
       $TotalAmount = array();
       for($i=0; $i< count($StreamPayment); $i++){
        $TotalAmount[] = $StreamPayment[$i]['total'];
       }
        return view('Host.Dashboard.index',compact('membership_details','TotalAppoitments','TodayAppoitments','TotalAmount','Total_duration'));
    }
    public function trycode(){
        // $res=HostAppointments::where('id','!=','sdg98')->delete();
    }
    public function checkHostStripeAccountRegisterStatus($host_id){
        $account_details = HostStripeAccount::where('host_id',$host_id)->first();
        if(!empty($account_details)){
            $account_num = $account_details['stripe_account_num'];
            $stripe = new \Stripe\StripeClient(env('STRIPE_SEC_KEY'));
            $stripe_account_details = $stripe->accounts->retrieve($account_num,[]);
            // dd($stripe_account_details);
            if($stripe_account_details->payouts_enabled == true){
                $account_details->active_status = 'true';
                $account_details->update();
            }else{
                $account_details->active_status = 'false';
                $account_details->update();
            }
        }
        return true;
    }
}
