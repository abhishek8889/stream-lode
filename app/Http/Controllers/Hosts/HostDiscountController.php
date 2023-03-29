<?php

namespace App\Http\Controllers\Hosts;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Discounts\HostDiscount;

class HostDiscountController extends Controller
{
    public function index(){
        
        $discount_coupons = HostDiscount::orderBy('created_at','desc')->get();
        return view('Host.Discount.index',compact('discount_coupons'));
    }
    public function create($id,$idd = null){
        $coupon_data = HostDiscount::find($idd);
        return view('Host.Discount.createcoupon',compact('coupon_data'));
    }
    public function createproc(Request $req){
        $req->validate([
            'coupon_name' => 'required',
            'coupon_code' => 'required',
            'percentage_off' => 'required',
            'duration' => 'required',
        ]);
        // print_r($req->all());
        // echo $req->expiredate;
        $middle = strtotime($req->expiredate);
        $expire_new_date = date('Y-m-d', $middle);
        if($req->id == null){
                $data = new HostDiscount;
                $data->coupon_name = $req->coupon_name;
                $data->coupon_code = $req->coupon_code;
                $data->percentage_off = $req->percentage_off;
                $data->duration = $req->duration;
                if($req->duration == 'Forever'){
                    $data->coupon_used = 0;
                }
                $data->duration_times = $req->duration_times;
                $data->expiredate = $expire_new_date;
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
                if($req->duration == 'Forever'){
                    $data->coupon_used = 0;
                }
                $data->duration_times = $req->duration_times;
                $data->expiredate = $expire_new_date;
                $data->status = 1;
                $data->update();
                return redirect()->back()->with('success','Successfully update new coupons');
            }
    }
    public function delete($id, $idd){
        $data = HostDiscount::find($idd)->delete();
        return redirect()->back()->with('success','successfully deleted coupons');
    }
    public function disable(Request $req){
        if($req->status == 0){
            $data = HostDiscount::find($req->id);
            $data->status = 1;
            $data->update();
        }else{
            $data = HostDiscount::find($req->id);
            $data->status = 0;
            $data->update();
        }
        return response()->json('done');
    }
    public function trycode(){
        $date = date('Y-m-d');
        // print_r($date);
        $amount = 100;
        $discount_code = '#TEST-B3g5';
        $discounts = HostDiscount::where('coupon_code',$discount_code)->first();
        if(!empty($discounts)){
                if($discounts->status == 1){
                    if($discounts->expiredate >= $date){
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
                $response = 'discount is expired ';
            }
        }else{
            $discount_amount = 0;
            $response = 'discount coupon is invalid';
        }
        // print_r($discount_amount.'<br>');
        // print_r($response.'<br>');
        // print_r($discount_code.'<br>');
        if($discount_amount != 0){
            // echo 'done';
        $discunt_coupon_code = HostDiscount::where('coupon_code',$discount_code)->first();
        // echo $discunt_coupon_code->duration;
        if($discunt_coupon_code->duration == 'Once'){
            // echo 'done';
            // print_r($discunt_coupon_code->id);
            $update = HostDiscount::find($discunt_coupon_code->_id);
            $update->status = 0;
            $update->update();
        }elseif($discunt_coupon_code->duration == 'Repeating'){
            $update = HostDiscount::find($discunt_coupon_code->_id);
            $update->duration_times = $discunt_coupon_code->duration_times-1;
            $update->update();
        }else{
            $update = HostDiscount::find($discunt_coupon_code->_id);
            $update->coupon_used = $discunt_coupon_code->coupon_used+1;
            $update->update();
        }
        }
        
        $discount_amounts = $amount*$discount_amount/100;
        $final_amount = $amount-$discount_amounts;
        // print_r($final_amount);

        $result = array(
            'subtotal' => '$'.$amount,
            'coupon_code' => $discount_code,
            'discount_percentage' => '%'.$discount_amount,
            'discount_amount' => '$'.$discount_amounts,
            'final_amount' => '$'.$final_amount,
            'response' => $response
        );
        print_r($result);
    }
}
