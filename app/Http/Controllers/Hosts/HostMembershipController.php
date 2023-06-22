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
use App\Mail\Host_new_subscription;
use App\Mail\Host_cancel_subscription;
use App\Models\HostSubscriptions;
use App\Models\Discounts\AdminDiscount;

class HostMembershipController extends Controller
{
    public function index(){
   
        $membership_details = MembershipTier::where('status',1)->get();
        return view('Host.membership.index',compact('membership_details'));
    }

    public function membershipDetail(){
      $membership_tier_details = MembershipTier::Where('_id',auth()->user()->membership_id)->first();
      $host_subscription_details = HostSubscriptions::Where('host_id',auth()->user()->id)->first();
      $stripe = new \Stripe\StripeClient( env('STRIPE_SEC_KEY') );
      $subscription_details = $stripe->subscriptions->retrieve(
        auth()->user()->subscription_id,
        []
      );
      // dd($subscription_details);
      return view('Host.membership.membership_details',compact('membership_tier_details','host_subscription_details'));
    }

    public function subscribe(Request $req){
      // return $req->slug;
      $user_id = '';
      if(isset(auth()->user()->id) && !empty(auth()->user()->id)){
        $user_id = auth()->user()->id;
      }
      $users_payment_methods =  PaymentMethods::where('user_id',$user_id)->get();

      $subscription_details = MembershipTier::where('slug',$req->slug)->first();
        $stripe = new \Stripe\StripeClient( env('STRIPE_SEC_KEY') );
        #################### Create setupintent ##########################
        $intent =  $stripe->setupIntents->create([
            'payment_method_types' => ['card'],
          ]);
      return view('Host.membership.subscribe',compact('subscription_details','intent','users_payment_methods'));
    }

    //////////////////////////// Create Subscription ////////////////////////////////////////

