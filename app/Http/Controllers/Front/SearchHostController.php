<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Tags;
use App\Models\Messages;
use Illuminate\Support\Facades\Mail;
use App\Mail\appoinmentsconfirmation;
use App\Mail\HostAppoinmentsMail;
use App\Mail\SendpasswordMail;
use App\Models\HostAvailablity;
use App\Models\HostAppointments;
use Illuminate\Support\Facades\DB;
use Auth;
use Hash;
use DateTime;
use Twilio\Rest\Client;

use Twilio\Jwt\AccessToken;
use Twilio\Jwt\Grants\VideoGrant;

class SearchHostController extends Controller
{
    //
    public function index(){
        $hosts = DB::table('users')->where('status',1)->where('public_visibility',1)->get();
        // $tags = Tags::where('user_id','63c942d6aa1425079f0bae4c')->get();
        // dd($tags); 
        return view('Guests.search-host.index',compact('hosts'));
    }

    // Host details

    public function hostDetail(Request $req , $unique_id){

        $host_data = User::where('unique_id',$unique_id)->first();
        $host_details = DB::table('users')->where('unique_id',$unique_id)->first();
        
        //   Available Host
        $today_date = date("Y-m-d H:m");
    //    $date = "2023-02-28 14:30";
        $host_schedule = HostAvailablity::where([['host_id','=',$host_data['_id']],['end','>=',$today_date]])->get(['title','start','end','status']);
        
        $available_host = array();
        
        if(isset($host_schedule) || !empty($host_schedule)){
            foreach($host_schedule as $schedule){
                $start_datetime = new DateTime($schedule['start']); 
                $end_datetime = new DateTime($schedule['end']);
               
                $diff = $start_datetime->diff($end_datetime); 
                $diff_in_hours = $diff->h;
                $diff_in_minutes = $diff->i;
                // dd($diff );
                if(($schedule->status == 1) && (($diff_in_hours > 0 ) || ($diff_in_minutes >= 30))){
                    $available_host[] =  array(
                        'id'       => $schedule['id'],
                        'title'    =>  $schedule['title'],
                        'start'    =>  $schedule['start'],
                        'end'      =>  $schedule['end'],
                        'status'   =>  $schedule['status'],
                        'type'     =>  'available_host',
                        'color'    =>  '#6294a7',
                        'allDay'   =>  false,
                    );
                }
                if(($schedule['start'] == $schedule['end']) || (($diff_in_hours == 0) && ($diff_in_minutes < 30))){
                    $available_host[] =  array(
                        'id'       => $schedule['id'],
                        'title'    =>  $schedule['title'],
                        'start'    =>  $schedule['start'],
                        'end'      =>  $schedule['end'],
                        'status'   =>  $schedule['status'],
                        'type'     =>  'duration_below_thirty',
                        'color'    =>  '#EE4B2B',
                        'allDay'   =>  false,
                    );
                }
            }
        }

     

        //  Host Meetings 

        $host_appointments = HostAppointments::where([['host_id','=',$host_data['_id']],['end','>=',$today_date]])->get(['start','end','status']);
        if(isset($host_appointments) || !empty($host_appointments)){
            foreach($host_appointments as $meetings){
                if($schedule->status == 1){
                    $available_host[] =  array(
                        'id'       =>  $meetings['id'],
                        'start'    =>  $meetings['start'],
                        'end'      =>  $meetings['end'],
                        'status'   =>  $meetings['status'],
                        'type'     =>  'schedule_meeting',
                        'color'    =>  '#dd8585',
                        'allDay'   =>  false,
                    );
                } 
            }
        }
        
        // if($req->ajax()) {
         
          
        // }
       
        // dd($available_host);
        return view('Guests.search-host.host-detail',compact('host_details','available_host'));
        // return view('Guests.search-host.host-detail',compact('host_details','available_host'));
  
    }

    // Schedule meetings 

