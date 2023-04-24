<?php

namespace App\Http\Controllers\Admin\mettings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\HostAppointments;
use App\Models\User;


class MeetingsController extends Controller
{
  public function index(){
    $data1 = HostAppointments::with('user')->get()->toArray();
    if(!empty($data1)){
      foreach($data1 as $d){
        $userdata[] = $d['user'];
      }
      $data = array_unique($userdata,SORT_REGULAR);
      foreach($data as $d){
        $user[] = User::where('_id',$d['_id'])->with('appoinments',function($response){ $response->where('questionrie_status',1)->orderBy('created_at','desc'); } )->get();
      }
    }else{
      $user = array();
    }
    return view('Admin.mettings.index',compact('user'));
  }
  public function detail($id){
     
      $host = User::where('unique_id',$id)->first();
      $data = HostAppointments::where('questionrie_status',1)->where('host_id',$host->_id)->orderBy('created_at','DSC')->with('user')->get();
      // dd($data);
   return view('Admin.mettings.appoinments_detail',compact('data'));
    }
}
