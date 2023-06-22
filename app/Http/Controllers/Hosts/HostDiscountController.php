<?php

namespace App\Http\Controllers\Hosts;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Discounts\HostDiscount;

class HostDiscountController extends Controller
{
    public function index(){
        
        $discount_coupons = HostDiscount::where('host_id',Auth()->user()->id)->orderBy('created_at','desc')->paginate(10);
        return view('Host.Discount.index',compact('discount_coupons'));
    }
    public function create($id,$idd = null){
        $coupon_data = HostDiscount::find($idd);
        return view('Host.Discount.createcoupon',compact('coupon_data'));
    }
    public function createproc(Request $req){
    //    return $req;
        // print_r($req->all());
        // echo $req->expiredate;
        $middle = strtotime($req->expiredate);
        $expire_new_date = date('Y-m-d', $middle);
        if($req->id == null){
             $req->validate([
            'coupon_name' => 'required',
            'coupon_code' => 'required|unique:host_discounts_coupons',
            'percentage_off' => 'required|numeric|gt:0|lt:100',
            'duration' => 'required',
        ]);
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
                $data->host_id = Auth()->user()->id;
                $data->status = 1;
                $data->save();
                return redirect()->back()->with('success','Successfully save new coupons');
            }else{
                $req->validate([
                    'coupon_name' => 'required',
                    'coupon_code' => 'required',
                    'percentage_off' => 'required',
                    'duration' => 'required',
                ]);
                // print_r($req->all());
                $data = HostDiscount::find($req->id);
                $data->coupon_name = $req->coupon_name;
                $data->coupon_code = $req->coupon_code;
                $data->percentage_off = $req->percentage_off;
                $data->duration = $req->duration;
                if($req->duration == 'Forever'){
                    $data->coupon_used += 0;
                }
                $data->duration_times = $req->duration_times;
                $data->expiredate = $expire_new_date;
                $data->host_id = Auth()->user()->id;
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
   
}
