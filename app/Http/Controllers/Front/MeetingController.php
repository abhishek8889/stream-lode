<?php

namespace App\Http\Controllers\Front;

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
       $appoinments = HostAppointments::where('user_id',Auth::user()->id)->with('user')->with('messages',function($response){ $response->where([['reciever_id',Auth::user()->id],['status',1]]); })->orderBy('created_by','desc')->get();
        // dd($appoinments);
        // echo Auth::user()->id;
        return view('Guests.meeting-scheduled.index',compact('appoinments'));
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
      $username = $req->username;
      $messages = $req->message;
      event(new Message($username, $messages,$sender_id,$reciever_id));
      $message = new Messages();
      $message->reciever_id = $req->reciever_id;
      $message->sender_id = $req->sender_id;
      $message->username = $req->username;
      $message->message = $req->message;
      $message->status = 1;
      $message->save();
      return response()->json('message sent');
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
