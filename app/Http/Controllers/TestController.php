<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use DB;
use App\Events\SendNotifications;
use App\Jobs\SendEmail;
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
      echo 'statrt' . date('Y-M-d H:i:s','1681898320');
      echo "end " . date('Y-M-d H:i:s','1684490320');
    }
}
