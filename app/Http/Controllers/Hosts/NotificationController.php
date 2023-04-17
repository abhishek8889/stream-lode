<?php

namespace App\Http\Controllers\Hosts;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PostNotification;
use App\Models\HostAppointments;


class NotificationController extends Controller
{
  public function index(){
    $hostappoinments =  HostAppointments::where([['host_id',Auth()->user()->id],['seen_status',0]])->orderBy('created_at','DSC')->get()->toArray();
    $notification = PostNotification::get()->toArray();
  $data = array();
    foreach($notification as $d){
          if (in_array(Auth()->user()->id, $d['seen_users'])){
            }else{
              array_push($data,$d);
            }
    }
    return view('Host.Notifications.index',compact('hostappoinments','data'));
  }
  public function seenupdate(Request $request){
    $postnotification = PostNotification::where('_id',$request->id)->get();
    foreach($postnotification as $pn){
      $notification = PostNotification::find($pn->_id);
      $ids = $notification->seen_users;
      array_push($ids,Auth()->user()->id);
      $notification->seen_users = $ids;
      $notification->update();
    }
    return response()->json('done');
  }
}
