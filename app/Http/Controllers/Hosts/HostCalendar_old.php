<?php

namespace App\Http\Controllers\Hosts;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Appointments;

class HostCalendar2 extends Controller
{
    //
    public function index(){
        $events = array();
        $appointments = Appointments::where('host_id',auth()->user()->id)->get();
        // dd($appointments);
        foreach($appointments as $appointment){
            $events[] = [
                'title' => $appointment['title'],
                'start' => $appointment['start_date'],
                'availability_status' => $appointment['status'],
            ];
        }
    //   dd($events);
        return view("Host.calendar.index2",['event'=>$events]);
    }
    public function insertSchedule(Request $req){
        // return $req->all();
        $req->validate([
            'title' => 'required|string', 
        ]);

        $appointments  = new Appointments;
        $appointments->host_id = $req->host_id;
        $appointments->title = $req->title;
        $appointments->start_date = $req->start;
        // $appointments->allDay = "false";
        $appointments->status = 1;
        $appointments->save();
 
        return response()->json($appointments);
    }
}
