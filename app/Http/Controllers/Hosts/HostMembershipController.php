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
use App\Models\MembershipPayments;
use Carbon\Carbon;
use DB;


class HostMembershipController extends Controller
{
    public function index(){
        $membership_details = MembershipTier::all();
        return view('Host.membership.index',compact('membership_details'));
    }

    public function membershipDetail(){
      $membership_tier_details = MembershipTier::Where('_id',auth()->user()->membership_id)->first();
      $stripe = new \Stripe\StripeClient( env('STRIPE_SEC_KEY') );
      $subscription_details = $stripe->subscriptions->retrieve(
        auth()->user()->subscription_id,
        []
      );
      // dd($subscription_details);
      return view('Host.membership.membership_details',compact('membership_tier_details'));
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

    //////////////////////////// Create Subscription ////////////////////////////////////////

    public function createSubscription(Request $req){
      // return $req;
        $current = Carbon::now()->format('Y,m,d');

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

          // ######################## Store data in membership payment table ###############################

          $str_result = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz01235675854abcdefghjijklmnopqrst';
          $random_order_number = substr(str_shuffle($str_result),0,7);

          $membership_payment = new MembershipPayments;
          $membership_payment->user_id = auth()->user()->id;
          $membership_payment->inovice_id = $createMembership->latest_invoice;
          $membership_payment->order_id = $random_order_number;
          $membership_payment->membership_id = $req->membership_id;
          $membership_payment->membership_total_amount = $createMembership->plan->amount / 100;
          // $membership_payment->discount_coupon_name = null;
          // $membership_payment->discount_percentage_amount = null;
          $membership_payment->payment_amount = $createMembership->plan->amount / 100; // while we use discount then we fix this
          $membership_payment->payment_status = $createMembership->status;
          $membership_payment->save();

        // ###################### Send Invoice ##################################

        // $invoice = $stripe->invoices->create([
        //   'customer' => $customer->id,
        //   'subscription' => $createMembership->id,
        //   'collection_method' => 'send_invoice',
        //   'days_until_due' => 2
        // ]);
        // dd($invoice);

        $user = User::find(auth()->user()->id);
        $user->stripe_customer_id = $customer->id;
        $user->subscription_id = $createMembership->id;
        
        // ######################### payment table data save  #######################################

        $payementMethods = new PaymentMethods;
        $payementMethods->user_id = auth()->user()->id;
        $payementMethods->stripe_payment_method = $req->token;  
        // $paymentMethods->brand = 
        // $paymentMethods->ends_in =
        $payementMethods->save();

        if($createMembership->status != 'incomplete'){
          $user->membership_id = $req->membership_id;
          $user->save();
          return redirect(url('/'.auth()->user()->unique_id))->with('success','Congratulations you got ' . $membership['name'] . ' for a ' . $membership['interval']);
        }

        $user->save();

        return redirect(url('/'.auth()->user()->unique_id))->with('error','Your payment is not done please waitfor confirmation');
    
    }

    ///////////////////////// Upgrade Subscription /////////////////////////////

    public function upgradeSubscription(Request $req ,$slug){
     
      $membership_details = MembershipTier::all();
      $stripe = new \Stripe\StripeClient( env('STRIPE_SEC_KEY') );
      return view('Host.membership.upgrade_membership',compact('membership_details'));

    }
    ////////////////////////// card detials for update subscription ////////////////////////////
    public function upgradeSubscriptionDetail($id , $slug){
      
      $membership = MembershipTier::where('slug',$slug)->first();
      
      //   if((isset(auth()->user()->membership_id) || !empty(auth()->user()->membership_id)) && (isset(auth()->user()->subscription_id) || !empty(auth()->user()->subscription_id)) && (isset(auth()->user()->stripe_customer_id) || !empty(auth()->user()->stripe_customer_id))){
      //     $savePayementMethods = PaymentMethods::where('user_id',auth()->user()->id)->get();
          
      //     $stripe = new \Stripe\StripeClient( env('STRIPE_SEC_KEY') );

      //     // if customer want to add new card

      //     $intent =  $stripe->setupIntents->create([
      //       'payment_method_types' => ['card'],
      //     ]);

          //if customer want use existing card for the payment

          // $stripe_payment_method =  $stripe->paymentMethods->all([
          //   'customer' => auth()->user()->stripe_customer_id,
          //   'type' => 'card',
          // ]);
        // }
        $stripe = new \Stripe\StripeClient( env('STRIPE_SEC_KEY') );

        #################### Create setupintent ##########################

        $intent =  $stripe->setupIntents->create([
            'payment_method_types' => ['card'],
          ]);
          
      return view('Host.membership.upgrade_subscription_detail',compact('membership','intent'));
    }

    public function upgradeSubscriptionProcess(Request $req){
      return $req;
      $user = User::where('_id',auth()->user()->id)->first();
      $stripe = new \Stripe\StripeClient( env('STRIPE_SEC_KEY') );
      $subscription = '';
      $membership_details = MembershipTier::where('_id',$req->upgraded_membership_id)->first();
      $payment_method = PaymentMethods::where('user_id',auth()->user()->id)->first()->value('stripe_payment_method');
     
      if($req->payment_method == 'default'){
        if(isset(auth()->user()->subscription_id) || !empty(auth()->user()->subscription_id)){
          $subscription = $stripe->subscriptions->retrieve(auth()->user()->subscription_id);
          // dd($subscription);
          $subscription_update_response = $stripe->subscriptions->update(
            $subscription->id,
            [
              'cancel_at_period_end' => false,
              'proration_behavior' => 'always_invoice',
              'items' => [
                [
                  'id' => $subscription->items->data[0]->id,
                  'price' => $membership_details->price_id,
                ],
                
              ],
            ]
          );

        }
        if($subscription_update_response->status == 'active'){
          $user->membership_id = $req->upgraded_membership_id;
          $user->subscription_id = $subscription_update_response->id;
          $user->update();

          return redirect(url('/'.auth()->user()->unique_id))->with('success','Congratulations you upgraded your membership');
        
        }else{

          return redirect(url('/'.auth()->user()->unique_id))->with('error','Sorry your transaction is under process please wait for a while.');
        
        }
      }else{
        // ###############  While we got new payment method  #####################
       
        // attach new card to customer
        $newPaymentDetail = new PaymentMethods;
        $paymentMethodAttachStatus = $stripe->paymentMethods->attach(
          $req->token,
          ['customer' => auth()->user()->stripe_customer_id]
        );

        //update customer and make this payment method as default payment method.
        
        $customer = $stripe->customers->update(
          auth()->user()->stripe_customer_id,
          [
            'invoice_settings' => [
            'default_payment_method' => $req->token,
            ],
          ]
        );
        
        // Save data as a new payment method for same user

         $newPaymentDetail->user_id = auth()->user()->id;
         $newPaymentDetail->stripe_payment_method = $req->token;
         $newPaymentDetail->card_number = 'card_number';
        //  $newPaymentDetail->brand = 
        // $newPaymentDetail->ends_in = 
         $newPaymentDetail->save();

        // Update Subscription

        if(isset(auth()->user()->subscription_id) || !empty(auth()->user()->subscription_id)){
          $subscription = $stripe->subscriptions->retrieve(auth()->user()->subscription_id);
          // dd($subscription);
          $subscription_update_response = $stripe->subscriptions->update(
            $subscription->id,
            [
              'cancel_at_period_end' => false,
              'proration_behavior' => 'always_invoice',
              'items' => [
                [
                  'id' => $subscription->items->data[0]->id,
                  'price' => $membership_details->price_id,
                ],
                
              ],
            ]
          );

        }
        if($subscription_update_response->status == 'active'){

          $user->membership_id = $req->upgraded_membership_id;
          $user->subscription_id = $subscription_update_response->id;
          $user->update();

          return redirect(url('/'.auth()->user()->unique_id))->with('success','Congratulations you upgraded your membership');
        
        }else{

          return redirect(url('/'.auth()->user()->unique_id))->with('error','Sorry your transaction is under process please wait for a while.');
        
        }
        
      }

      
    }



    public function getInvoice(){
      $stripe = new \Stripe\StripeClient( env('STRIPE_SEC_KEY') );
      $invoice = $stripe->invoices->retrieve(
        'in_1MUqM2SDpE15tSXhRTCOmjjD',
        []
      );
      dd($invoice);
    }
    
}
