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
    public function createRoom(){
        $sid = getenv("TWILIO_ACCOUNT_SID");
        $token = getenv("TWILIO_AUTH_TOKEN");
        $twilio = new Client($sid, $token);
        $room = $twilio->video->v1->rooms->create(["uniqueName" => "room_abhi7"]);
        dd($room);
    }
    public function generateToken(Request $req){
        // $req->validate([
        //     'room_name' => 'required',
        //     'identity' => 'required',
        // ]);
        $twilioAccountSid = getenv('TWILIO_ACCOUNT_SID');
        $twilioApiKey = getenv('TWILIO_API_KEY');
        $twilioApiSecret = getenv('TWILIO_API_SECRET');
        // $twilioAuthToken = getenv("TWILIO_AUTH_TOKEN");
        
        $roomName = 'room_abhi7';
        $identity = 'abhishek';
        // Create a new Access Token with Video grant

        $accessToken = new AccessToken(
            $twilioAccountSid,
            $twilioApiKey,
            $twilioApiSecret,
            3600,
            $identity
        );
        $videoGrant = new VideoGrant();
        $videoGrant->setRoom($roomName);
        $accessToken->addGrant($videoGrant);

        // Return the Access Token and room name as JSON
        return response()->json([
            'accessToken' => $accessToken->toJWT(),
            'roomName' => $roomName
        ]);
    }
    public function joinRoomView(){
        return view('Host.Appoinments.join_room');
    }
}
