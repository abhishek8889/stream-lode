<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use DB;
class TestController extends Controller
{
    //
    public function index(){
       $user = DB::table('users')
                ->join('membership' , 'user.membership_id' , '=' ,'membership._id')->get('users.*', 'membership.*');
                
                dd($user);
    }
}
