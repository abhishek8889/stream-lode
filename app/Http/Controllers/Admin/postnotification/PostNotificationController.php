<?php

namespace App\Http\Controllers\Admin\postnotification;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Messages;
use App\Events\Message;

class PostNotificationController extends Controller
{
    public function index(){
        $messages = Messages::where('type','=',1)->with('users')->get();
            // print_r($messages);
            // dd($messages);
        return view('Admin.postnotification.index',compact('messages'));
    }
    public function sendmessage(Request $request){
        // print_r($request->all());
        event(new Message($request->username, $request->message,'public',$request->sender_id));
        $request->validate([
            'message' => 'required'
        ]);
        $users = User::where('status',1)->select('id')->get();
        foreach($users as $u){
            // $username = $request->username;
            // $sender_id = $request->sender_id;
            // // $reciever_id = $u->_id;
            // $messages = $request->message;
            $message = new Messages();
            $message->sender_id = $request->sender_id;
            $message->message = $request->message;
            $message->reciever_id = $u->_id;
            $message->username = $request->username;
            $message->status = 1;
            $message->save();
        }
        return response()->json('done');
    }
}
