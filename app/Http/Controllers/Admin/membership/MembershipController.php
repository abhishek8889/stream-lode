<?php

namespace App\Http\Controllers\Admin\membership;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MembershipTier;
use App\Models\MembershipFeature;
use stripe;
use File;
use DB;

class MembershipController extends Controller
{
    //
    public function index(){
        $membership_details = DB::table('membership')->get();
        // dd($membership_details);
        return view('Admin.membership.index',compact('membership_details'));
    }
    public function addMembershipTier(){
        $features = MembershipFeature::get();
        return view('Admin.membership.add_membership_tier',compact('features'));
    }
    public function addMembershipTierProc(Request $req){
        $membership = new MembershipTier;
        // $membership_logo_name = '';
        // $membership_logo_url = '';

        // if($req->hasfile('card_logo')){
        //     $file = $req->file('card_logo');
        //     $name = time().rand(1,100).'.'.$file->extension();
        //     $file->move(public_path().'/Assets/images/membership-logo/', $name);
        //     $membership_logo_name = $name;
        //     $membership_logo_url = asset('Assets/images/membership-logo/'.$name);
        // }
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
        // $membership->logo_name =  $membership_logo_name;
        // $membership->logo_url =   $membership_logo_url;
        $membership->currency = $req->currency_code;
        $membership->type = $req->membership_type;
        if($req->membership_type == 'recurring'){
            $membership->interval =  $req->interval_time;
        }
        $membership->amount = $req->price;
        $membership->membership_features = $req->membership_fetaures;
        $membership->status = 1; // 1 by default 1 (active) & 0 (inactive)
        if(!isset($req->description) || empty($req->description)){
            $membership->description = '';
        }else{
            $membership->description = $req->description;
        }
        $membership->save();

        return redirect(url('/admin/add-membership-tier'))->with('success','You have succesfully create a new membership tier');
    }

    public function edit($slug){
        
        $membership_data = MembershipTier::where('slug',$slug)->first();
        $features = MembershipFeature::get();
       
        return view('Admin.membership.edit_membership_tier',compact('membership_data','features'));

    }
    // public function editproc(Request $req){
    //     print_r($req->all());

    // }


    // update stripe product 
    public function updateMembership(Request $req){
        // dd($req->all());
        $req->validate([
            'membership_fetaures' => 'required',
            'description' => 'required'
        ]);
        $data = MembershipTier::find($req->id);
        // print_r($data);
        $data->membership_features = $req->membership_fetaures;
        $data->description = $req->description;
        
        $data->update();
        return back()->with('success','successfully updated data');

    //    dd($req->all());
    //    $membership_tier_id = MembershipTier::find($req->id)->membership_tier_id;
    //    echo $membership_tier_id;
    //     $stripe = new \Stripe\StripeClient( env('STRIPE_SEC_KEY') );
        //   dd($stripe);
        //   $stripe->products->update(
        //     'prod_NEBnBQa9OtMGKf',
        //     ['metadata' => ['order_id' => '6735']]
        //   );
    }
    public function deleteMembership(Request $req , $id){
        // echo $id;
        $membership_db = MembershipTier::where('_id',$id)->first();
        $stripe_product_id = $membership_db['membership_tier_id'];
        $stripe_product_price_id = $membership_db['price_id'];
        // dd($stripe_product_id);
       
        $stripe = new \Stripe\StripeClient( env('STRIPE_SEC_KEY') );

        // Archiving price 

        $price_status = $stripe->prices->update($stripe_product_price_id, ['active' => false]);
     
        // $delete_status = $stripe->products->delete( $stripe_product_id,[]);
        // dd($delete_status);
        $membership_db->status = 0;
        $membership_db->update();
        return redirect(url('/admin/membership-list'))->with('success','You have succesfully deactivate membership tier.');

    }
    public function activateMembership(Request $req , $id){
        $membership_db = MembershipTier::where('_id',$id)->first();
        $stripe_product_id = $membership_db['membership_tier_id'];
        $stripe_product_price_id = $membership_db['price_id'];
        // dd($stripe_product_id);
       
        $stripe = new \Stripe\StripeClient( env('STRIPE_SEC_KEY') );

        // Archiving price 
        $price_status = $stripe->prices->update($stripe_product_price_id, ['active' => true]);
     
        // $delete_status = $stripe->products->delete( $stripe_product_id,[]);
        // dd($delete_status);
        $membership_db->status = 1;
        $membership_db->update();
        return redirect(url('/admin/membership-list'))->with('success','You have succesfully activate membership tier.');

    }
}
