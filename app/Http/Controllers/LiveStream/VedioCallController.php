<?php

namespace App\Http\Controllers\LiveStream;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Twilio\Jwt\AccessToken;
use Twilio\Jwt\Grants\VideoGrant;
use Twilio\Jwt\Grants\SyncGrant;
use Twilio\Jwt\Grants\ChatGrant;
use App\Models\HostAppointments;

class VedioCallController extends Controller
{
    //
    public function index(Request $req){
        $roomName = $req->segment(2);
       
        $appoinments = HostAppointments::where('video_link_name',$roomName)->first();
        // print_r($appoinments);
     
        return view('vediocall.vediocall',compact('roomName'));

    }
    public function passToken(Request $req){
        // dd($req);
  
        $identity = '';
        if(isset(auth()->user()->email)){
            $identity =  auth()->user()->email;
        }else{
            $identity = $req->ip();
        }
       
        // if (isset($_GET['identity'])) {
        //     $identity = $_GET['identity'];
        // }
        
        // if (empty($identity)) {
        //     // choose a random username for the connecting user (if one is not supplied)
        //     $identity = randomUsername();
        // }
        
        // Create access token, which we will serialize and send to the client
        $token = new AccessToken(
            env('TWILIO_ACCOUNT_SID'),
            env('TWILIO_API_KEY'),
            env('TWILIO_API_SECRET'),
            3600,
            $identity
        );
        
        // Grant access to Video
        $grant = new VideoGrant();
        $token->addGrant($grant);
        
        // Grant access to Sync
        $syncGrant = new SyncGrant();
        if (empty(env('TWILIO_SYNC_SERVICE_ID'))) {
            $syncGrant->setServiceSid('default');
        } else  {
            $syncGrant->setServiceSid(env('TWILIO_SYNC_SERVICE_ID'));
        }  
        $token->addGrant($syncGrant);
        
        // // Grant access to Chat
        // if (!empty($_ENV['TWILIO_CHAT_SERVICE_SID'])) {
        //     $chatGrant = new ChatGrant();
        //     $chatGrant->setServiceSid($_ENV['TWILIO_CHAT_SERVICE_SID']);
        //     $token->addGrant($chatGrant);
        // }
        
        
        // return serialized token and the user's randomly generated ID
   
       $data = array(
            'identity' => $identity,
            'token' => $token->toJWT(),
        );
        
        return response()->json($data);
    }
}
