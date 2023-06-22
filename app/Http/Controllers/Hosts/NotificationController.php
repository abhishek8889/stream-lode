<?php

namespace App\Http\Controllers\Hosts;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PostNotification;
use App\Models\HostAppointments;


class NotificationController extends Controller
{
  public function index(){
    $hostappoinments =  HostAppointments::where([['host_id',Auth()->user()->id],['questionrie_status',1],['seen_status',0]])->orderBy('created_at','DSC')->get()->toArray();
    $notification = PostNotification::get()->toArray();
  $data = array();
    foreach($notification as $d){
          if (in_array(Auth()->user()->id, $d['seen_users'])){
            array_push($data,$d);
            }
    }
    return view('Host.Notifications.index',compact('hostappoinments','data'));
  }
  public function seenupdate(Request $request){
    $postnotification = PostNotification::get();
    $count = 0;
    foreach($postnotification as $pn){
      $notification = PostNotification::find($pn->_id);
      $ids = $notification->seen_users;
      if (($key = array_search(Auth()->user()->id, $ids)) !== false) {
        $count = $count +1;
        unset($ids[$key]);
      }
      $notification->seen_users = $ids;
      $notification->update();
    }
    return response()->json($count);
  }
  public function adminnotification(){
    $notification = PostNotification::where([['created_at','>',Auth()->user()->created_at]])->get()->toArray();
    return view('Host.Notifications.adminnotification',compact('notification'));
  }
}
