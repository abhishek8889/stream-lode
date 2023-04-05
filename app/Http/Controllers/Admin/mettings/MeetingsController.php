<?php

namespace App\Http\Controllers\Admin\mettings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\HostAppointments;
use App\Models\User;


class MeetingsController extends Controller
{
  public function index(){
    $data = HostAppointments::with('user')->get()->toArray();
    
    // dd($data);
    foreach($data as $d){
      $userdata[] = $d['user'];
    }
     $data = array_unique($userdata,SORT_REGULAR);
     foreach($data as $d){
      // print_r($d['_id']);
      $user[] = User::where('_id',$d['_id'])->with('appoinments',function($response){ $response->orderBy('created_at','desc'); } )->get();
     }
    // // dd($user);
    // echo '<pre>';
    // print_r($user);
    // echo '</pre>';
    // die();
    return view('Admin.mettings.index',compact('user'));
  }
}
