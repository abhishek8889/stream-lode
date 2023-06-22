<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Twilio\Rest\Client;

use Twilio\Jwt\AccessToken;
use Twilio\Jwt\Grants\VideoGrant;

class VedioChatController extends Controller
{
    //
    public function index(){
        return view('Guests.vedio_call');
    }
    public function createRoom(){
        $sid = getenv("TWILIO_ACCOUNT_SID");
        $token = getenv("TWILIO_AUTH_TOKEN");
        $twilio = new Client($sid, $token);
   
        $room = $twilio->video->v1->rooms->create(["uniqueName" => "AbhiTheDev"]);

        dd($room);
    }
    public function joinRoom(Request $request, $roomName)
    {
        
        $accountSid = env('TWILIO_ACCOUNT_SID');
        $authToken = env('TWILIO_AUTH_TOKEN');
        $apiKey = env('TWILIO_API_KEY');
        $apiSecret = env('TWILIO_API_SECRET');

        // $identity = $request->user()->name;
        $identity = 'Ashar';

        $token = new AccessToken($accountSid, $apiKey, $apiSecret, 3600, $identity);
      
        $videoGrant = new VideoGrant();
        $videoGrant->setRoom($roomName);

        $token->addGrant($videoGrant);

        $response = [
            'accessToken' => $token->toJWT(),
            'roomName' => $roomName,
            'identity' => $identity
        ];
       
        return view('Guests.vedio', compact('response'));
        // return view('Guests.video');
    }
}
