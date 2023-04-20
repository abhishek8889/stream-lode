<?php

namespace App\Http\Controllers\Hosts;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Messages;
use App\Models\User;
use App\Models\HostAppointments;
use Auth;
use App\Events\Message;


class HostMessageController extends Controller
{
    public function index($id,$idd = null){
      $reciever_id = Auth::user()->id;
      $messages = Messages::where('reciever_id',$reciever_id)->orWhere('sender_id',$reciever_id)->orderBy('created_at','desc')->get();
      $ids = array();
      foreach($messages as $m){
         array_push($ids,$m->sender_id);
         array_push($ids,$m->reciever_id);
      }
      // print_r($ids);
          $message_id =array_unique($ids); 
          if (($key = array_search(Auth::user()->id, $message_id)) !== false) {
            unset($message_id[$key]);
        }
       if($message_id){ 
          foreach($message_id as $mid){
             $users[] = User::where('_id',$mid)->with('adminmessage',function($response){ $response->where([['reciever_id',Auth::user()->id],['status',1]]); })->first(); 
          }
        }else{
          $users = array();
        }
         
     $host_schedule = HostAppointments::where('host_id',Auth::user()->_id)->groupBy('user_id')->select('guest_email','guest_name','host_id')->get();
      $admin = User::where('status',2)->first();
     // echo $idd;
      if($idd != null){
        $user = User::find($idd);
       $messages = Messages::where([['reciever_id',Auth::user()->id],['sender_id',$idd]])->orWhere([['reciever_id',$idd],['sender_id',Auth::user()->id]])->get();
      }else{
        $messages = array();
        $user = null;
      }
       return view('Host.Messages.index',compact('host_schedule','messages','idd','user','users','admin'));
    }
    public function update(Request $req){
     $query = Messages::where([['reciever_id',$req->sender_id],['sender_id',$req->reciever_id],['status',1]])->get();
     foreach($query as $q){
        $update = Messages::find($q->id);
        $update->status = 0;
        $update->update();
     }
     return response()->json($query);
    }
    public function message(Request $req){
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
    public function hostmessage($id,$uid){
      $messages = Messages::where([['reciever_id',Auth::user()->id],['sender_id',$uid]])->orWhere([['reciever_id',$uid],['sender_id',Auth::user()->id]])->get();
      return view('Host.Messages.guestmessage',compact('uid','messages'));
    }
    
}
