<?php

namespace App\Http\Controllers\Hosts;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PaymentMethods;
use App\Models\StreamPayment;

class HostPaymentMethodsController extends Controller
{
    //
    public function index(){
        $payment_methods = PaymentMethods::where('user_id',auth()->user()->id)->get();
        return view('Host.payment-methods.index',compact('payment_methods'));
    }
    public function deletePaymentMethod(Request $req){
        $payment_method = PaymentMethods::where('_id',$req->id)->first();
        $stripe_payment_method = $payment_method['stripe_payment_method'];
        
        $stripe = new \Stripe\StripeClient(env("STRIPE_SEC_KEY"));
        $delete_status = $stripe->paymentMethods->detach($stripe_payment_method, []);
    
        $payment_method->delete();
        return redirect()->back()->with('success','Your card is succesfully deleted');
    }
    public function streampayments(){
        $stream_payments = StreamPayment::where('host_id',Auth()->user()->id)->with('appoinments')->orderBy('created_at','DSC')->paginate(10);
        return view('Host/payment-methods.stream_payments',compact('stream_payments'));
    }
}
