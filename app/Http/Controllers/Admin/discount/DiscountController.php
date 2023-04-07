<?php

namespace App\Http\Controllers\Admin\discount;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Discounts\AdminDiscount;

class DiscountController extends Controller
{
    public function index(){
       
        return view('Admin.discount.index');
    }
   
    public function discountList(){
        $discount_list = AdminDiscount::paginate(8);
        // dd($discount_list);
        return view('Admin.discount.discount_list',compact('discount_list'));
    }
    public function createDiscount(Request $req){
        // dd($req);
        $stripe = new \Stripe\StripeClient( env('STRIPE_SEC_KEY') );
        $validate = $req->validate([
            'name' => 'required',
        ]);
        // add coupon code
        $coupon_name = $req->name;
        $amount = null;
        $type = $req->discount_type;

        if($req->discount_type == 'amount_off'){
            $amount = $req->amount_off;
        }
        if($req->discount_type == 'percent_off'){
            $amount = $req->percent_off;
        }

        $coupon_response = '';

        if($req->duration == 'repeating'){
            if($req->discount_type == 'amount_off'){
                $coupon_response = $stripe->coupons->create([
                    'name' => $coupon_name,
                    $type => (int)$amount*100,
                    'currency' => $req->currency,
                    'duration' => 'repeating',
                    'duration_in_months' => $req->duration_in_months,
                  ]);

            }else{
                $coupon_response = $stripe->coupons->create([
                    'name' => $coupon_name,
                    $type => $amount,
                    'duration' => 'repeating',
                    'duration_in_months' => $req->duration_in_months,
                  ]);
            }
        }else{
            if($req->discount_type == 'amount_off'){
                $coupon_response = $stripe->coupons->create([
                    'name' => $coupon_name,
                    $type => (int)$amount * 100,
                    'currency' => $req->currency,
                    'duration' => $req->duration,
                ]);

            }else{
                $coupon_response = $stripe->coupons->create([
                    'name' => $coupon_name,
                    $type => $amount,
                    'duration' => $req->duration,
                ]);
            }
        }
        $discount = new AdminDiscount;
        $discount->coupon_name = $coupon_name;
        $discount->coupon_code = $req->coupon_code;
        $discount->stripe_coupon_id = $coupon_response->id;
        $discount->discount_type = $type;
        $discount->percent_off = $req->percent_off;
        $discount->amount_off = $req->amount_off;
        $discount->currency = $req->currency;
        $discount->duration = $req->duration;
        $discount->duration_in_months = $req->duration_in_months;
        $discount->status = 1;
        $discount->save();
        return redirect()->back()->with('success','Discount coupon created succesfully.');
   
    }
    public function delete($id){
        // echo $id;
        $stripe = new \Stripe\StripeClient( env('STRIPE_SEC_KEY') );
        $coupon = AdminDiscount::find($id);
        $stripe->coupons->delete($coupon['stripe_coupon_id'], []);
        $coupon->delete();
        return redirect()->back()->with('success','Successfully deleted coupon');
    }
    public function update($id){
    $coupondata = AdminDiscount::find($id);
    return view('Admin.discount.edit_discount',compact('coupondata'));    
    }
   
}
