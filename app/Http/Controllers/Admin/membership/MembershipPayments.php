<?php

namespace App\Http\Controllers\Admin\membership;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MembershipPaymentsData;

class MembershipPayments extends Controller
{
    public function membershipPaymentList(){

        $membership_payments_list = MembershipPaymentsData::with(['user' => function($response){
            $response->select('first_name','last_name','membership_id','unique_id');
        }])->orderBy('created_at','DSC')->get();

        // dd($membership_payments_list);

        return view('Admin.payment-collection.membership_payment',compact('membership_payments_list'));
    }
}
