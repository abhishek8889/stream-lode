<?php

namespace App\Http\Controllers;
use App\Mail\HostSubscriptionRenewStatus;
use Illuminate\Http\Request;
use Stripe\Event;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use App\Models\HostSubscriptions;
use App\Models\MembershipPaymentsData;
use App\Models\PaymentMethods;
use App\Models\MembershipTier;
use App\Models\User;
class StripeWebhookHandle extends Controller
{
    public function index(){
        $end_point_secret = env('STRIPE_WEBHOOK_SECRET');
        $payload = @file_get_contents('php://input');
        $sig_header = $_SERVER['HTTP_STRIPE_SIGNATURE'];
        // $recieve_data = [
        //     'payload' => [$payload],
        //     'header' => [$_SERVER],
        //     'stripe-signature' => [$sig_header],
        // ];
        try {
            $event = \Stripe\Webhook::constructEvent($payload, $sig_header, $end_point_secret);
    
            $metadata = $event->data->object->metadata;
            $subscription_id = $event->data->object->id;
            $update_type = $metadata['update_type'];
            $host_subscription = HostSubscriptions::where('stripe_subscription_id',$subscription_id)->first();
            $object_created = date('Y-M-d H:i' ,$event->created);
            
            if($host_subscription->next_invoice_generate_on <= $object_created){
                $host = User::find($host_subscription->host_id);
                $stripe = new \Stripe\StripeClient(env('STRIPE_SEC_KEY'));
                // $subscription = $stripe->subscriptions->retrieve(
                //     $subscription_id,
                //     []
                // );
             
                $defaultPaymentMethodId = $event->data->object->default_payment_method; // can take customer object and its default payment method: 
                
                // ################### invoice details  ###################
                $invoice = $event->data->object->latest_invoice;
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
                }
                
                $str_result = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz01235675854abcdefghjijklmnopqrst';
                $random_order_number = substr(str_shuffle($str_result),0,7);

                // Get Payment intent object for payment method: 
                    $stripe_payment_method = '';
                    $payment_method = '';
                    $payment_method_id = '';
                if(isset($payment_intent)){
                    $pi = $stripe->paymentIntents->retrieve(
                        $payment_intent,[]
                    );
                    $stripe_payment_method = $pi->payment_method;

                    $payment_method = PaymentMethods::where('stripe_payment_method',$stripe_payment_method)->first();  // system db 
                    $payment_method_id = $payment_method->id; 
                }
                //  ################### Get membership table   ##############################

                $product_id  = $event->data->object->plan->product;
                $memberhsip = MembershipTier::where('membership_tier_id',$product_id)->first();
                $membership_id = $memberhsip->id;
                // return $membership_id;
                // ######################## Store data in membership payment table ###############################

                $membership_payment = new MembershipPaymentsData;
                $membership_payment->user_id = $host_subscription->host_id;
                $membership_payment->inovice_id = $event->data->object->latest_invoice;
                $membership_payment->stripe_payment_intent = $payment_intent;
                $membership_payment->stripe_payment_method = $stripe_payment_method;
                $membership_payment->payment_method_id = $payment_method_id;
                $membership_payment->order_id = $random_order_number; 
                $membership_payment->membership_id = $membership_id;
                $membership_payment->membership_total_amount = $event->data->object->plan->amount / 100;
                $membership_payment->discount_coupon_name = null;
                $membership_payment->subtotal = $subtotal;
                $membership_payment->discount_amount = null ;
                $membership_payment->total = $total_excluding_discount ;
                $membership_payment->payment_type = 'membership_recurring_payment'; 
                $membership_payment->payment_status = 'succesfull';
                $membership_payment->save();

                // Update in host subscription table :

                $host_subscription->subscription_status = $event->data->object->status; // Status
                $host_subscription->membership_payment_id = $membership_payment->id;

                if($event->data->object->status == 'active'){
                    $host_subscription->start_on = date('Y-M-d H:i' ,$event->data->object->current_period_start );
                    $host_subscription->next_invoice_generate_on = date('Y-M-d H:i' ,$event->data->object->current_period_end );
                }else{
                    $host_subscription->start_on = '00-00-00';
                    $host_subscription->next_invoice_generate_on = '00-00-00';
                }
                $host_subscription->update();

                if($event->data->object->status == 'active'){
                    $host_email = $host->email;
                    $host_name = $host->first_name.' '.$host->last_name;
                    Mail::to($host_email)->send(new HostSubscriptionRenewStatus($host_name,$host_inovice_url,$host_invoice_pdf));
                }
                Log::channel('daily')->info('recieved request',array($event));
                return "in condition";
            }else{
                Log::channel('daily')->info('recieved request',array($event));
                return "not in condition";
            }
            // return  'user_id-> '. $host_subscription->host_id . 'inovice_id -> ' .  $event->data->object->latest_invoice . 'stripe_payment_intent -> ' . $payment_intent . 'stripe_payment_method-> ' . $stripe_payment_method . '$payment_method_id -> ' .  $payment_method_id . 'order_id -> ' . $random_order_number . 'membership_id -> ' . $membership_id . '$membership_total_amount -> ' .$event->data->object->plan->amount / 100 . ' event start from fhehf >' . $event ; 
            // return "Data is saved";
        } catch (\Stripe\Exception\SignatureVerificationException $e) {
            return $e->getMessage();
        }
    }
    public function getInvoice($invoice_number){
        $stripe = new \Stripe\StripeClient( env('STRIPE_SEC_KEY') );
        $invoice = $stripe->invoices->retrieve(
         $invoice_number,
          []
        );
        return $invoice;
      }
}
