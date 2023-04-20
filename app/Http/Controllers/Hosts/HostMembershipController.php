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
use App\Models\MembershipPaymentsData;
use Carbon\Carbon;
use DB;
use Mail;
use App\Mail\HostMembershipUpdateMail;
use App\Models\HostSubscriptions;

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
            // 'collection_method' => 'charge_automatically',
          ]);

          // dd($createMembership);
          // ######################## Store data in membership payment table ###############################

          $str_result = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz01235675854abcdefghjijklmnopqrst';
          $random_order_number = substr(str_shuffle($str_result),0,7);

          $membership_payment = new MembershipPaymentsData;
          $membership_payment->user_id = auth()->user()->id;
          $membership_payment->inovice_id = $createMembership->latest_invoice;
          $membership_payment->stripe_payment_method = $req->token; 
          $membership_payment->order_id = $random_order_number;
          $membership_payment->membership_id = $req->membership_id;
          $membership_payment->membership_total_amount = $createMembership->plan->amount / 100;
          // $membership_payment->discount_coupon_name = null;
          // $membership_payment->discount_percentage_amount = null;
          $membership_payment->payment_amount = $createMembership->plan->amount / 100; // while we use discount then we fix this and diff beteween unused time charge and new charge from invoice 
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
        $payementMethods->brand = $paymentMethodAttachStatus->card->brand;
        $payementMethods->last_4 = $paymentMethodAttachStatus->card->last4;
        $payementMethods->expire_month = $paymentMethodAttachStatus->card->exp_month;
        $payementMethods->expire_year = $paymentMethodAttachStatus->card->exp_year;
        $payementMethods->save();
          // dd($createMembership);
        if($createMembership->status != 'incomplete'){
          $user->membership_id = $req->membership_id;
          $user->save();
          return redirect(url('/'.auth()->user()->unique_id))->with('success','Congratulations you got ' . $membership['name'] . ' for a ' . $membership['interval']);
        }else{
          $user->membership_id = null;
        }

        $user->save();

        return redirect(url('/'.auth()->user()->unique_id))->with('error','Your payment is not done please wait for confirmation');
    
    }

    ///////////////////////// Upgrade Subscription /////////////////////////////

    public function upgradeSubscription(Request $req ,$slug){
     
      $membership_details = MembershipTier::where('status',1)->get();
      $stripe = new \Stripe\StripeClient( env('STRIPE_SEC_KEY') );
      return view('Host.membership.upgrade_membership',compact('membership_details'));

    }
    ////////////////////////// card detials for update subscription ////////////////////////////
    public function upgradeSubscriptionDetail($id , $slug){
        $user_id = '';
        if(isset(auth()->user()->id) && !empty(auth()->user()->id)){
          $user_id = auth()->user()->id;
        }
        $membership = MembershipTier::where('slug',$slug)->first();
        $users_payment_methods =  PaymentMethods::where('user_id',$user_id)->get();
      
        $stripe = new \Stripe\StripeClient( env('STRIPE_SEC_KEY') );

          #################### Create setupintent ##########################

        $intent =  $stripe->setupIntents->create([
            'payment_method_types' => ['card'],
        ]);
          
        return view('Host.membership.upgrade_subscription_detail',compact('membership','intent','users_payment_methods'));
    }

    public function upgradeSubscriptionProcess(Request $req){
      // dd($req);
      // HostSubscriptions
      try{
        $user = User::where('_id',auth()->user()->id)->first();
        $stripe = new \Stripe\StripeClient( env('STRIPE_SEC_KEY') );
        $subscription = '';
        $membership_details = MembershipTier::where('_id',$req->upgraded_membership_id)->first();
        // dd($membership_details['name']);
        $membership_payment = new MembershipPaymentsData;
        $str_result = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz01235675854abcdefghjijklmnopqrst';
        $random_order_number = substr(str_shuffle($str_result),0,7);

        if($req->payment_method == 'default'){
          
          $payment_method = PaymentMethods::where('_id',$req->default_payment_method)->get()->value(['stripe_payment_method']);
          // return $req;
          // dd($req->default_payment_method);
        
          if(isset(auth()->user()->subscription_id) && !empty(auth()->user()->subscription_id)){

            //update customer and make this payment method as default payment method.
            
            $customer = $stripe->customers->update(
              auth()->user()->stripe_customer_id,
              [
                'invoice_settings' => [
                'default_payment_method' => $payment_method,
                ],
              ]
            );
            // ################### update subscription  ##############################

            $subscription = $stripe->subscriptions->retrieve(auth()->user()->subscription_id);
            
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
            // dd($subscription_update_response);
            $invoice = $subscription_update_response->latest_invoice;
            $payment_intent = '';
            $host_inovice_url = '';
            $host_invoice_pdf = '';
            $subtotal = '';
            $invoice_details = '';
            if(!empty($invoice)){
                $invoice_details =  $this->getInvoice($invoice);
                $subtotal = (int)$invoice_details->subtotal / 100;
                $payment_intent = $invoice_details->payment_intent;
                $host_inovice_url = $invoice_details->hosted_invoice_url;
                $host_invoice_pdf = $invoice_details->invoice_pdf;
                $name = auth()->user()->first_name . ' ' . auth()->user()->last_name;
                // send mail for user's email to get activation and payment done
                $mail = Mail::to(auth()->user()->email)->send(new HostMembershipUpdateMail($name , $membership_details['name'], $host_inovice_url , $host_invoice_pdf));
                // dd($mail);
            }
            // ################# membership Payment data save ##########################
            $membership_payment->user_id =  auth()->user()->id;
            $membership_payment->inovice_id = $subscription_update_response->latest_invoice;
            $membership_payment->stripe_payment_intent = $payment_intent; 
            $membership_payment->stripe_payment_method = $payment_method; 
            $membership_payment->payment_method_id = $req->default_payment_method;
            $membership_payment->order_id = $random_order_number;
            $membership_payment->membership_id = $req->upgraded_membership_id;
            $membership_payment->membership_total_amount = $subscription_update_response->plan->amount / 100;
            // prices starts
            $membership_payment->discount_coupon_name = null;
            $membership_payment->subtotal = $subtotal;
            $membership_payment->discount_amount = null ;
            $membership_payment->total = $subtotal ;
            // prices end
            $membership_payment->payment_type = 'upgrade_membership';
            $membership_payment->payment_status = $subscription_update_response->status;
            $membership_payment->save();
          }
          // dd($subscription_update_response);

          // #####################  Host Subscription table update  ###################
         
            $host_subscription = HostSubscriptions::where('host_id',auth()->user()->id)->first();
            $host_subscription->stripe_subscription_id = $subscription_update_response->id;
            $host_subscription->subscription_name = $membership_details['name'];
            $host_subscription->membership_id = $req->upgraded_membership_id;
            $host_subscription->host_id = auth()->user()->id;
            $host_subscription->subscription_status = $subscription_update_response->status;
            $host_subscription->membership_payment_id = $membership_payment->id;
            $host_subscription->update();
          
          // ############################   End   ############################

          if($subscription_update_response->status == 'active'){
            
            $user->membership_id = $req->upgraded_membership_id;
            $user->subscription_id = $subscription_update_response->id;
            $user->update();
            return redirect(url('/'.auth()->user()->unique_id))->with('success','Congratulations you update your membership');
          }else{
            return redirect(url('/'.auth()->user()->unique_id))->with('success','We got your request for membership upgradation please check your registered email for confirmation of payment.');
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
          $newPaymentDetail->brand = $paymentMethodAttachStatus->card->brand;
          $newPaymentDetail->last_4 = $paymentMethodAttachStatus->card->last4;
          $newPaymentDetail->expire_month = $paymentMethodAttachStatus->card->exp_month;
          $newPaymentDetail->expire_year = $paymentMethodAttachStatus->card->exp_year;

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
            // $subscription_update_response
            //  ###########################  membership payment details save ##################

            $invoice = $subscription_update_response->latest_invoice;
            $payment_intent = '';
            $host_inovice_url = '';
            $host_invoice_pdf = '';
            $subtotal = '';
            $invoice_details = '';
            if(!empty($invoice)){
                $invoice_details =  $this->getInvoice($invoice);
                $subtotal = (int)$invoice_details->subtotal / 100;
                $payment_intent = $invoice_details->payment_intent;
                $host_inovice_url = $invoice_details->hosted_invoice_url;
                $host_invoice_pdf = $invoice_details->invoice_pdf;
                $name = auth()->user()->first_name . ' ' . auth()->user()->last_name;
                // send mail for user's email to get activation and payment done
                $mail = Mail::to(auth()->user()->email)->send(new HostMembershipUpdateMail($name , $membership_details['name'], $host_inovice_url , $host_invoice_pdf));
                // dd($mail);
            }
            $membership_payment->user_id =  auth()->user()->id;
            $membership_payment->inovice_id = $subscription_update_response->latest_invoice;
            $membership_payment->stripe_payment_intent = $payment_intent; 
            $membership_payment->stripe_payment_method = $req->token; // stripe payment method
            $membership_payment->payment_method_id = $newPaymentDetail->id;
            $membership_payment->order_id = $random_order_number;
            $membership_payment->membership_id = $req->upgraded_membership_id;
            $membership_payment->membership_total_amount = $subscription_update_response->plan->amount / 100;
            // prices starts
            $membership_payment->discount_coupon_name = null;
            $membership_payment->subtotal = $subtotal;
            $membership_payment->discount_amount = null ;
            $membership_payment->total = $subtotal ;
            // prices end
            $membership_payment->payment_type = 'upgrade_membership';
            $membership_payment->payment_status = $subscription_update_response->status;
            $membership_payment->save();
          }

          // #####################  Host Subscription table update  ###################
          
            $host_subscription = HostSubscriptions::where('host_id',auth()->user()->id)->first();
            $host_subscription->stripe_subscription_id = $subscription_update_response->id;
            $host_subscription->subscription_name = $membership_details['name'];
            $host_subscription->membership_id = $req->upgraded_membership_id;
            $host_subscription->host_id = auth()->user()->id;
            $host_subscription->subscription_status = $subscription_update_response->status;
            $host_subscription->membership_payment_id = $membership_payment->id;
            $host_subscription->update();
          
          // ############################   End   ############################

          if($subscription_update_response->status == 'active'){
            $user->membership_id = $req->upgraded_membership_id;
            $user->subscription_id = $subscription_update_response->id;
            $user->update();
            return redirect(url('/'.auth()->user()->unique_id))->with('success','Congratulations you update your membership');
          }else{
            return redirect(url('/'.auth()->user()->unique_id))->with('success','We got your request for membership upgradation please check your registered email for confirmation of payment.');
          }
        }
      }catch(\Exception $e){
        return $e->getMessage();
      }
    }
    public function getInvoice($invoice_number){
      $stripe = new \Stripe\StripeClient( env('STRIPE_SEC_KEY') );
      $invoice = $stripe->invoices->retrieve(
       $invoice_number,
        []
      );
      // dd($invoice);
      return $invoice;
    }


    public function upgrade($id){
        $subscription_list = MembershipTier::where('status',1)->get();
        // dd($subscription_list);
        return view('Host.membership.upgrade_membershipnew',compact('subscription_list'));
    }
    public function cancelSubscription(Request $req){
      $subscription_id = auth()->user()->subscription_id;
      $stripe = new \Stripe\StripeClient(env('STRIPE_SEC_KEY'));
      $stripe_cancelation = $stripe->subscriptions->cancel(
        $subscription_id,
        []
      );
      if($stripe_cancelation->status == 'canceled' ){
        HostSubscriptions::where('host_id' , auth()->user()->id)->update(['subscription_status'=>$stripe_cancelation->status]);
      }
      return redirect()->back()->with('success','You have succesfully canceled your subscription');
    }
    public function pauseSubscription(Request $req){
      $subscription_id = auth()->user()->subscription_id;
      $stripe = new \Stripe\StripeClient(env('STRIPE_SEC_KEY'));
      $pause_status = $stripe->subscriptions->update(
        $subscription_id,
        ['pause_collection' => ['behavior' => 'void']]
      );
      HostSubscriptions::where('host_id' , auth()->user()->id)->update(['subscription_status'=>'paused']);
      return redirect()->back()->with('success','You have succesfully paused your subscription');
    }
    
}
