<?php

namespace App\Http\Controllers\Hosts;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Message;
use Auth;


class HostMessageController extends Controller
{
    public function index(){
        $messages = Message::where('reciever_id',Auth::user()->id)->get();
        
       return view('Host.Messages.index',compact('messages'));
    }
}
