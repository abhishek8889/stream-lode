<?php

namespace App\Http\Controllers\Hosts;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DateTime;
use App\Models\HostStripeAccount;
class HostStripeAccountRegisteration extends Controller
{
    public function index(){
        return view('Host.register-account.index');
    }
    public function registerAccount(Request $req){
    //    return $req;
    //    $validated =  $req->validate([
    //         'account_holder_name' => 'required',
    //         'email' => 'required',
    //         'business_phone' => 'required',
    //         'business_site' => 'required',
    //         'country' => 'required',
    //         'bank_acc_number' => 'required',
    //         'acc_routing_num' => 'required',
    //         'bank_acc_region' => 'required',
    //         'region_currency' => 'required',
    //         'terms_of_service' => 'accepted',
    //     ],[
    //     'account_holder_name.required' => 'Account holder name is required',
    //     'email.required' => 'Email is required',
    //     'business_phone.required' => 'Business phone is required',
    //     'business_site.required' => 'Business site is required',
    //     'country.required' => 'Country is required',
    //     'bank_acc_number.required' => 'Bank account number is required',
    //     'acc_routing_num.required' => 'Routing number is required',
    //     'bank_acc_region.required' => 'Bank region is required',
    //     'region_currency.required' => 'Region Currency is required',
    //     'terms_of_service.accepted' => 'You have to accept this terms of service for the registeration of your account.',
    //     ]
    //     );
       $timeStamp = '';
       $client_ip = '';
       if($req->terms_of_service == 'on'){
        $now = new DateTime('now');
        $timeStamp = $now->getTimestamp();
        $client_ip = $this->getClientIp();
       }

        $stripe = new \Stripe\StripeClient(env('STRIPE_SEC_KEY'));

        // Express type account : 

        // $stripe_acc_create = $stripe->accounts->create([
        //     'type' => 'express',
        //     'country' => $req->country,
        //     'email' => $req->email,
        //     'external_account' =>[
        //         'object' => 'bank_account',
        //         'country' => $req->bank_acc_region,
        //         'currency' => $req->region_currency,
        //         'account_holder_name' => $req->account_holder_name,
        //         'routing_number' => $req->acc_routing_num,
        //         'account_number' => $req->bank_acc_number,
        //     ],
        //     'capabilities' => [
        //         'card_payments' => ['requested' => true],
        //         'transfers' => ['requested' => true],
        //     ],
        //     'business_type' => 'individual',
        //     'business_profile' => [
        //         'product_description' => 'Provide Stream Time',
        //         'support_phone' => $req->business_phone,
        //         'url' => $req->business_site,
        //     ],
        //     // 'tos_acceptance' => [
        //     //     'date' => time(),
        //     //     'ip' => $_SERVER['REMOTE_ADDR'],
        //     // ],
        //     'settings' => [
        //         'payouts' => [
        //         'schedule' => [
        //             'interval' => 'manual',
        //         ],
        //         ],
        //     ],
        // ]);
        
           ////////////////////////////////////////////////////////////////
          ///////////////////// Custom Type Account //////////////////////
         ////////////////////////////////////////////////////////////////

        $stripe_acc_create = $stripe->accounts->create([
            'type' => 'custom',
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
            ],
            'individual' =>[
                'address' => 'address_full_match',
                'first_name' => 'johny',
                'last_name' => 'walker',
                'dob' => [
                    'day' => 01,
                    'month' => 01 , 
                    'year' => 1901 ,
                ],
                'email' => $req->email,
                'phone' => 5555551234,
                'ssn_last_4' =>0000,
            ]
        ]);
        dd($stripe_acc_create);

        // if($stripe_acc_create->id){
        //     $host_stripe_data = new HostStripeAccount;
        //     $host_stripe_data->host_id = auth()->user()->id;
        //     $host_stripe_data->stripe_account_num = $stripe_acc_create->id ;
        //     $host_stripe_data->linked_bank_acc_num = $req->bank_acc_number ;
        //     $host_stripe_data->acc_routing_number = $req->acc_routing_num ;
        //     $host_stripe_data->account_holder_name = $req->account_holder_name ;
        //     $host_stripe_data->account_holder_email = $req->email ;
        //     $host_stripe_data->business_phone = $req->business_phone ;
        //     $host_stripe_data->business_site = $req->business_site ;
        //     $host_stripe_data->country = $req->country ;
        //     $host_stripe_data->bank_region = $req->bank_acc_region ;
        //     $host_stripe_data->region_currency = $req->region_currency ;
        //     $host_stripe_data->save();
        // }
      
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
