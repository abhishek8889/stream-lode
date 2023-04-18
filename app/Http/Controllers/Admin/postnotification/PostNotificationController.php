<?php

namespace App\Http\Controllers\Admin\postnotification;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Messages;
use App\Models\PostNotification;
use App\Events\Message;
use App\Events\AdminNotification;

class PostNotificationController extends Controller
{
    public function index(){
        $messages = PostNotification::get();
            // dd($messages);
        return view('Admin.postnotification.index',compact('messages'));
    }
    public function sendmessage(Request $request){
        // print_r($request->all());
        event(new AdminNotification($request->username, $request->message,$request->sender_id,'public'));
        $request->validate([
            'message' => 'required'
        ]);
            $message = new PostNotification();
            $message->sender_id = $request->sender_id;
            $message->message = $request->message;
            $message->reciever_id = 'hosts';
            $message->username = $request->username;
            $message->seen_users = array();
            $message->save();
        return response()->json($message);
    }
}
