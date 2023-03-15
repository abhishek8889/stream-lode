<?php

namespace App\Http\Controllers\Hosts;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Twilio\Jwt\AccessToken;
use Twilio\WebSocket\Client as TwilioWebSocketClient;

use Twilio\Rest\Client;
use Twilio\Jwt\Grants\ChatGrant;
use Twilio\Jwt\Grants\VideoGrant;
use Twilio\Jwt\Grants\IpMessagingGrant;
use Twilio\Jwt\Grants\SyncGrant;
use Twilio\Jwt\Grants\VoiceGrant;

class WebsocketController extends Controller
{
    public function onOpen(Request $req)
    {
        $twilio = new Client( getenv('TWILIO_ACCOUNT_SID'),  getenv('TWILIO_AUTH_TOKEN'));

        $roomName = 'abhi_room_6';
        $identity = 'abhishek';
        $accessToken = new AccessToken(
            getenv('TWILIO_ACCOUNT_SID'),
            getenv('TWILIO_API_KEY'),
            getenv('TWILIO_API_SECRET'),
            3600,
            $identity
        );
       

        // $websocketGrant = new WebsocketGrant();
        // $accessToken->addGrant($websocketGrant);

        $chatGrant = new ChatGrant();
        $accessToken->addGrant($chatGrant);

        $videoGrant = new VideoGrant();
        $videoGrant->setRoom($roomName);
        $accessToken->addGrant($videoGrant);

        // $ipMessagingGrant = new App\Http\Controllers\Hosts\IpMessagingGrant;
        // $accessToken->addGrant($ipMessagingGrant);

        $syncGrant = new SyncGrant();
        $accessToken->addGrant($syncGrant);

        $voiceGrant = new VoiceGrant();
        $accessToken->addGrant($voiceGrant);

        $response = [
            'accessToken' => $accessToken->toJWT(),
            'twilioAccountSid' => getenv('TWILIO_ACCOUNT_SID'),
        ];
        $webSocketClient = new TwilioWebSocketClient($accessToken->toJWT(), ['region' => 'us1']);
        $webSocketClient->connect();
        
        return response()->json($response);
    }
}
