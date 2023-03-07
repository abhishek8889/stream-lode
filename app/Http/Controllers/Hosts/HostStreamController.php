<?php

namespace App\Http\Controllers\Hosts;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Twilio\Jwt\AccessToken;
use Twilio\Jwt\Grants\VideoGrant;
use Twilio\Rest\Client;

class HostStreamController extends Controller
{
    //
    public function index(){
        return view('Host.Appoinments.vedio_chat');
    }
    public function generateToken(Request $req){
        $req->validate([
            'room_name' => 'required',
            'identity' => 'required',
        ]);
        $twilioAccountSid = getenv('TWILIO_ACCOUNT_SID');
        $twilioApiKey = getenv('TWILIO_API_KEY');
        $twilioApiSecret = getenv('TWILIO_API_KEY_SECRET');
        $twilioAuthToken = getenv("TWILIO_AUTH_TOKEN");

        // Required for Video grant
        $roomName = $req->room_name;
        // An identifier for your app - can be anything you'd like
        $identity = $req->identity;

        $twilio = new Client($twilioAccountSid, $twilioAuthToken);

        $room = $twilio->video->v1->rooms->create([
            "uniqueName" => $roomName,
            "emptyRoomTimeout" => 30 , //set time out for the expiration of url 
        ]);
        // dd($room);

        // Create access token, which we will serialize and send to the client
        $token = new AccessToken(
            $twilioAccountSid,
            $twilioApiKey,
            $twilioApiSecret,
            3600,
            $identity
        );

        // Create Video grant
        $videoGrant = new VideoGrant();
        $videoGrant->setRoom($roomName);

        // Add grant to token
        $token->addGrant($videoGrant);

        // render token to string
        $token_jwt = $token->toJWT();
        dd($token_jwt. '\n room'. $room);
        return redirect(auth()->user()->unique_id.'/join-room')->with('token',$token_jwt);
    }
    public function joinRoomView(){
        return view('Host.Appoinments.join_room');
    }
}
