<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\HostAppointments;
use Auth;

class MeetingController extends Controller
{
    public function index(){
       $appoinments = HostAppointments::where('user_id',Auth::user()->id)->with('user')->orderBy('created_by','desc')->get();
        // dd($appoinments);
        return view('Guests.meeting-scheduled.index',compact('appoinments'));
    }
}
