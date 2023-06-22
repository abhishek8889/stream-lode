<?php

namespace App\Http\Controllers\Admin\mettings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\HostAppointments;
use App\Models\User;


class MeetingsController extends Controller
{
  public function index(){
     $current_date = date("Y-m-d H:i");
        $current_date = strtotime($current_date);
        $duration_in_minutes = '15';
        $requied_time = date('Y-m-d H:i', strtotime('+'.$duration_in_minutes.' minutes',$current_date));
      $send_to = HostAppointments::where([['start','<=',$requied_time]])->get();

  //  $test= HostAppointments::where([['start','<=','2023-06-21 06:50']])->get();
   echo '<pre>';
   print_r(count($send_to));
   echo '</pre>';
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
      $data = HostAppointments::where('questionrie_status',1)->where('host_id',$host->_id)->orderBy('created_at','DSC')->with('user')->paginate(10);
      // dd($data);
   return view('Admin.mettings.appoinments_detail',compact('data'));
    }
}
