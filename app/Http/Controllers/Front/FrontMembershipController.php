<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MembershipTier;
use App\Models\MembershipFeature;
class FrontMembershipController extends Controller
{
    //
    public function index(){
        $subscription_list = MembershipTier::where('status',1)->get();
        // $subscription_list = MembershipTier::where('slug','standard-group-tier')->get();
        // dd();
        return view('Guests.membership.index',compact('subscription_list'));
    }
    public function membershipPayment(Request $req , $slug){
        $subscription_details = MembershipTier::where('slug',$slug)->first();
        $stripe = new \Stripe\StripeClient( env('STRIPE_SEC_KEY') );

          #################### Create setupintent ##########################

          $intent =  $stripe->setupIntents->create([
              'payment_method_types' => ['card'],
            ]);
        return view('Guests.membership.membership_payment',compact('subscription_details','intent'));
    }
    public function registrationResponse(){
        return view('Guests.membership.registration_response');
    }
}
