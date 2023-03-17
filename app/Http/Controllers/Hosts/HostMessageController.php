<?php

namespace App\Http\Controllers\Hosts;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Messages;
use App\Models\User;
use Auth;
use App\Events\Message;


class HostMessageController extends Controller
{
    public function index(){
      $admin = User::where('status',2)->first();
       $messages = Messages::where([['reciever_id',Auth::user()->id],['sender_id',$admin['_id']]])->orWhere([['reciever_id',$admin['_id']],['sender_id',Auth::user()->id]])->get();
       return view('Host.Messages.index',compact('messages','admin'));
    }
    public function update(Request $req){
     $query = Messages::where('reciever_id',$req->id)->get();
     foreach($query as $q){
        $update = Messages::find($q->id);
        $update->status = 0;
        $update->update();
     }
     return response()->json('done');
    }
    public function message(Request $req){
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
    public function hostmessage($id,$uid){
      $messages = Messages::where([['reciever_id',Auth::user()->id],['sender_id',$uid]])->orWhere([['reciever_id',$uid],['sender_id',Auth::user()->id]])->get();
      return view('Host.Messages.guestmessage',compact('uid','messages'));
    }
}
