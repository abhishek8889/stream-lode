<?php

namespace App\Http\Controllers\Hosts;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Twilio\Jwt\AccessToken;
use Twilio\Jwt\Grants\VideoGrant;
use Twilio\Rest\Client;
use Twilio\Jwt\Grants\SyncGrant;
use Twilio\Jwt\Grants\ChatGrant;
use Illuminate\Support\Facades\Mail;
use App\Models\User;
use App\Mail\SendVideoLink;
use App\Models\HostAppointments;
use App\Models\Messages;
use Hash;
use App\Events\Message;

class HostStreamController extends Controller
{
    public function index($unique_id,$id){
      
        $appoinments = HostAppointments::where('_id',$id)->with('user')->first();
   
        return view('Host.Appoinments.vedio_chat',compact('appoinments'));
    }
    public function createRoom(Request $req){
        $room_name = md5($req->room_name).'12';
        $twilioAccountSid = getenv('TWILIO_ACCOUNT_SID');
        $twilioAuthToken = getenv("TWILIO_AUTH_TOKEN");
        $twilio = new Client($twilioAccountSid, $twilioAuthToken);
        
        $room = $twilio->video->v1->rooms->create(
            [
                "uniqueName" => $room_name, // default room type is group
                "statusCallback" => env('APP_URL')."live-stream/".$room_name,
                "statusCallbackMethod" => "GET",
                "unusedRoomTimeout" => 60,
            ]
        );

        $host_appoinments = HostAppointments::find($req->room_name);
        $host_appoinments->video_link_name = $room_name;
        $host_appoinments->join_link = env('APP_URL')."live-stream/".$room_name;
        $host_appoinments->update();

        $data = array(
            'roomName'  =>  $room_name,
            'join_link' =>  $room->statusCallback,
            'status'    =>  Hash::make('host'),
        );
        return response()->json($data['join_link']);
    }
 
    public function joinRoomView(){
        return view('Host.Appoinments.join_room');
    }

    public function sendlink(Request $req){
        
        $appoinments = HostAppointments::where('_id',$req->id)->with('user')->first();
        $mailData = [
            'host_name' => $appoinments->user['first_name'].' '.$appoinments->user['last_name'],
            'link' => $req->link,
        ];
        $mail = Mail::to($appoinments->guest_email)->send(new SendVideoLink($mailData));
       
        // $message = new Messages;
        // $message->username = $appoinments->user['first_name'];
        // $message->sender_id = Auth()->user()->id;
        // $message->message = '<a href="'.$req->link.'">'.$req->link.'</a>';
        // $message->reciever_id = $appoinments->user_id;
        // $message->status = 1;
        // $message->save();
        // event(new Message($appoinments->user,'<a href="'.$req->link.'">'.$req->link.'</a>',Auth()->user()->id,$appoinments->user_id,$message->created_at));
        if($mail == true){
            return response()->json('successfully sent link');
        }else{
            return response()->json('error in sending mail please contact with support.');
        }
    }
}
