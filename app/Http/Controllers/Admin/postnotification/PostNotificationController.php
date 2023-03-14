<?php

namespace App\Http\Controllers\Admin\postnotification;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Message;
class PostNotificationController extends Controller
{
    public function index(){
        $messages = Message::where('type','=',1)->with('users')->get();
            // print_r($messages);
            // dd($messages);
        return view('Admin.postnotification.index',compact('messages'));
    }
    public function sendmessage(Request $request){
        // print_r($request->all());
        $request->validate([
            'message' => 'required'
        ]);
        $users = User::where('status',1)->select('id')->get();
        foreach($users as $u){
            $message = new Message();
            $message->sender_id = $request->sender_id;
            $message->message = $request->message;
            $message->reciever_id = $u->_id;
            $message->status = 1;
            $message->save();
        }
        return response()->json('done');
    }
}
