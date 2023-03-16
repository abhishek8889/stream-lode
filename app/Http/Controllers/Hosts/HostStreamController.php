<?php

namespace App\Http\Controllers\Hosts;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Twilio\Jwt\AccessToken;
use Twilio\Jwt\Grants\VideoGrant;
use Twilio\Rest\Client;
use Twilio\Jwt\Grants\WebsocketGrant;
use Twilio\Jwt\Grants\ChatGrant;
use Twilio\Jwt\Grants\IpMessagingGrant;
use Twilio\Jwt\Grants\SyncGrant;
use Twilio\Jwt\Grants\VoiceGrant;


class HostStreamController extends Controller
{
    //
    public function index(){
        return view('Host.Appoinments.vedio_chat');
    }
    public function createRoom(Request $req){
        
        $sid = getenv("TWILIO_ACCOUNT_SID");
        $token = getenv("TWILIO_AUTH_TOKEN");
        $twilio = new Client($sid, $token);
        $room = $twilio->video->v1->rooms->create(
            [
                "uniqueName" => $req->room_name, // default room type is group
                "statusCallback" => env('APP_URL')."vedio/".$req->room_name."/identity?{identity}",
                "statusCallbackMethod" => "GET",
                "unusedRoomTimeout" => 60,
            ]
        );
        // dd($room);
        $token_response = $this->generateToken($req);
        dd($token_response['accessToken'] .$token_response['roomName'] .$room->statusCallback  );
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
        
        $roomName = $req->room_name;
        $identity = $req->identity;
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

        dd($accessToken->toJWT());
        // return response()->json([
        //     'accessToken' => $accessToken->toJWT(),
        //     'roomName' => $roomName
        // ]);
        return array('accessToken' =>  $accessToken, 'roomName' => $roomName );
    }
    public function joinRoomView(){
        return view('Host.Appoinments.join_room');
    }
}
