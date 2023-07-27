<?php

namespace App\Http\Controllers\Hosts;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\HostAvailablity;
use App\Models\HostAppointments;
use DB;
use App\Models\MeetingCharge;
use App\Models\HostStripeAccount;
use App\Models\HostQuestionnaire;
use App\Models\HostSubscriptions;

class HostCalendar extends Controller
{
    //
    public function index(Request $request)
    {

        $meeting_charges = MeetingCharge::where('host_id',Auth()->user()->id)->orderBy('duration_in_minutes','ASC')->get();
        $host_stripe_account_details = HostStripeAccount::where('host_id',auth()->user()->id)->first();
        // dd($host_stripe_account_details);
        $host_question = HostQuestionnaire::where('host_id',Auth()->user()->id)->get();
       
        // dd($available_host);
        if($request->ajax()) {
          $host_appoinments = HostAppointments::where('host_id',Auth()->user()->id)->where('questionrie_status',1)->get(['id','start','end','status']);
          foreach($host_appoinments as $meetings){
                $data[] =  array(
                    'id'       =>  $meetings['id'],
                    'start'    =>  $meetings['start'],
                    'end'      =>  $meetings['end'],
                    'status'   =>  $meetings['status'],
                    'type'     =>  'schedule_meeting',
                    'color'    =>  '#dd8585',
                    'allDay'   =>  false,
                );
          }
        $host_schedule = HostAvailablity::where('host_id',auth()->user()->id)->get(['id', 'title', 'start','end','status']);
        foreach($host_schedule as $schedule){
          $data[] =  array(
            'id'       => $schedule['id'],
            'title'    =>  $schedule['title'],
            'start'    =>  $schedule['start'],
            'end'      =>  $schedule['end'],
            'status'   =>  $schedule['status'],
            'type'     =>  'available_host',
            'className' => 'error',
            'color'    =>  '#6294a7',
            'allDay'   =>  false,
        );
        }
         
            // $data = HostAvailablity::where('host_id',auth()->user()->id)->get(['id', 'title', 'start','end']);
            
             return response()->json($data);
        }
       
        return view('Host.calendar.index2',compact('meeting_charges','host_stripe_account_details','host_question'));

    }
    
    public function ajax(Request $request)
    {
      if(auth()->user()->active_status != 0 && !empty(auth()->user()->membership_id)){
        switch ($request->type) {
            case 'add':
              // return $request;
              $today_date = date("Y-m-d H:i");
              $request_date = date('Y-m-d H:i', strtotime($request->start));
              
              if($today_date >  $request_date  ){
                $message = array('error' => "you have to add meeting after ".$today_date);
                return response()->json($message);
              }
            
                $data = HostAvailablity::create([
                      'host_id' => auth()->user()->id,
                      'title' => $request->title,
                      'start' =>  date('Y-m-d H:i', strtotime($request->start)),
                      'end' => date('Y-m-d H:i', strtotime($request->end)),
                      'status' => 1
                ]);
                $event = array(
                  'id' => $data->id,
                  'title' => $data->title,
                  'start' => $data->start,
                  'end' => $data->end,
                  'status' => $data->status
                );
              
                return response()->json($event);
              break;
    
            case 'update':
              // return $request;
              $today_date = date("Y-m-d H:i");
              $request_date = date('Y-m-d H:i', strtotime($request->start));
              
              if($today_date >  $request_date  ){
                $message = array('error' => "you have to add meeting after ".$today_date);
                return response()->json($message);
              }
            
                $event = HostAvailablity::find($request->id)->update([
                      'id' => $request->id,
                      'title' => $request->title,
                      'start' => $request->start,
                      'end' => $request->end,
                ]);
          
                return response()->json($today_date);
              break;
    
            case 'delete':
              if($request->types == 'available_host'){
                $event = HostAvailablity::find($request->id)->delete();
              }else{
                $event = HostAppointments::find($request->id)->delete();
              }
                return response()->json($request->id);
              break;
              
            default:
              # code...
              break;
        }
      }else{
        $host_subscription = HostSubscriptions::where('host_id',auth()->user()->id)->first();
        $message ='';
        if($host_subscription['subscription_status'] == 'canceled'){
          $message = array('error' => "Sorry you don't have any memberhsip please purchase it if you want to enjoy video streaming features.");
        }else{
          $message = array('error' => "Sorry but for schedule meeting you have to activate your account by paying invoice got in registered email.");
        }
        return response()->json($message);
      }
    }
    public function seenstatus(Request $request){
      $data = HostAppointments::where([['host_id',Auth()->user()->id],['questionrie_status',1],['seen_status',0]])->get();
        foreach($data as $d){
            $update = HostAppointments::find($d->_id);
            $update->seen_status = 1;
            $update->update();
        }
      return response()->json($data);

    }
}