    public function scheduleMeeting(Request $req ){
      
        switch ($req->type) {
            case 'add':
                //  Appointment data create
            if(Auth::check()){
                $newAppointment = new HostAppointments;
                $newAppointment->host_available_id = $req->available_id;
                $newAppointment->user_id = $req->user_id;
                $newAppointment->host_id = $req->host_id;
                $newAppointment->guest_name = $req->name;
                $newAppointment->guest_email = $req->email;
                $newAppointment->start = date('Y-m-d H:i', strtotime($req->start));
                $newAppointment->end = date('Y-m-d H:i', strtotime($req->end));
                $newAppointment->status = $req->status;
                $newAppointment->save();
                $user = User::find($req->user_id); 
            }else{
                $req->validate([
                    'email' => 'required|unique:users',
                ]);
                $name = $req->name;
                $namestr = str_replace(' ', '', $name);
                $pass = substr($namestr, 0, 4).'@'.rand(100,999);
                $password = Hash::make($pass);
                $data = array(
                    'email' => $req->email,
                    'password' => $password,
                    'first_name' => $name,
                    'status' => 0
                );
                $user = User::create($data);
                $credentials = array('email'=>$req->email, 'password' => $pass);
                Auth::attempt($credentials);
                $mailData = [
                    'email' => $req->email,
                    'password' => $pass
                ];
                $passwordmail = Mail::to($req->email)->send(new SendpasswordMail($mailData));
                $newAppointment = new HostAppointments;
                $newAppointment->host_available_id = $req->available_id;
                $newAppointment->user_id = $user->_id;
                $newAppointment->host_id = $req->host_id;
                $newAppointment->guest_name = $req->name;
                $newAppointment->guest_email = $req->email;
                $newAppointment->start = date('Y-m-d H:i', strtotime($req->start));
                $newAppointment->end = date('Y-m-d H:i', strtotime($req->end));
                $newAppointment->status = $req->status;
                $newAppointment->save();
                $user = User::find($user->_id); 
            }
                //  Host availablity update
                
                $host = User::find($req->host_id);
                $uemail = $user->email;
                $hostmail = $host->email;
                
                    
                $mailData = [
                    'hostname' => $user->first_name.' '.$user->last_name,
                    'username' => $user->first_name.' '.$user->last_name,
                    'start' => $req->start,
                    'end' => $req->end,
                ];
                
                $mail = Mail::to($uemail)->send(new appoinmentsconfirmation($mailData));
                $hostmail = Mail::to($hostmail)->send(new HostAppoinmentsMail($mailData));
                $meeting_end_time =  strtotime($req->end);
                $updated_host_available_time =  date('Y-m-d H:i', strtotime('+30 minutes',$meeting_end_time));
                

                $host_availablity =  HostAvailablity::where('_id',$req->available_id)->first();

                if($host_availablity->end > $updated_host_available_time){
                    $host_availablity->start = $updated_host_available_time;
                    $host_availablity->update();
                }else{
                    $host_availablity->start = date('Y-m-d H:i',$meeting_end_time);
                    $host_availablity->update();
                }
                
                $event = array(
                    'id' => $newAppointment['id'],
                    'start' => $newAppointment['start'],
                    'end' => $newAppointment['end'],
                    'status' => $newAppointment['status'],
                    'type'     =>  'schedule_meeting',
                    'color'    =>  '#dd8585',
                    'allDay'   =>  false,
                );
                //    return $event;
               return response()->json($event);

              break;
            }
    }
    public function searchhost(Request $req){
        if($req->data == null){
            $hosts = DB::table('users')->where('status',1)->where('public_visibility',1)->get();
        }else{
            if($req->cat == 1){
                $full_name = explode(" ", $req->data);
                $count = count($full_name);
                if($count < 2){
                    $hosts = DB::table('users')->orWhere('first_name','like',$req->data.'%')->where('status',1)->where('public_visibility',1)->orWhere('last_name','like',$req->data.'%')->get();
                }else{
                    $hosts = DB::table('users')->orWhere([['first_name','like',$full_name[0]],['last_name','like',$full_name[1].'%']])->orWhere('first_name',$req->data)->where('status',1)->where('public_visibility',1)->get();
                } 
            }elseif($req->cat == 2){
                $hosts = DB::table('users')->where('unique_id','like',$req->data.'%')->where('status',1)->where('public_visibility',1)->get();
            }
            elseif($req->cat == 3){
               
                $data = Tags::where('name','like',$req->data.'%')->with(['users' => function($response){ $response->where([['status',1],['public_visibility',1]]); }])->get();
                $hosts = array();
                foreach($data as $d){
                    $host = $d->users;
                    array_push($hosts,$host);
                }
            }
        }
        return response()->json($hosts);
    }
//   
public function trycode(){
//     $messages = Messages::where([['reciever_id','63fd8e4d1ad0d9aee603e4d2'],['status',1]])->distinct('sender_id')->get()->toArray();
//     if($messages){
//     foreach($messages as $m){
//         $user = User::where('_id',$m[0])->with('adminmessage',function($response){ $response->where('reciever_id','63fd8e4d1ad0d9aee603e4d2'); })->first();
    
//     print_r($messages);
// }
//     }
// $reciever_id = '63fd8e4d1ad0d9aee603e4d2';
// $messages = Messages::where('reciever_id',$reciever_id)->orWhere('sender_id',$reciever_id)->orderBy('created_at','desc')->get();
// $ids = array();
// foreach($messages as $m){
//    array_push($ids,$m->sender_id);
//    array_push($ids,$m->reciever_id);
// }
// // print_r($ids);
//     $message_id =array_unique($ids); 
    
//     foreach($message_id as $mid){
//        $users[] = User::where('_id',$mid)->with('adminmessage',function($response){ $response->where([['reciever_id','63fd8e4d1ad0d9aee603e4d2'],['status',1]]); })->first(); 
//     }
//     dd($users);
$sid = getenv("TWILIO_ACCOUNT_SID");
$token = getenv("TWILIO_AUTH_TOKEN");
$twilio = new Client($sid, $token);
return view('trycode');
}

}
