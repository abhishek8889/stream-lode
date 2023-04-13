<?php

namespace App\Http\Controllers\Hosts;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MembershipTier;
use App\Models\MembershipPaymentsData;
use App\Models\{HostAppointments,MeetingCharge};
use App\Models\User;
use Carbon\Carbon;
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
        if(isset(auth()->user()->subscription_id) && !empty(auth()->user()->subscription_id)){
            $stripe = new \Stripe\StripeClient(env('STRIPE_SEC_KEY'));
            $subscription_details =  $stripe->subscriptions->retrieve(
                auth()->user()->subscription_id,
                []
              );
            //  dd($subscription_details);
            if(!empty($subscription_details)){
                $product_id = $subscription_details->plan->product;
                if($subscription_details->status == 'active' && !empty($product_id)){
                    $membership_details = MembershipTier::where('membership_tier_id',$product_id)->first();
                    $host_user = User::where('_id',auth()->user()->id)->update(['membership_id'=>$membership_details['id'],'active_status' => 1]);
                    $user_membership_payment_data = MembershipPaymentsData::where([['user_id','=',auth()->user()->id],['membership_id','=',auth()->user()->membership_id]])->latest()->update(['payment_status'=>'succesfull']);
                }
            }
        }
       $CurrentDate = date('Y-m-d');
       $TotalAppoitments =  HostAppointments::where('host_id',auth()->user()->id)->get()->count();
       $TodayAppoitments = HostAppointments::where('start','LIKE',"%{$CurrentDate}%")->where('host_id',auth()->user()->id)->count();
       $LiveDuration = MeetingCharge::where('host_id',auth()->user()->id)->get(['duration_in_minutes','amount'])->toArray(); 
       $Totalvctime = array();
       $TotalAmount = array();
       for($i=0; $i< count($LiveDuration); $i++){
        $Totalvctime[] = $LiveDuration[$i]['duration_in_minutes'];
        $TotalAmount[] = $LiveDuration[$i]['amount'];
       }
        return view('Host.Dashboard.index',compact('membership_details','TotalAppoitments','TodayAppoitments','Totalvctime','TotalAmount'));
    }
    public function trycode(){
        // $res=HostAppointments::where('id','!=','sdg98')->delete();
    }
}
