<?php

namespace App\Http\Controllers\LiveStream;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Twilio\Jwt\AccessToken;
use Twilio\Jwt\Grants\VideoGrant;
use Twilio\Jwt\Grants\SyncGrant;
use Twilio\Jwt\Grants\ChatGrant;
use App\Models\HostAppointments;
use App\Events\SendStreamPaymentRequest;
use App\Models\User;
use App\Models\StreamPayment;
use App\Models\Discounts\HostDiscount;

class VedioCallController extends Controller
{
    //
    public function index(Request $req){
        $roomName = $req->segment(2);
        $appoinment_details = HostAppointments::where('video_link_name',$roomName)->first();
        $stripe = new \Stripe\StripeClient(env('STRIPE_SEC_KEY'));
        $setup_intent = $stripe->setupIntents->create();
        $client_secret = $setup_intent->client_secret;
        // dd($appoinment_details['stripe_client_secret']);
        return view('vediocall.vediocall',compact('roomName','appoinment_details','client_secret'));

    }
    public function passToken(Request $req){
        // dd($req);
  
        $identity = '';
        if(isset(auth()->user()->email)){
            $identity =  auth()->user()->email;
        }else{
            $identity = $req->ip();
        }
       
        // if (isset($_GET['identity'])) {
        //     $identity = $_GET['identity'];
        // }
        
        // if (empty($identity)) {
        //     // choose a random username for the connecting user (if one is not supplied)
        //     $identity = randomUsername();
        // }
        
        // Create access token, which we will serialize and send to the client
        $token = new AccessToken(
            env('TWILIO_ACCOUNT_SID'),
            env('TWILIO_API_KEY'),
            env('TWILIO_API_SECRET'),
            3600,
            $identity
        );
        
        // Grant access to Video
        $grant = new VideoGrant();
        $token->addGrant($grant);
        
        // Grant access to Sync
        $syncGrant = new SyncGrant();
        if (empty(env('TWILIO_SYNC_SERVICE_ID'))) {
            $syncGrant->setServiceSid('default');
        } else  {
            $syncGrant->setServiceSid(env('TWILIO_SYNC_SERVICE_ID'));
        }  
        $token->addGrant($syncGrant);
        
        // // Grant access to Chat
        // if (!empty($_ENV['TWILIO_CHAT_SERVICE_SID'])) {
        //     $chatGrant = new ChatGrant();
        //     $chatGrant->setServiceSid($_ENV['TWILIO_CHAT_SERVICE_SID']);
        //     $token->addGrant($chatGrant);
        // }
        
        
        // return serialized token and the user's randomly generated ID
   
       $data = array(
            'identity' => $identity,
            'token' => $token->toJWT(),
        );
        
        return response()->json($data);
    }
    public function pingForPayment(Request $req){
        $host = User::find($req->host_id);
        $host_first_name = $host['first_name'];
        $host_last_name = $host['last_name'];
        $host_full_name = $host_first_name . ' ' . $host_last_name;
        $request_message = "You have to pay ". $req->amountForStream."(".$req->currency.")" . " for " . $host_full_name . " for further session";
        // Create payment intent and pass to guest for payment
        // $stripe = new \Stripe\StripeClient(env('STRIPE_SEC_KEY'));
        // $stripe_payment_intent =  $stripe->paymentIntents->create([
        //     'amount' => $req->amountForStream,
        //     'currency' => $req->currency,
        //     'automatic_payment_methods' => [
        //       'enabled' => true,
        //     ],
        //   ]);
        // return $stripe_payment_intent;
        // ($stream_amount,$currency,$appointment_id,$host_id,$message)
        $test_event = event( new SendStreamPaymentRequest($req->amountForStream,$req->currency,$req->appointment_id,$request_message));
    }
    public function vedioCallPayment(Request $req){
        //  create payment intent 
        try{
            $stripe = new \Stripe\StripeClient(env('STRIPE_SEC_KEY'));

            // Create customer 
            $customer =  $stripe->customers->create([
                'name' => auth()->user()->first_name, // req -> name
                'email' => auth()->user()->email, // req-> email
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

            $stripe_payment_intent =  $stripe->paymentIntents->create([
                'customer' => $customer->id,
                'amount' => (int)$req->payment_amount * 100,
                'currency' => $req->currency,
                'payment_method' => $req->token,
                'off_session' => true,
                'confirm' => true,
                'description' => 'appointment charges'
            ]);
            // dd($stripe_payment_intent);
            if($stripe_payment_intent->status == 'succeeded'){
               
                //appointement id payment status update
                    $streamPayment = new StreamPayment;
                    $streamPayment->stripe_payment_intent = $stripe_payment_intent['id'];
                    $streamPayment->stripe_payment_method = $req->token;
                    $streamPayment->currency = $req->currency;
                    $streamPayment->subtotal = $req->subtotal;
                    $streamPayment->coupon_code = $req->discount_code;
                    $streamPayment->discount_amount = $req->discount_amount;
                    $streamPayment->total = $req->subtotal - $req->discount_amount;
                    $streamPayment->appoinment_id = $req->appoinment_id;
                    $streamPayment->host_id = $req->host_id;
                    $streamPayment->save();

                    //discount_code 
                    $discount_amount = $req->discount_amount;
                    $coupon_code = $req->discount_code;
                    $user_create = $this->coupon_update($discount_amount,$coupon_code);

                    //appoinment
                    $appoinments = HostAppointments::find($req->appoinment_id);
                    $appoinments->payment_status = 1;
                    $appoinments->update();
                    return redirect()->back()->with('success','your payment is successful');

            }
            // return "outside the condition";
        }catch(\Exception $e){
            $error = $e->getMessage();
        }
        // print_r($error);
        // print_r($stripe_payment_intent['id']);
    }
    public function CouponCheck(Request $req){
        $date = date('Y-m-d');
        $discounts = HostDiscount::where([['coupon_code',$req->coupon_code],['host_id',$req->host_id]])->first();
        if(!empty($discounts)){
            if($discounts->status == 1){
                if($discounts->expiredate >= $date){
                    if($discounts->duration == 'Once'){
                        $status = true;
                        $discount_amount = $discounts->percentage_off;
                        $response = 'discount coupon is valid';
                    }elseif($discounts->duration == 'Repeating'){
                        if($discounts->duration_times > 0){
                            $status = true;
                            $discount_amount = $discounts->percentage_off;
                            $response = 'discount coupon is valid';
                        }else{
                            $status = false;
                            $discount_amount = 0;
                            $response = 'This discount code is expired';
                        }
                    }elseif($discounts->duration == 'Forever'){
                        $status = true;
                        $discount_amount = $discounts->percentage_off;
                        $response = 'discount coupon is valid';
                    }   
            }else{
                $status = false;
                $discount_amount = 0;
                $response = 'This discount code is expired';
            }
               
             }else{
         $status = false;
        $discount_amount = 0;
        $response = 'This discount code is expired';
    } 

        }else{
            $status = false;
            $discount_amount = 0;
            $response = 'This coupon code is invalid';
        }
        if($discount_amount == 0){
            $final_discount = 0;
            $total_amount = $req->amount;
        }else{
    $final_discount = $req->amount*$discount_amount/100;
    $total_amount = $req->amount - $final_discount;
        }
    // $data = array($status,$discount_amount , $response);
    $data = array(
        'status' => $status,
        'coupon_code' => $req->coupon_code,
        'discount_amount' => $final_discount,
        'total_amount' => $total_amount,
        'response' => $response,
    );
        return response()->json($data);

    }
    public function coupon_update($discount_amount,$coupon_code){
        if($discount_amount != 0){
        $discount_coupon_code = HostDiscount::where('coupon_code',$coupon_code)->first();
        // echo $discount_coupon_code->duration;
        if($discount_coupon_code->duration == 'Once'){
            // echo 'done';
            // print_r($discount_coupon_code->id);
            $update = HostDiscount::find($discount_coupon_code->_id);
            $update->status = 0;
            $update->update();
        }elseif($discount_coupon_code->duration == 'Repeating'){
            $update = HostDiscount::find($discount_coupon_code->_id);
            $update->duration_times = $discount_coupon_code->duration_times-1;
            $update->update();
        }else{
            $update = HostDiscount::find($discount_coupon_code->_id);
            $update->coupon_used = $discount_coupon_code->coupon_used+1;
            $update->update();
        }
        }
    }
}
