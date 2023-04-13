<?php

namespace App\Http\Controllers\Admin\Streams;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\StreamPayment;
use App\Models\HostAppointments;
use App\Models\User;

class StreamPayments extends Controller
{
    public function index(){
    $stream_payments = StreamPayment::with('appoinments','appoinments.user')->get();
    foreach($stream_payments as $d){
        $userdata[] = $d['appoinments']['user'];
      }
      $data = array_unique($userdata,SORT_REGULAR);
     foreach($data as $d){
      $stream_data[] =  User::where('_id',$d['_id'])->with('appoinments',function($response){ $response->orderBy('created_at','DSC'); })->with('streampayment',function($response){ $response->orderBy('created_at','DSC'); })->get();
     }
    // dd($data);
   
    return view('Admin.payment-collection.stream_payment',compact('stream_data'));
    }
    public function paymentdetail($id){
        $host = User::where('unique_id',$id)->first();      
        $stream_data = StreamPayment::where('host_id',$host->_id)->with('appoinments','host')->orderBy('created_at','DSC')->get();
        return view('Admin.payment-collection.stream_payment_detail',compact('stream_data'));
    }
}