    public function createSubscription(Request $req){
      // return $req;
      try{
        $user = User::find(auth()->user()->id);
        $user_id = auth()->user()->id;
        $membership_id = $req->membership_id;
        $name = auth()->user()->first_name . ' '. auth()->user()->last_name;
        $email = auth()->user()->email;
        $token ='';
        if($req->payent_method == 'new_payment_method'){
          $token = $req->token;
        }else{
          $payment_method = PaymentMethods::where('_id',$req->payent_method)->get()->value(['stripe_payment_method']);
          $token = $payment_method;
        }
        $coupon_code = $req->coupon_code;
        
        $stripe_coupon_id = '';
        if($coupon_code != null){
            $stripe_coupon_id = AdminDiscount::where('coupon_code',$coupon_code)->get()->value('stripe_coupon_id');
        }
        // dd($stripe_coupon_id);
        $membership = DB::table('membership')->find($membership_id) ;
        
        $stripe = new \Stripe\StripeClient( env('STRIPE_SEC_KEY') );

        #################### Create customer in stripe if by chance deleted ##########################
          $customer_id = '';
          if(isset(auth()->user()->stripe_customer_id) || !empty(auth()->user()->stripe_customer_id)){
            $stripe_customer = $stripe->customers->retrieve(
              auth()->user()->stripe_customer_id,
              []
            );
            if(empty($stripe_customer->id)){
              // create customer id 
              $customer =  $stripe->customers->create([
                'name' => $name,
                'email' => $email,
                'payment_method' => $token,
                'invoice_settings' => [
                'default_payment_method' => $token,
                ],
                'address' => [
                'line1' => '510 Townsend St',
                'postal_code' => '98140',
                'city' => 'San Francisco',
                'state' => 'CA',
                'country' => 'US',
                ],
              ]);
              $customer_id = $customer->id;
              $user->stripe_customer_id = $customer_id;
              $user->update();
            }else{
              $customer_id = auth()->user()->stripe_customer_id;
            }
          }else{
            // if customer id is not set or made or deleted by chance 
            $customer =  $stripe->customers->create([
              'name' => $name,
              'email' => $email,
              'payment_method' => $token,
              'invoice_settings' => [
              'default_payment_method' => $token,
              ],
              'address' => [
              'line1' => '510 Townsend St',
              'postal_code' => '98140',
              'city' => 'San Francisco',
              'state' => 'CA',
              'country' => 'US',
              ],
            ]);
            $customer_id = $customer->id;
            $user->stripe_customer_id = $customer_id;
            $user->update();
          }

          //   #################### Attach payments method with customer ##########################
          $createMembership = '';
          $payementMethods ='';
          if($req->payent_method == 'new_payment_method'){
            $paymentMethodAttachStatus = $stripe->paymentMethods->attach(
              $token,
              ['customer' => $customer_id]
            );
            $customer = $stripe->customers->update(
              auth()->user()->stripe_customer_id,
              [
                'invoice_settings' => [
                'default_payment_method' => $token,
                ],
              ]
            );
            //  #################### Create subscription ##########################
            if($coupon_code != null){
              $createMembership =  $stripe->subscriptions->create([
                  'customer' => $customer_id,
                  'collection_method'=>'charge_automatically',
                  'items' => [
                      [
                          'price' => $membership['price_id'],
                          // 'recurring' => [
                          //     'interval' => 'month', // Frequency at which bills are counted ||## day, week, month or year. ##||
                          //     'interval_count' => 1, // Number of intervals between subscription billings.
                          // ]
                      ],
                  ],
                  'coupon' => $stripe_coupon_id,
              ]);
            }else{
              $createMembership =  $stripe->subscriptions->create([
                  'customer' => $customer_id,
                  'collection_method'=>'charge_automatically',
                  'items' => [
                    ['price' => $membership['price_id']],
                  ]
              ]);
            }
            // ######################### payment table data save  #######################################

            $payementMethods = new PaymentMethods;
            $payementMethods->user_id = $user_id;
            $payementMethods->stripe_payment_method = $token;  
            $payementMethods->brand = $paymentMethodAttachStatus->card->brand;
            $payementMethods->last_4 = $paymentMethodAttachStatus->card->last4;
            $payementMethods->expire_month = $paymentMethodAttachStatus->card->exp_month;
            $payementMethods->expire_year = $paymentMethodAttachStatus->card->exp_year;
            $payementMethods->save();

          }else{
            // return "hello";
            $customer = $stripe->customers->update(
              auth()->user()->stripe_customer_id,
              [
                'invoice_settings' => [
                'default_payment_method' => $token,
                ],
              ]
            );
            //  #################### Create subscription ##########################
            if($coupon_code != null){
              $createMembership =  $stripe->subscriptions->create([
                  'customer' => $customer_id,
                  'collection_method'=>'charge_automatically',
                  'items' => [
                    ['price' => $membership['price_id']],
                  ],
                  'coupon' => $stripe_coupon_id,
              ]);
            }else{
              $createMembership =  $stripe->subscriptions->create([
                  'customer' => $customer_id,
                  'collection_method'=>'charge_automatically',
                  'items' => [
                    ['price' => $membership['price_id']],
                  ]
              ]);
            }
            // ############# END ###########################
          }
          
          // invoice
          $invoice = $createMembership->latest_invoice;
          $payment_intent = '';
          $host_inovice_url = '';
          $host_invoice_pdf = '';
          $subtotal = '';
          $discount = '';
          $total_excluding_discount = '';
          if(!empty($invoice)){
              $invoice_details =  $this->getInvoice($invoice);
              $subtotal = (int)$invoice_details->subtotal / 100;
              $total_excluding_discount = (int)$invoice_details->total /100 ;
              $payment_intent = $invoice_details->payment_intent;
              $host_inovice_url = $invoice_details->hosted_invoice_url;
              $host_invoice_pdf = $invoice_details->invoice_pdf;
              if($coupon_code != null){
                  $discount = (int)$invoice_details->total_discount_amounts[0]->amount / 100;
              }
            
              // dd($mail);
          }
          
          // ######################## Store data in membership payment table ###############################

          $str_result = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz01235675854abcdefghjijklmnopqrst';
          $random_order_number = substr(str_shuffle($str_result),0,7);

          $membership_payment = new MembershipPaymentsData;
          $membership_payment->user_id = $user_id;
          $membership_payment->inovice_id = $createMembership->latest_invoice;
          $membership_payment->stripe_payment_intent = $payment_intent;
          $membership_payment->stripe_payment_method = $token; 
          if($req->payent_method == 'new_payment_method'){
            // new genereate payment method id 
            $membership_payment->payment_method_id = $payementMethods->id;
          }else{
            // default payment method id 
            $membership_payment->payment_method_id = $req->payent_method;
          }
          $membership_payment->order_id = $random_order_number;
          $membership_payment->membership_id = $membership_id;
          $membership_payment->membership_total_amount = $createMembership->plan->amount / 100;
          // prices starts
          $membership_payment->discount_coupon_name = $coupon_code;
          $membership_payment->subtotal = $subtotal;
          $membership_payment->discount_amount = $discount ;
          $membership_payment->total = $total_excluding_discount ;// while we use discount then we fix this and diff beteween unused time charge and new charge from invoice 
          // prices end
          $membership_payment->payment_type = 'create_membership'; // payment type in db 
          if($createMembership->status == 'active'){ // succesfull
            $membership_payment->payment_status = 'succesfull'; // subscription status 
              // send mail for user's email to get activation and payment done
            try {
              $mail = Mail::to($email)->send(new Host_new_subscription($name, $host_inovice_url , $host_invoice_pdf,'success'));
            } catch (\Throwable $th) {
            }
             
          }else{
            $membership_payment->payment_status = $createMembership->status; // subscription status
              // send mail for user's email to get activation and payment done
                try {
                  $mail = Mail::to($email)->send(new Host_new_subscription($name, $host_inovice_url , $host_invoice_pdf,'pending'));
                } catch (\Throwable $th) {
                }
              
          }
          $membership_payment->save();

          //#################  Host Subscription Data update or create  ############################

          
            $host_subscription = HostSubscriptions::where('host_id' , auth()->user()->id)->first();
            if(!empty($host_subscription)){
              // update data in host subscription
              $host_subscription->stripe_subscription_id = $createMembership->id;
              $host_subscription->subscription_name = $membership['name'];
              $host_subscription->membership_id = $membership_id;
              $host_subscription->host_id = $user_id;
              $host_subscription->interval = 'month'; // subscription interval is different 
              $host_subscription->interval_count = 1; // 
              $host_subscription->subscription_status = $createMembership->status;
              $host_subscription->membership_payment_id = $membership_payment->id;
              if($createMembership->status == 'active'){
                  $host_subscription->start_on = date('Y-M-d H:i' ,$createMembership->current_period_start ); // on condition 
                  $host_subscription->next_invoice_generate_on = date('Y-M-d H:i' ,$createMembership->current_period_end ); // on condition 
              }else{
                  $host_subscription->start_on = '00-00-00'; // on condition 
                  $host_subscription->next_invoice_generate_on = '00-00-00'; // on condition 
              }
              $host_subscription->update(); 
            }else{
              //create data in host subscrition
              $host_subscription = new HostSubscriptions;
              $host_subscription->stripe_subscription_id = $createMembership->id;
              $host_subscription->subscription_name = $membership['name'];
              $host_subscription->membership_id = $membership_id;
              $host_subscription->host_id = $user_id;
              $host_subscription->interval = 'month'; // subscription interval is different 
              $host_subscription->interval_count = 1; // 
              $host_subscription->subscription_status = $createMembership->status;
              $host_subscription->membership_payment_id = $membership_payment->id;
              if($createMembership->status == 'active'){
                  $host_subscription->start_on = date('Y-M-d H:i' ,$createMembership->current_period_start ); // on condition 
                  $host_subscription->next_invoice_generate_on = date('Y-M-d H:i' ,$createMembership->current_period_end ); // on condition 
              }else{
                  $host_subscription->start_on = '00-00-00'; // on condition 
                  $host_subscription->next_invoice_generate_on = '00-00-00'; // on condition 
              }
              $host_subscription->save(); 
            }
            
          //######################## USER UPDATE ########################################

          $user = User::find($user_id);
          $user->stripe_customer_id = $customer_id;
          $user->subscription_id = $createMembership->id; // Subscription id got from stripe
          $user->host_subscription_id = $host_subscription->id;  // Subscription id got from host_subscription table 
      
          // dd($createMembership);
          
          if($createMembership->status == 'active'){
              $user->membership_id = $membership_id;
              $user->active_status = 1;   // membership active // depend on subscription status 
              $user->save();
              return redirect(auth()->user()->unique_id.'/subscribe-response')->with(['paymentStatus'=>TRUE,'response'=>'Congratulations you got ' . $membership['name'] . ' for a ' . $membership['interval'],'membership_id'=> $membership_id]);
          }else{
              $user->active_status = 0;   // membership inactive // depend on subscription status
              $user->membership_id = null;
          }
          $user->save();
          return redirect(auth()->user()->unique_id.'/subscribe-response')->with(['paymentStatus'=> FALSE, 'response'=>'You are registered but for payment you will get invoice in your registered email ('.$email.') please pay from there and activate your subscription.','membership_id'=> $membership_id]);

      }catch(\Exception $e){
        return $e;
          // return $e->getMessage();
      }
        
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
      // return $req;
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
                'metadata' => [
                  'update_type' => 'manual_update',                  
                ],
              ]
            );
            $invoice = $subscription_update_response->latest_invoice;
            $payment_intent = '';
            $host_inovice_url = '';
            $host_invoice_pdf = '';
            $subtotal = '';
            $invoice_details = '';
            if(!empty($invoice)){
                $invoice_details =  $this->getInvoice($invoice);
                $subtotal = (int)$invoice_details->subtotal / 100;
                if($subtotal < 0){
                  $subtotal = 0;
                }
                $payment_intent = $invoice_details->payment_intent;
                $host_inovice_url = $invoice_details->hosted_invoice_url;
                $host_invoice_pdf = $invoice_details->invoice_pdf;
                $name = auth()->user()->first_name . ' ' . auth()->user()->last_name;
                // send mail for user's email to get activation and payment done
               
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
            // 
            if($subscription_update_response->status == 'active'){
              $membership_payment->payment_status = 'succesfull';
              try {
                $mail = Mail::to(auth()->user()->email)->send(new HostMembershipUpdateMail($name , $membership_details['name'], $host_inovice_url , $host_invoice_pdf,'success'));
              } catch (\Throwable $th) {
              }
               
            }else{
              $membership_payment->payment_status = $subscription_update_response->status;
              try {
                $mail = Mail::to(auth()->user()->email)->send(new HostMembershipUpdateMail($name , $membership_details['name'], $host_inovice_url , $host_invoice_pdf,'pending'));
              } catch (\Throwable $th) {
              }
               
            }
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
                'metadata' => [
                  'update_type' => 'manual_update',
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
                if($subtotal < 0){
                  $subtotal = 0;
                }
                $payment_intent = $invoice_details->payment_intent;
                $host_inovice_url = $invoice_details->hosted_invoice_url;
                $host_invoice_pdf = $invoice_details->invoice_pdf;
                $name = auth()->user()->first_name . ' ' . auth()->user()->last_name;
                // send mail for user's email to get activation and payment done
               
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

            if($subscription_update_response->status == 'active'){ // status is active then payment must be succesfully done .
              $membership_payment->payment_status = 'succesfull';
               $mail = Mail::to(auth()->user()->email)->send(new HostMembershipUpdateMail($name , $membership_details['name'], $host_inovice_url , $host_invoice_pdf,'success'));
            }else{
              $membership_payment->payment_status = $subscription_update_response->status;
               $mail = Mail::to(auth()->user()->email)->send(new HostMembershipUpdateMail($name , $membership_details['name'], $host_inovice_url , $host_invoice_pdf,'pending'));
            }
          
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
        $error = $e->getMessage();
        return redirect()->back()->with('error',$error);
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
      $user = User::find(auth()->user()->id);
      if($stripe_cancelation->status == 'canceled' ){
       $subscription_update = HostSubscriptions::where('host_id' , auth()->user()->id)->update(['subscription_status'=>$stripe_cancelation->status]);
        $user->active_status = 0;
        $user->update();
      }
      $mailData = [
        'user' => $user,
        'subscription' => $subscription_update
      ];
      try {
        $mail = Mail::to($user->email)->send(new Host_cancel_subscription($mailData));
      } catch (\Throwable $th) {
      }
      
      return redirect()->back()->with('success','You have succesfully canceled your subscription');
    }
    public function pauseSubscription(Request $req){
      // return $req;
      $subscription_id = auth()->user()->subscription_id;

      $stripe = new \Stripe\StripeClient(env('STRIPE_SEC_KEY'));
      $pause_status = $stripe->subscriptions->update(
        $subscription_id,
        [
          'pause_collection' => ['behavior' => 'void'],
          'cancel_at_period_end' => true,
        ]
      );
      
      $host_update = HostSubscriptions::where('host_id' , auth()->user()->id)->update(['subscription_status' => 'paused']);
     
    
      // dd($host_update);
      return redirect()->back()->with('success','You have succesfully paused your subscription');
    }
    public function resumeSubscription(Request $req){
      $subscription_id = auth()->user()->subscription_id;
      $stripe = new \Stripe\StripeClient(env('STRIPE_SEC_KEY'));
      $resume_status = $stripe->subscriptions->update(
        $subscription_id,
        [
          'pause_collection' => '',
          'cancel_at_period_end' => false,
        ]
      );
      HostSubscriptions::where('host_id' , auth()->user()->id)->update(['subscription_status'=>'active']);
      return redirect()->back()->with('success','You have succesfully resumed your subscription');
    }  
    public function subscribeResponse(){
      return view('Host.membership.subscribe_response');
    }
}
