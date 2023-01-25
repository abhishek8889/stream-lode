<?php

namespace App\Http\Controllers\Hosts;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MembershipTier;
use App\Models\User;
use Auth;
use Stripe;
use Stripe\StripeClient;
use App\Models\PaymentMethods;
use DB;


class HostMembershipController extends Controller
{
    public function index(){
        $membership_details = MembershipTier::all();
        // dd($membership_details);
        return view('Host.membership.index',compact('membership_details'));
    }

    public function subscribe(Request $req,$id,$slug){
     
        $membership = MembershipTier::where('slug',$slug)->first();
        
        $stripe = new \Stripe\StripeClient( env('STRIPE_SEC_KEY') );

         #################### Create setupintent ##########################

        $intent =  $stripe->setupIntents->create([
            'payment_method_types' => ['card'],
          ]);
          
       return view('Host.membership.subscribe',compact('membership','intent'));
    }

    public function createSubscription(Request $req){
        // return $req;
        
        $membership = DB::table('membership')->find($req->membership_id) ;
        
        $stripe = new \Stripe\StripeClient( env('STRIPE_SEC_KEY') );

        #################### Create customer ##########################

        $customer =  $stripe->customers->create([
           'name' => $req->name,
           'email' => auth()->user()->email,
           'phone' => auth()->user()->phone,
           'payment_method' => $req->token,
           'invoice_settings' => [
            'default_payment_method' => $req->token,
           ],
           'address' => [
             'line1' => '510 Townsend St',
             'postal_code' => '98140',
             'city' => 'San Francisco',
             'state' => 'CA',
             'country' => 'US',
           ],
          
          ]);

        //   #################### Attach payments method with customer ##########################

        $paymentMethodAttachStatus = $stripe->paymentMethods->attach(
            $req->token,
            ['customer' => $customer->id]
        );

        //  #################### Create subscription ##########################

        $createMembership =  $stripe->subscriptions->create([
            'customer' => $customer->id,
            'items' => [
              ['price' => $membership['price_id']],
            ],
          ]);

        // ######################### customer data save  ##########################################

        $user = User::find(auth()->user()->id);
        $user->stripe_customer_id = $customer->id;
        $user->subscription_id = $createMembership->id;
        $user->membership_id = $req->membership_id;
        $user->save();

        // ######################### payment table data save  #######################################

        $payementMethods = new PaymentMethods;
        $payementMethods->user_id = auth()->user()->id;
        $payementMethods->stripe_payment_method = $req->token;  
        $payementMethods->card_number = 'card_number';
        $payementMethods->save();


    return redirect(url('/'.auth()->user()->unique_id))->with('success','Congratulations you got ' . $membership['name'] . ' for a ' . $membership['interval']);
    }
}
