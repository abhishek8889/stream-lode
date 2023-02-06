<?php

namespace App\Http\Controllers\Hosts;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\HostAvailablity;
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
       
        switch ($request->type) {
           case 'add':
            // return $request;
              $data = HostAvailablity::create([
                    'host_id' => auth()->user()->id,
                    'title' => $request->title,
                    'start' => $request->start,
                    'end' => $request->end,
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
    }
}
