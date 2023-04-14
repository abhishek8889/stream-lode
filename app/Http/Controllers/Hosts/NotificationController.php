<?php

namespace App\Http\Controllers\Hosts;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PostNotification;
use App\Models\HostAppointments;


class NotificationController extends Controller
{
  public function index(){
    $notification = PostNotification::get();

    $hostappoinments =  HostAppointments::where([['host_id',Auth()->user()->id],['seen_status',0]])->get();
    return view('Host.Notifications.index',compact('hostappoinments'));
  }
}
