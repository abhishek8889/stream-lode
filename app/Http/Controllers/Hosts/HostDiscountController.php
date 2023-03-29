<?php

namespace App\Http\Controllers\Hosts;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Discounts\HostDiscount;

class HostDiscountController extends Controller
{
    public function index(){
        
        $discount_coupons = HostDiscount::get();
        return view('Host.Discount.index',compact('discount_coupons'));
    }
    public function create($id,$idd = null){
        $coupon_data = HostDiscount::find($idd);
        return view('Host.Discount.createcoupon',compact('coupon_data'));
    }
    public function createproc(Request $req){
        if($req->id == null){
                $req->validate([
                    'coupon_name' => 'required',
                    'coupon_code' => 'required',
                    'percentage_off' => 'required',
                    'duration' => 'required',
                ]);
                $data = new HostDiscount;
                $data->coupon_name = $req->coupon_name;
                $data->coupon_code = $req->coupon_code;
                $data->percentage_off = $req->percentage_off;
                $data->duration = $req->duration;
                $data->duration_times = $req->duration_times;
                $data->status = 1;
                $data->save();
                return redirect()->back()->with('success','Successfully save new coupons');
            }else{
                // print_r($req->all());
                $data = HostDiscount::find($req->id);
                $data->coupon_name = $req->coupon_name;
                $data->coupon_code = $req->coupon_code;
                $data->percentage_off = $req->percentage_off;
                $data->duration = $req->duration;
                $data->duration_times = $req->duration_times;
                $data->status = 1;
                $data->update();
                return redirect()->back()->with('success','Successfully update new coupons');
            }
    }
    public function delete($id, $idd){
        $data = HostDiscount::find($idd)->delete();
        return redirect()->back()->with('success','successfully deleted coupons');
    }
    public function trycode(){
        $discount_code = '#FORE-RD0Q';
        $discounts = HostDiscount::where('coupon_code',$discount_code)->first();
        if(!empty($discounts)){
                if($discounts->status == 1){
                    if($discounts->duration == 'Once'){
                        $discount_amount = $discounts->percentage_off;
                        $response = 'discount coupon is valid';
                    }elseif($discounts->duration == 'Repeating'){
                        if($discounts->duration_times > 0){
                            $discount_amount = $discounts->percentage_off;
                            $response = 'discount coupon is valid';
                        }else{
                            $discount_amount = 0;
                            $response = 'discount coupon is expired';
                        }
                    }elseif($discounts->duration == 'Forever'){
                        $discount_amount = $discounts->percentage_off;
                        $response = 'discount coupon is valid';
                    }
                }else{
                $discount_amount = 0;
                $response = 'discount coupon is expired';  
                }
        }else{
            $discount_amount = 0;
            $response = 'discount coupon is invalid';
        }
        print_r($discount_amount);
        print_r($response);
    }
}
