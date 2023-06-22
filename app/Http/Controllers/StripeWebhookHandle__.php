<?php

namespace App\Http\Controllers;
use App\Mail\HostSubscriptionRenewStatus;
use Illuminate\Http\Request;
use Stripe\Event;
use Mail;
use Illuminate\Support\Facades\Log;

class StripeWebhookHandle extends Controller
{
    //
    // public function index(Request $request){
    //     $payload = $request->all();
    //     $event = Event::constructFrom($payload);

    //     // // Handle the specific event type
    //     // // if ($event->type === 'invoice.payment_succeeded') {
    //     // //     // Handle the subscription payment success event
    //     // //     // You can perform actions here, such as sending notifications or updating your database
    //     // // }
    //     // // if()
    //     $email = 'developer.ashar@gmail.com';
    //     $name = 'abhishek';
    //     $status = 'succesfull';
    //     Mail::to($email)->send(new HostSubscriptionRenewStatus($name,$status));
    //     return response('Webhook Handled', 200);
        
    // }
    // public function checkPostMethod(Request $req){
    //     $email = 'developer.ashar@gmail.com';
    //     $name = 'abhishek';
    //     $status = 'succesfull';
    //     Mail::to($email)->send(new HostSubscriptionRenewStatus($name,$status));
    //     return "Mail sent to developer";
    // }

    public function handle(Request $req){
        
        Log::debug('checking log 123',$req->all());
        return "hello";
    }
}
