<?php

namespace App\Http\Controllers\Hosts;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\HostAvailablity;
use App\Models\HostAppointments;
use DB;

class HostCalendar extends Controller
{
    //
    public function index(Request $request)
    {
        
        if($request->ajax()) {
         
            $data = HostAvailablity::where('host_id',auth()->user()->id)->get(['id', 'title', 'start','end']);
            
             return response()->json($data);
        }
       
        return view('Host.calendar.index2');
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
          
                return response()->json($event);
              break;
    
            case 'delete':
                $event = HostAvailablity::find($request->id)->delete();
    
                return response()->json($event);
              break;
              
            default:
              # code...
              break;
        }
      }else{
        $message = array('error' => "Sorry but for schedule meeting you have to activate your account by paying invoice got in registered email.");
        return response()->json($message);
      }
    }
    public function seenstatus(Request $request){
      $data = HostAppointments::where([['host_id',Auth()->user()->id],['seen_status',0]])->get();
        foreach($data as $d){
            $update = HostAppointments::find($d->_id);
            $update->seen_status = 1;
            $update->update();
        }
      return response()->json($data);

    }
}
