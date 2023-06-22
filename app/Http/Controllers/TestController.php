<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use DB;
use App\Events\SendNotifications;
use App\Models\HostAppointments;
use App\Jobs\SendEmail;
use Illuminate\Support\Facades\Mail;
use App\Mail\WakeUpGuestItsMeetingTime;
use App\Mail\WakeUpHostItsMeetingTime;
class TestController extends Controller
{
    //
    public function index(){
       $name = "Abhishek sharma";
       $age = 21;
       $data = ['name' => $name, 'age' => $age];
       $event_status = event( new SendNotifications($data));
    //    return $event_status;
    }
    public function returnFromListener(){
      echo hello("Abhishek");
    
    }
    public function sendTestEmail(){
        $data  = "This is test data ";
        $name = "Abhishek";
        dispatch( new SendEmail($data,$name));
        return "email sent succesfully";
    }
    public function test(){
        $stripe = new \Stripe\StripeClient( env('STRIPE_SEC_KEY') );
        // $invoice = $stripe->invoices->retrieve( 
        // 'in_1NEWhSACt8qMxlDkVvkSmbrT',
        // []
        // );
        // dd($invoice);
        // return $invoice;
        // $pi = $stripe->paymentIntents->retrieve(
        //     'pi_3NES7zACt8qMxlDk03SgMGui',[]
        // );
        
        $date_string = "2023-Jun-06 08:22";
        $stripe_date = 1686054452;
        $object_created = date('Y-M-d H:i' ,$stripe_date);

            if($date_string <= $object_created){
                echo 'date string is lesser and data entry will be saved ';
            }else{
                echo 'date string is bigger';
            }
      
    }
}