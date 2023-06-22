<?php

namespace App\Http\Controllers\Admin\membership;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\HostRefundMail;
use App\Models\MembershipPaymentsData;
use App\Models\User;

class MembershipPayments extends Controller
{
    public function membershipPaymentList(){
    
        // $membership_payments_list = MembershipPaymentsData::with(['user' => function($response){
        //     $response->select('first_name','last_name','membership_id','unique_id');
        // }])->orderBy('created_at','DSC')->select()->get();
        // dd($membership_payments_list);
        // $membership_payments_list = array();

        $membership_payments = MembershipPaymentsData::get();
        $user_id = array();
        foreach($membership_payments as $mp){
            array_push($user_id,$mp->user_id);
        }
       $id = array_unique($user_id);
    //    dd($id);
        if($id){
        foreach($id as $id){
        $membership_payments_list[] = User::where('_id',$id)->with(['payments' => function($response){ $response->orderBy('created_at','DSC'); } ])->get();
        }
        }else{
        $membership_payments_list = array();
        }
      
        return view('Admin.payment-collection.membership_payment',compact('membership_payments_list'));
    }
    public function membershipPaymentDetails(Request $req , $unique_id){
        // return $id;
        $user_id = User::where('unique_id',$unique_id)->get()->value('id');
       
        $membership_payments_details = MembershipPaymentsData::where('user_id',$user_id)->with(['user'=>function($response){
            $response->select('first_name','last_name','unique_id','email','active_status');
        },'membership_details'=>function($response){
            $response->select('name','type','interval','amount','description');
        },'payments_method'=>function($response){
            $response->select('brand','last_4');
        }])->orderBy('created_at','DSC')->get();
        // dd($membership_payments_details);
       
        return view('Admin.payment-collection.membership_payment_detail',compact('membership_payments_details'));
    }
    public function refund(Request $req){
        // return $req->id;
        try{
            $membership_payment_data = MembershipPaymentsData::where('_id',$req->id)->with([
                'user' => function($response){
                    $response->select('first_name','last_name','email');
                },'membership_details' => function($response){
                    $response->select('name');
                }
            ])->first();
            // dd($membership_payment_data);
            $host_email = $membership_payment_data->user['email'];
            $host_name = $membership_payment_data->user['first_name'] . ' ' .$membership_payment_data->user['last_name']; 
            $host_membership_tier = $membership_payment_data->membership_details['name'];
            $order_id = $membership_payment_data['order_id'];
            $amount = $membership_payment_data['total'];

            
            $payment_intent = $membership_payment_data->stripe_payment_intent;
            $stripe = new \Stripe\StripeClient(env('STRIPE_SEC_KEY'));
            $refund_response = $stripe->refunds->create([
                'payment_intent' => $payment_intent,
            ]);
            // dd($amount);
            if($refund_response->status == 'succeeded'){
                $membership_payment_data->refund_status = 1;
                $membership_payment_data->stripe_refund_id = $refund_response->id;
                $membership_payment_data->update();
                $refund_email_status = Mail::to($host_email)->send(new HostRefundMail($host_name,$host_membership_tier,$order_id,$amount));           
                return redirect()->back()->with('success','You have successfully refunded the $'. $amount. ' to '.$host_name );
            }else{
                return redirect()->back()->with('error','Sorry there is some error in system.');
            }
        }catch(\Exception $e){
            $stripe_error_code = $e->getStripeCode();
            if($stripe_error_code == 'charge_already_refunded'){
                return redirect()->back()->with('error','This charge is already refunded');  
            }
            return redirect()->back()->with('error',$e->getMessage());  
        }
    }
    public function search(Request $req){
        $full_name = explode(" ", $req->val);
                $count = count($full_name);
                 if($count < 2){
                    $hosts = User::orWhere('first_name','like',$req->val.'%')->where('status',1)->where('public_visibility',1)->orWhere('last_name','like',$req->val.'%')->with('payments','payments.membership_details')->get();
                }else{
                 $hosts = User::orWhere([['first_name','like',$full_name[0]],['last_name','like',$full_name[1].'%']])->orWhere('first_name',$req->val)->where('status',1)->where('public_visibility',1)->with('payments','payments.membership_details')->get();
                 } 

        return response()->json($hosts);

    }
}
