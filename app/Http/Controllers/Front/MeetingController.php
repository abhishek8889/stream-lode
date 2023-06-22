<?php

namespace App\Http\Controllers\Front;
use Illuminate\Support\Facades\Mail;
use App\Mail\AppoinmentCancel;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\HostAppointments;
use App\Models\Messages;
use App\Models\User;
use Auth;
use App\Events\Message;

class MeetingController extends Controller
{
    public function index(){
        $current_time = date("Y-m-d H:i");
       $appoinments = HostAppointments::where([['user_id','=',Auth::user()->id],['questionrie_status','=',1],['end','>=',$current_time]])->with('user')->with('messages',function($response){ $response->where([['reciever_id',Auth::user()->id],['status',1]]); })->orderBy('created_at','desc')->get();
        
       // dd($appoinments);
        // echo Auth::user()->id;
        return view('Guests.meeting-scheduled.index',compact('appoinments'));
    }
    public function cancelappointment($id){
        // echo $id;
       $data = HostAppointments::With('hostDetails')->where('_id',$id)->first()->toArray();
    //    echo'<pre>'; print_r($data);echo '</pre>';
    //    die();
    
       if($data){
        $mailData = [
            'mailto'    =>'GUEST',
            'guestname' =>$data['guest_name'],
            'hostname'  =>$data['host_details']['first_name'],
            'start'     =>$data['start'],
            'end'       =>$data['end'],
            ];
        $mail = Mail::to($data['guest_email'])->send(new AppoinmentCancel($mailData));
            if($data['host_details'] != null){
                $mailData = [
                    'mailto'    =>'HOST',
                    'guestname' =>$data['guest_name'],
                    'hostname'  =>$data['host_details']['first_name'],
                    'start'     =>$data['start'],
                    'end'       =>$data['end'],
                    ];
                $mail = Mail::to($data['host_details']['email'])->send(new AppoinmentCancel($mailData));
            }else{
                return redirect()->back()->with('error','Failed to canceled meeting');
            }
       }else{
        return redirect()->back()->with('error','Failed to canceled meeting');
       }
      
        $cancel_appointment = HostAppointments::find($id)->delete();
        return redirect()->back()->with('successs','successfully canceled meeting');
    }
    public function message($id){
        $host_detail = User::where('unique_id',$id)->first();
        $messages = Messages::where([['reciever_id','=',Auth::user()->id],['sender_id','=',$host_detail['_id']]])->orWhere([['sender_id','=',Auth::user()->id],['reciever_id','=',$host_detail['_id']]])->orderBy('created_at','desc')->get();
        // dd($messages);
        return view('Guests.meeting-scheduled.meeting-message',compact('messages','host_detail'));
    }
    public function send(Request $req){
      $sender_id = $req->sender_id;
      $reciever_id = $req->reciever_id;
      $username = Auth::user();
      $messages = $req->message;
     
      $message = new Messages();
      $message->reciever_id = $req->reciever_id;
      $message->sender_id = $req->sender_id;
      $message->username = $req->username;
      $message->message = $req->message;
      $message->status = 1;
      $message->save();
      event(new Message($username, $messages,$sender_id,$reciever_id,$message->created_at));
      return response()->json($message);
    }
    public function messageseen(Request $req){
        $query = Messages::where([['reciever_id',$req->reciever_id],['sender_id',$req->sender_id],['status',1]])->get();
     foreach($query as $q){
        $update = Messages::find($q->id);
        $update->status = 0;
        $update->update();
     }
        return response()->json($query);
    }
}
