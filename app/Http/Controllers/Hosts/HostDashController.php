<?php

namespace App\Http\Controllers\Hosts;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MembershipTier;
use App\Models\User;

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
             
            if(!empty($subscription_details)){
                $product_id = $subscription_details->plan->product;
                if($subscription_details->status == 'active' && !empty($product_id)){
                    $membership_details = MembershipTier::where('membership_tier_id',$product_id)->first();
                    $host_user = User::where('_id',auth()->user()->id)->update(['membership_id'=>$membership_details['id']]);
                }
            }
        }
        return view('Host.Dashboard.index',compact('membership_details'));
    }
}
