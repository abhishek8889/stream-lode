<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

use App\Models\HostAvailablity;
use App\Models\HostAppointments;
use Illuminate\Support\Facades\DB;
use stdClass;

class SearchHostController extends Controller
{
    //
    public function index(){
        $hosts = DB::table('users')->where('status',1)->get();
        // $tags = Tags::where('user_id','63c942d6aa1425079f0bae4c')->get();
        // dd($tags);
        return view('Guests.search-host.index',compact('hosts'));
    }

    // Host details

    public function hostDetail(Request $req , $unique_id){

        $host_data = User::where('unique_id',$unique_id)->first();
        $host_details = DB::table('users')->where('unique_id',$unique_id)->first();
        
        if($req->ajax()) {

            //   Available Host
            
            $host_schedule = HostAvailablity::where('host_id',$host_data['_id'])->get(['title','start','end','status']);
            $available_host = array();

            foreach($host_schedule as $schedule){
                if($schedule->status == 1){
                    $available_host[] =  array(
                        'id'       => $schedule['id'],
                        'title'    =>  $schedule['title'],
                        'start'    =>  $schedule['start'],
                        'end'      =>  $schedule['end'],
                        'status'   =>  $schedule['status'],
                        'type'     =>  'available_host',
                        'color'    =>  '#6294a7',
                        'allDay'   =>  false,
                    );
                } 
            }

            //  Host Meetings 

            $host_appointments = HostAppointments::where('host_id',$host_data['_id'])->get(['start','end','status']);

            foreach($host_appointments as $meetings){
                if($schedule->status == 1){
                    $available_host[] =  array(
                        'id'       =>  $meetings['id'],
                        'start'    =>  $meetings['start'],
                        'end'      =>  $meetings['end'],
                        'status'   =>  $meetings['status'],
                        'type'     =>  'schedule_meeting',
                        'color'    =>  '#dd8585',
                        'allDay'   =>  false,
                    );
                } 
            }
          
            return response()->json($available_host);
        }
       
        // dd($available_host);
        return view('Guests.search-host.host-detail',compact('host_details'));
        // return view('Guests.search-host.host-detail');

    }

    // Schedule meetings 

    public function scheduleMeeting(Request $req ){
      
        switch ($req->type) {
            case 'add':
                //  Appointment data create
               
               $newAppointment = new HostAppointments;
                $newAppointment->host_available_id = $req->available_id;
                $newAppointment->user_id = $req->user_id;
                $newAppointment->host_id = $req->host_id;
                $newAppointment->guest_name = $req->name;
                $newAppointment->guest_email = $req->email;
                $newAppointment->start = date('Y-m-d H:i', strtotime($req->start));
                $newAppointment->end = date('Y-m-d H:i', strtotime($req->end));
                $newAppointment->status = $req->status;
                $newAppointment->save();
               
                //  Host availablity update

               $host_availablity =  HostAvailablity::where('_id',$req->available_id)->first();
               $meeting_end_time =  strtotime($req->end);
               $host_availablity->start = date('Y-m-d H:i', strtotime('+30 minutes',$meeting_end_time));
               $host_availablity->update();
                
               $event = array(
                 'id' => $newAppointment['id'],
                 'start' => $newAppointment['start'],
                 'end' => $newAppointment['end'],
                 'status' => $newAppointment['status'],
                 'type'     =>  'schedule_meeting',
                 'color'    =>  '#dd8585',
                 'allDay'   =>  false,
               );
               
            //    return $event;
               return response()->json($event);
              break;
            }
    }
}
