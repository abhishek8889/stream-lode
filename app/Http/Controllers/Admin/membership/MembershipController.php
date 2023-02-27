<?php

namespace App\Http\Controllers\Admin\membership;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MembershipTier;
use stripe;
use File;
use DB;

class MembershipController extends Controller
{
    //
    public function index(){
        $membership_details = DB::table('membership')->get();
        return view('Admin.membership.index',compact('membership_details'));
    }
    public function addMembershipTier(){
        return view('Admin.membership.add_membership_tier');
    }
    public function addMembershipTierProc(Request $req){
        // dd($req->all());
        $membership = new MembershipTier;
        $membership_logo_name = '';
        $membership_logo_url = '';

        if($req->hasfile('card_logo')){
            $file = $req->file('card_logo');
            $name = time().rand(1,100).'.'.$file->extension();
            $file->move(public_path().'/Assets/images/membership-logo/', $name);
            $membership_logo_name = $name;
            $membership_logo_url = asset('Assets/images/membership-logo/'.$name);
        }
        // dd($membership_logo_url);

        $stripe = new \Stripe\StripeClient( env('STRIPE_SEC_KEY') );

        // Create product //////////////////////////////////
        $product = $stripe->products->create([
            'name' => $req->name,
            'description' => $req->description,
          ]);
        //  Create Price ///////////////////////////////////

        if($req->membership_type == 'recurring'){
            $price = $stripe->prices->create(
                [
                'product' => $product->id,
                'unit_amount' => $req->price * 100,
                'currency' => 'usd',
                    'recurring' => ['interval' => $req->interval_time],
                ]
            );
        }else{
            $price = $stripe->prices->create(
                [
                'product' => $product->id,
                'unit_amount' => $req->price * 100,
                'currency' => $req->currency_code,
                ]
            );
        }
        //save details in membership table 
        $membership->membership_tier_id = $product->id;
        $membership->price_id = $price->id;
        $membership->name =  $req->name;
        $membership->slug = $req->slug;
        $membership->logo_name =  $membership_logo_name;
        $membership->logo_url =   $membership_logo_url;
        $membership->currency = $req->currency_code;
        $membership->type = $req->membership_type;
        if($req->membership_type == 'recurring'){
            $membership->interval =  $req->interval_time;
        }else{
            $membership->type = 'one-time';
        }
        $membership->amount = $req->price;
        $membership->membership_features = json_encode($req->membership_fetaures);
        $membership->status = 1; // 1 by default 1 (active) & 0 (inactive)
        if(!isset($req->description) || empty($req->description)){
            $membership->description = '';
        }else{
            $membership->description = $req->description;
        }
        $membership->save();

        return redirect(url('/admin/add-membership-tier'))->with('success','You have succesfully create a new membership tier');
    }




    // update stripe product 
    // public function updateMembership(Request $req , $id){
       
        // $stripe = new \Stripe\StripeClient(
        //     'sk_test_51LuGMOSDpE15tSXhfthTyVppfb3Y6snN8vGThKZXuUZ4xevUwRpSiTE5sFacZhfTESGQzO3pFrg73muuPHQRZvAa00dv6TTB8y'
        //   );
        //   $stripe->products->update(
        //     'prod_NEBnBQa9OtMGKf',
        //     ['metadata' => ['order_id' => '6735']]
        //   );
    // }
    // public function deleteMembership(Request $req , $id){
    //     $membership_db = DB::table('membership')->where('_id',$id)->first();
    //     $stripe_product_id = $membership_db['membership_tier_id'];
    //     $stripe = new \Stripe\StripeClient( env('STRIPE_SEC_KEY') );
    //     $stripe->products->delete( $stripe_product_id,[]);
    //     $membership_db->delete();
    //     return redirect(url('/admin/membership-list'))->with('success','You have succesfully deleted membership tier.');

    // }
}
