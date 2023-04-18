<?php

namespace App\Http\Controllers\Hosts;
use App\Http\Controllers\Controller;
use App\Http\Controllers\MainController;
use Illuminate\Http\Request;
use DateTime;
use App\Models\HostStripeAccount;
use Mail;
use App\Mail\HostStripeRegisterTermsOfService;
use Auth;
class HostStripeAccountRegisteration extends Controller
{
    
    public function index(){
        return view('Host.register-account.index');
    }
    public function registerAccount(Request $req){
    //    return $req;
       $validated =  $req->validate([
        ////////  Personal Details : ////////////
            'first_name' => 'required',
            'last_name' => 'required',
            'dob' => 'required',
            'personal_contact' => 'required',
            'city' => 'required',
            'line1' => 'required',
            'state' => 'required',
            'ssn' => 'required',
            'postal_code' => 'required',
        ////////  Business Details : ////////////
            'email' => 'required',
            'business_phone' => 'required',
            // 'business_site' => 'required',
            'mcc' => 'required',
            'country' => 'required',
        //////// Bank Details /////////////////
            'account_holder_name' => 'required',
            'bank_acc_number' => 'required',
            'acc_routing_num' => 'required',
            'bank_acc_region' => 'required',
            'region_currency' => 'required',
        ],[
            'first_name.required' =>'First name is required',
            'last_name.required' =>'Last name is required',
            'dob.required' => 'Date of birth is required',
            'personal_contact.required' => 'Personal contact number is required',
            'city.required' => 'City is required',
            'line1.required' => 'Street/Line address is required',
            'state.required' => 'State is required',
            'ssn.required' => 'SSN is requird',
            'postal_code.required' => 'Postal Code is required',
            'email.required' => 'Email is required',
            'business_phone.required' => 'Business phone is required',
            // 'business_site.required' => 'Business site is required',
            'mcc.required' =>'MCC is required',
            'country.required' => 'Country is required',
            'account_holder_name.required' => 'Account holder name is required',
            'bank_acc_number.required' => 'Bank account number is required',
            'acc_routing_num.required' => 'Routing number is required',
            'bank_acc_region.required' => 'Bank region is required',
            'region_currency.required' => 'Region Currency is required',
        ]
        );
        $dob = explode("-",$req->dob);
        $date = $dob[2];
        $year = $dob[0];
        $month = $dob[1];
        $stripe = new \Stripe\StripeClient(env('STRIPE_SEC_KEY'));

        // Express type account : 

        ////////////////////////////////////////////////////////////////
        /////////////////////  Custom Type Account  ////////////////////
        ////////////////////////////////////////////////////////////////

        $stripe_acc_create = $stripe->accounts->create([
            'type' => 'express',
            'country' => $req->country,
            'email' => $req->email,
            'external_account' =>[
                'object' => 'bank_account',
                'country' => $req->bank_acc_region,
                'currency' => $req->region_currency,
                'account_holder_name' => $req->account_holder_name,
                'routing_number' => $req->acc_routing_num,
                'account_number' => $req->bank_acc_number,
            ],
            'capabilities' => [
                'card_payments' => ['requested' => true],
                'transfers' => ['requested' => true],
            ],
            'business_type' => 'individual',
            'business_profile' => [
                'product_description' => 'Provide Stream Time',
                'support_phone' => $req->business_phone,
                'url' => $req->business_site,
                'mcc' => $req->mcc, // 8011
            ],
            'individual' =>[
                'address' => [
                    'city' => $req->city,               //Crane Hill
                    'line1' =>  $req->line1,            //242 County Rd #223
                    'postal_code' => $req->postal_code, //35053
                    'state' => $req->state,             //Alabama
                ],
                'first_name' => $req->first_name,
                'last_name' => $req->last_name,
                'dob' => [
                    'day' => $date,
                    'month' => $month, 
                    'year' => $year,
                ],
                'email' => $req->email,
                'phone' => $req->personal_contact,  //5555551234
                'ssn_last_4' => $req->ssn,          //0000
            ],
        ]);
        if(!empty($stripe_acc_create->id)){
            $link_acount = $stripe->accountLinks->create([
                'account' => $stripe_acc_create->id,
                'refresh_url' => url('/'.auth()->user()->unique_id.'/register-account'),
                'return_url' => url('/'.auth()->user()->unique_id),
                'type' => 'account_onboarding',
            ]);
            if($link_acount->url){
                $name = $req->first_name . ' '. $req->last_name;
                $mail = Mail::to(auth()->user()->email)->send(new HostStripeRegisterTermsOfService($name , $link_acount->url));
            }
            // Add data in database
            $host_stripe_data = new HostStripeAccount;
            $host_stripe_data->host_id = auth()->user()->id;
            $host_stripe_data->stripe_account_num = $stripe_acc_create->id ;
            $host_stripe_data->first_name = $req->first_name ;
            $host_stripe_data->last_name = $req->last_name ;
            $host_stripe_data->dob = $req->dob ;
            $host_stripe_data->personal_contact = $req->personal_contact ;
            $host_stripe_data->city = $req->city ;
            $host_stripe_data->line1 = $req->line1 ;
            $host_stripe_data->state = $req->state ;
            $host_stripe_data->ssn = $req->ssn ;
            $host_stripe_data->postal_code = $req->postal_code ;
            $host_stripe_data->email = $req->email ;
            $host_stripe_data->business_phone = $req->business_phone ;
            $host_stripe_data->mcc = $req->mcc ;
            $host_stripe_data->country = $req->country ;
            $host_stripe_data->account_holder_name = $req->account_holder_name ;
            $host_stripe_data->bank_acc_number = $req->bank_acc_number ;
            $host_stripe_data->acc_routing_num = $req->acc_routing_num ;
            $host_stripe_data->bank_acc_region = $req->bank_acc_region ;
            $host_stripe_data->region_currency = $req->region_currency ;
            $host_stripe_data->active_status = 'false';
            $host_stripe_data->save();
            return redirect($link_acount->url);
            return redirect()->back()->with('success','Please check your registered email for acceptance of terms of service and activate your account.');
        }else{
            return redirect()->back()->with('error','Please try again there is something error.');
        }     
    }
    public function getClientIp(){
        $ipaddress = '';
        if (env('HTTP_CLIENT_IP'))
            $ipaddress = env('HTTP_CLIENT_IP');
        else if(env('HTTP_X_FORWARDED_FOR'))
            $ipaddress = env('HTTP_X_FORWARDED_FOR');
        else if(env('HTTP_X_FORWARDED'))
            $ipaddress = env('HTTP_X_FORWARDED');
        else if(env('HTTP_FORWARDED_FOR'))
            $ipaddress = env('HTTP_FORWARDED_FOR');
        else if(env('HTTP_FORWARDED'))
            $ipaddress = env('HTTP_FORWARDED');
        else if(env('REMOTE_ADDR'))
            $ipaddress = env('REMOTE_ADDR');
        else
            $ipaddress = 'UNKNOWN';
        return $ipaddress;
    }
    public function editAccount(){
        return "here we edit the host stripe account ";
    }
}
