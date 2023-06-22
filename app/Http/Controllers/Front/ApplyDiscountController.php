<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Discounts\AdminDiscount;


class ApplyDiscountController extends Controller
{
    //
    public function couponForHost(Request $req){
        // return $req->all();
        $subtotal = (float)$req->subtotal;
        $appllied_discount = '';
        $coupon_data = AdminDiscount::where('coupon_code',$req->coupon_code)->first();
        
        $discount_data = '';
        $discount_type = '';
        if(!empty($coupon_data)){
            if($coupon_data->status == 1){
                if($coupon_data->discount_type == 'percent_off'){
                    
                    $percent_off = (float)$coupon_data->percent_off;
                    $appllied_discount = $subtotal * ($percent_off / 100);
                    $total = $subtotal - $appllied_discount;
                    $discount_data = array(
                        'appllied_discount' => $appllied_discount,
                        'total' => $total
                    );
                    return $discount_data;
                }else{
                    $amount_off = (float)$coupon_data->amount_off;
                    $appllied_discount = $amount_off;
                    $total = $subtotal - $appllied_discount;
                    $discount_data = array(
                        'appllied_discount' => $appllied_discount,
                        'total' => $total,
                    );
                    return $discount_data;
                }
            }else{
                return $discount_data = array('error' => 'Your coupon has been expired');
            }
        }else{
            return array('error' => 'Invalid coupon code.');
        }
    }
}
