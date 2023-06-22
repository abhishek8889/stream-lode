<?php

namespace App\Http\Controllers\Hosts;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\MeetingCharge;

class MeetingCharges extends Controller
{
    public function index(){
        $meetingcharges = MeetingCharge::where('host_id',Auth()->user()->id)->paginate(10);
        return view('Host.Meeting-charges.index',compact('meetingcharges'));
    }
    public function add($id,$idd = null){
        $meetingcharges = MeetingCharge::find($idd);
        return view('Host.Meeting-charges.addcharges',compact('meetingcharges'));
    }
    public function addproc(Request $req){
        $req->validate([
            'duration' => 'required',
            'payment' => 'required'
        ]);
        if($req->id){
        $duration = MeetingCharge::where([['host_id',Auth()->user()->id],['duration_in_minutes',$req->duration],['_id','!=',$req->id]])->first();
        // dd($duration);
        if($duration){
            return redirect()->back()->with('error','This duration duration is already exist please update this');
        }else{
            $data = MeetingCharge::find($req->id);
            $data->host_id = Auth()->user()->id;
            $data->duration_in_minutes = $req->duration;
            $data->amount = $req->payment;
            $data->currency = $req->currency;
            $data->update();
            return redirect()->back()->with('success','successfully updated meeting charges');
        }
        }else{
        $duration = MeetingCharge::where([['host_id',Auth()->user()->id],['duration_in_minutes',$req->duration]])->first();
        // dd($duration);
        if($duration){
            return redirect()->back()->with('error','This duration duration is already exist please update this');
        }else{
            
                $data = new MeetingCharge;
                $data->host_id = Auth()->user()->id;
                $data->duration_in_minutes = $req->duration;
                $data->amount = $req->payment;
                $data->currency = $req->currency;
                $data->save();
                return redirect()->back()->with('success','successfully saved meeting charges');
            }

           
        }
    }
    public function delete($id,$idd){
        print_r($idd);
        $data = MeetingCharge::find($idd);
        $data->delete();
        return redirect()->back()->with('success','successfully deleted meeting charges');
    }
   
}
