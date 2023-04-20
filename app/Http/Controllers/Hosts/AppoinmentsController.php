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
        
        $host_schedule = HostAppointments::where([['host_id','=',Auth::user()->_id],['questionrie_status',1]])->with('usermessages',function($response){ $response->where([['reciever_id',Auth::user()->id],['status',1]]); } )->with('answers')->orderBy('created_at','desc')->with('payments')->get();
        // dd($host_schedule);
        return view('Host.Appoinments.index',compact('host_schedule'));
    }
    public function deleteAppointment(Request $req){
        // return $req->id;
        $appointment = HostAppointments::find($req->id);
        $appointment->delete();
        return redirect()->back()->with('success','You have succesfully delete you appointment');
    }
}
