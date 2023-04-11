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

            if($stripe_payment_intent == 'succeeded'){
                //appointement id payment status update

            }
        }catch(\Exception $e){
            $error = $e->getMessage();
        }
        // return redirect()->back()->with('success','your payment is successful');
    }
}
