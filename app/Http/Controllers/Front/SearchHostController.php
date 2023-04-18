<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Tags;
use App\Models\Messages;
use Illuminate\Support\Facades\Mail;
use App\Mail\AppoinmentsConfirmation;
use App\Mail\HostAppoinmentsMail;
use App\Mail\SendpasswordMail;
use App\Models\HostAvailablity;
use App\Models\PostNotification;
use App\Models\HostAppointments;
use Illuminate\Support\Facades\DB;
use Auth;
use Hash;
use DateTime;
use Twilio\Rest\Client;
use App\Events\NotificationsSend;
use Twilio\Jwt\AccessToken;
use Twilio\Jwt\Grants\VideoGrant;
use App\Models\MeetingCharge;
use App\Events\AppoinmentNotification;
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
        foreach($host_details['_id'] as $h){
           $host_id = $h;
        }
        
        $host_meeting_charges = MeetingCharge::where('host_id',$host_id)->get();
        
        //   Available Host
        $today_date = date("Y-m-d H:i");
        
    //    $date = "2023-02-28 14:30";
        $host_schedule = HostAvailablity::where([['host_id','=',$host_data['_id']],['end','>=',$today_date]])->get(['title','start','end','status']);
        // dd($host_schedule);
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
            // dd($host_appointments);
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
        return view('Guests.search-host.host-detail',compact('host_details','available_host','host_meeting_charges'));
        // return view('Guests.search-host.host-detail',compact('host_details','available_host'));
  
    }

    // Schedule meetings 

    public function scheduleMeeting(Request $req ){
        if(Auth::check()){
            $createAppointment = $this->makeAppointments($req->user_id,$req->available_id,$req->host_id,$req->start,$req->end,$req->duration, $req->status); 
        }else{
            $req->validate([
                'email' => 'required|unique:users',
            ]);
            $name = $req->name;
            $email = $req->email;
            $user_create = $this->createNewUser($name,$email);
            if($user_create->_id){
                $createAppointment = $this->makeAppointments($user_create->_id,$req->available_id,$req->host_id,$req->start,$req->end,$req->duration,$req->status);
            }
        }
        return response()->json($createAppointment);
    }
    public function makeAppointments($guest_id,$host_available_id,$host_id,$appointment_start,$appointment_end,$duration_in_minutes,$appointment_status){
        $today_date = date("Y-m-d H:i");
        $guest = User::find($guest_id);

        $host_availablity =  HostAvailablity::where('_id',$host_available_id)->first();
        $host_appointments = HostAppointments::where([['host_available_id','=',$host_available_id],['end','>=',$today_date]])->orderBy('end','ASC')->get();
        
        $host_meeting_details = MeetingCharge::where([['host_id','=',$host_id],['duration_in_minutes','=',$duration_in_minutes]])->first();
        $host_meeting_charges = $host_meeting_details->amount;
        $required_currency = $host_meeting_details->currency;
       
        // Time
        $meeting_start = date('Y-m-d H:i', strtotime($appointment_start));
        $meeting_end = date('Y-m-d H:i', strtotime($appointment_end));

        $required_start_time =  strtotime($appointment_start);
        $required_end_time =  strtotime($appointment_end);

        $required_start_time = date('Y-m-d H:i', strtotime('-30 minutes',$required_start_time));
        $required_end_time = date('Y-m-d H:i', strtotime('+30 minutes',$required_end_time));
        
        // $stripe = new \Stripe\StripeClient(env('STRIPE_SEC_KEY'));
        //  $stripe_payment_intent =  $stripe->paymentIntents->create([
        //     'amount' => $host_meeting_charges,
        //     'currency' => $required_currency,
        //     'automatic_payment_methods' => [
        //       'enabled' => true,
        //     ],
        //   ]);


        $newAppointment = '';
        if(count($host_appointments) == 0){
            $newAppointment = new HostAppointments;
            $newAppointment->host_available_id = $host_available_id;
            $newAppointment->user_id = $guest->_id;
            $newAppointment->host_id = $host_id;
            $newAppointment->guest_name = $guest->first_name;
            $newAppointment->guest_email = $guest->email;
            $newAppointment->start = $meeting_start;
            $newAppointment->end = $meeting_end;
            $newAppointment->duration_in_minutes = $duration_in_minutes;
            $newAppointment->meeting_charges = $host_meeting_charges;
            $newAppointment->currency = $required_currency;
            // $newAppointment->stripe_payment_intent = $stripe_payment_intent->id;
            // $newAppointment->stripe_client_secret = $stripe_payment_intent->client_secret;
            $newAppointment->payment_status = 0;
            $newAppointment->status = $appointment_status;
            $newAppointment->seen_status = 0;
            $newAppointment->save();
            return array('status'=> true , 'message' => 'You have succesfully scheduled your apoointment with host');
        }else{
            foreach($host_appointments as $hs){
                if($hs['start'] < $required_start_time && $hs['end'] > $required_start_time ){
                   return array('status'=> false , 'message' => 'Sorry ! This slot is already booked.');
                }
                elseif($hs['end'] > $required_start_time && $hs['start'] < $required_end_time ){
                    return array('status'=> false , 'message' => 'Sorry ! This slot is already booked.');
                }
            }
            $newAppointment = new HostAppointments;
            $newAppointment->host_available_id = $host_available_id;
            $newAppointment->user_id = $guest->_id;
            $newAppointment->host_id = $host_id;
            $newAppointment->guest_name = $guest->first_name;
            $newAppointment->guest_email = $guest->email;
            $newAppointment->start = $meeting_start;
            $newAppointment->end = $meeting_end;
            $newAppointment->duration_in_minutes = $duration_in_minutes;
            $newAppointment->meeting_charges = $host_meeting_charges;
            $newAppointment->currency = $required_currency;
            // $newAppointment->stripe_payment_intent = $stripe_payment_intent->id;
            // $newAppointment->stripe_client_secret = $stripe_payment_intent->client_secret;
            $newAppointment->payment_status = 0;
            $newAppointment->status = $appointment_status;
            $newAppointment->seen_status = 0;
            $newAppointment->save();
        }

        // Send notification to host and guest for there meetings 

         $host = User::find($host_id);
            $uemail = $guest->email;
            $hostmail = $host->email;
            
                
            $mailData = [
                'hostname' => $host->first_name.' '.$host->last_name,
                'username' => $guest->first_name.' '.$guest->last_name,
                'start' => $meeting_start,
                'end' => $meeting_end,
            ];
            
            $mail = Mail::to($uemail)->send(new AppoinmentsConfirmation($mailData));
            $hostmail = Mail::to($hostmail)->send(new HostAppoinmentsMail($mailData));
            event(new NotificationsSend($host_id,$newAppointment));
            return array('status'=> true , 'message' => 'You have succesfully scheduled your apoointment with host');

    }
    public function createNewUser($name, $email){
        // creating user and login
        $namestr = str_replace(' ', '', $name);
        $pass = substr($namestr, 0, 4).'@'.rand(100,999);
        $password = Hash::make($pass);
        $data = array(
            'email' => $email,
            'password' => $password,
            'first_name' => $name,
            'status' => 0
        );
        $user = User::create($data);
        $credentials = array('email'=>$email, 'password' => $pass);
        Auth::attempt($credentials);
        $mailData = [
            'email' => $email,
            'password' => $pass
        ];
        $passwordmail = Mail::to($email)->send(new SendpasswordMail($mailData));
        $user = User::find($user->_id);
        return $user;
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
  
public function trycode(){
   
}

}
