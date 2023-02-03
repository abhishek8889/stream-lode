<?php

namespace App\Http\Controllers\Hosts;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Appointments;
use DB;

class HostCalendar extends Controller
{
    //
    public function index(Request $request)
    {
        // return $request;
        
        if($request->ajax()) {
         
            $data = Appointments::where('host_id',auth()->user()->id)->get(['id', 'title', 'start']);
            
             return response()->json($data);
        }
       
      
        return view('Host.calendar.index2');
    }
 
   
    public function ajax(Request $request)
    {
       
        switch ($request->type) {
           case 'add':
            // $create_event = new Appointments;
            // $create_event->host_id = auth()->user()->id;
            // $create_event->title =  $request->title;
            // $create_event->start =  $request->start;
            // $create_event->status = 1;
            // $event = $create_event->save();
              $data = Appointments::create([
                    'host_id' => auth()->user()->id,
                    'title' => $request->title,
                    'start' => $request->start,
                    'status' => 1
                    // 'end' => $request->end,
              ]);
              $event = array(
                'id' => $data->id,
                'title' => $data->title,
                'start' => $data->start,
                'status' => $data->status
              );
             
              return response()->json($event);
             break;
  
           case 'update':
              $event = Appointments::find($request->id)->update([
                    'id' => $request->id,
                    'title' => $request->title,
                    'start' => $request->start,
                  
              ]);
         
              return response()->json($event);
             break;
  
           case 'delete':
              $event = Appointments::find($request->id)->delete();
  
              return response()->json($event);
             break;
             
           default:
             # code...
             break;
        }
    }
}
