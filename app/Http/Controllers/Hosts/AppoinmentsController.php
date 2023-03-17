<?php

namespace App\Http\Controllers\Hosts;

use App\Models\HostAppointments;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\Mail\SendGuestMeetinglink;


class AppoinmentsController extends Controller
{
    public function index(){
        
        $host_schedule = HostAppointments::where([['host_id','=',Auth::user()->_id]])->orderBy('created_at','desc')->get();
        // print_r($host_schedule);
        return view('Host.Appoinments.index',compact('host_schedule'));
    }
   
}
