<?php

namespace App\Http\Controllers\Admin\membership;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use stripe;

class MembershipController extends Controller
{
    //
    public function index(){
        $stripe = new \Stripe\StripeClient( env('STRIPE_SEC_KEY') );
        $membership_details =  $stripe->products->retrieve(
            'prod_NDpSRoCyCeRkkg',
            []
          );
        $price =   $stripe->prices->retrieve(
            'price_1MTNnYSDpE15tSXhXY4wwoYK',
            []
          );
          dd($price);
        return view('Admin.membership.index');
    }
    public function addMembershipTier(){
        return view('Admin.membership.add_membership_tier');
    }
    public function addMembershipTierProc(Request $req){
        // return $req->all();
        $stripe = new \Stripe\StripeClient( env('STRIPE_SEC_KEY') );
        $stripe->products->create([
            'name' => $req->name,
            // 'images' => $req->card_logo
            "default_price_data" => [
                'unit_amount' => $req->price * 100,
                'currency' => 'USD',
            ],
            // 'recurring' => [
            //     'interval_count' => 'month',
            // ],
            'description' => $req->description,
          ]);
          return redirect(url('/admin/add-membership-tier'))->with('success','You have succesfully create a new membership tier');
    }
}
