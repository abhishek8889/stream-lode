<?php

namespace App\Http\Controllers\Hosts;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Twilio\Jwt\AccessToken;
use Twilio\Jwt\Grants\VideoGrant;
use Twilio\Rest\Client;
use Twilio\Jwt\Grants\SyncGrant;
use Twilio\Jwt\Grants\ChatGrant;
use App\Models\User;
use Hash;

class HostStreamController extends Controller
{
    public function index(){
        return view('Host.Appoinments.vedio_chat');
    }
    public function createRoom(Request $req){
        $twilioAccountSid = getenv('TWILIO_ACCOUNT_SID');
        $twilioAuthToken = getenv("TWILIO_AUTH_TOKEN");
        $twilio = new Client($twilioAccountSid, $twilioAuthToken);
        $room = $twilio->video->v1->rooms->create(
            [
                "uniqueName" => $req->room_name, // default room type is group
                "statusCallback" => env('APP_URL')."live-stream/".$req->room_name,
                "statusCallbackMethod" => "GET",
                "unusedRoomTimeout" => 60,
            ]
        );
        
        $data = array(
            'roomName'  =>  $req->room_name,
            'join_link' =>  $room->statusCallback,
            'status'    =>  Hash::make('host'),
        );
      
       return redirect()->back()->with('data',$data);
    }
    // public function generateToken(Request $req){
    //     $twilioAccountSid = getenv('TWILIO_ACCOUNT_SID');
    //     $twilioApiKey = getenv('TWILIO_API_KEY');
    //     $twilioApiSecret = getenv('TWILIO_API_SECRET');
    //     // $twilioAuthToken = getenv("TWILIO_AUTH_TOKEN");
        
    //     $roomName = $req->room_name;
    //     $identity = $req->identity;
    //     // Create a new Access Token with Video grant

    //     $accessToken = new AccessToken(
    //         $twilioAccountSid,
    //         $twilioApiKey,
    //         $twilioApiSecret,
    //         3600,
    //         $identity
    //     );


    //     $videoGrant = new VideoGrant();
    //     // $videoGrant->setRoom($roomName);
    //     $accessToken->addGrant($videoGrant);


    //     // dd($accessToken->toJWT());
    //     // // return response()->json([
    //     // //     'accessToken' => $accessToken->toJWT(),
    //     // //     'roomName' => $roomName
    //     // // ]);
    //     // header('Content-type:application/json;charset=utf-8');
      
    //     header('Content-type:application/json;charset=utf-8');
    //     echo json_encode(array(
    //         'identity' => $identity,
    //         'token' => $accessToken->toJWT(),
    //         'roomName' => $roomName
    //     ));
    //     // header('Content-type:application/json;charset=utf-8');
    //     // echo json_encode(array(
    //     //     'identity' => $identity,
    //     //     'token' => $token->toJWT(),
    //     // ));
    //     // return array('accessToken' =>  $accessToken, 'roomName' => $roomName ,'identity' => $identity );
    // }
    // public function createRoom(Request $req){
    //     $twilioAccountSid = getenv('TWILIO_ACCOUNT_SID');
    //     $twilioAuthToken = getenv("TWILIO_AUTH_TOKEN");
    //     // $twilioApiKey = getenv('TWILIO_API_KEY');
    //     // $twilioApiSecret = getenv('TWILIO_API_SECRET');
    //     $twilio = new Client($twilioAccountSid, $twilioAuthToken);
    //     $room = $twilio->video->v1->rooms->create(
    //         [
    //             "uniqueName" => $req->room_name, // default room type is group
    //             "statusCallback" => env('APP_URL')."live-stream/".$req->room_name,
    //             "statusCallbackMethod" => "GET",
    //             "unusedRoomTimeout" => 60,
    //         ]
    //     );
    //     // dd($room);
    
    //     $roomName = $req->room_name;
    //     $identity = auth()->user()->unique_id;
    //     // Create a new Access Token with Video grant

    //     // $accessToken = new AccessToken(
    //     //     $twilioAccountSid,
    //     //     $twilioApiKey,
    //     //     $twilioApiSecret,
    //     //     3600,
    //     //     $identity
    //     // );
    //     // $videoGrant = new VideoGrant();
    //     // $videoGrant->setRoom($roomName);
    //     // $accessToken->addGrant($videoGrant);

    //     $data = array(
    //         // 'token'     =>  $accessToken->toJWT(),
    //         'roomName'  =>  $roomName,
    //         // 'identity'  =>  auth()->user()->unique_id,
    //         'join_link' => $room->statusCallback,
    //         'type' => 'host',
    //     );
      
    //    return redirect()->back()->with('data',$data);
    // }
    public function joinRoomView(){
        return view('Host.Appoinments.join_room');
    }
}
