<?php

namespace App\Http\Controllers\Hosts;

use App\Models\HostAppointments;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;

class AppoinmentsController extends Controller
{
    public function index(){
        $today_date = date("Y-m-d H:m");
    //    $date = "2023-02-28 14:30";
        $host_schedule = HostAppointments::where([['host_id','=',Auth::user()->_id]])->orderBy('created_at','desc')->get();
        // print_r($host_schedule);
        return view('Host.Appoinments.index',compact('host_schedule'));
    }
}
