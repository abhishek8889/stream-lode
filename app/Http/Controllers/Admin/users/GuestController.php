<?php

namespace App\Http\Controllers\Admin\users;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
// use app\Models\User;
class GuestController extends Controller
{
    //
    public function guestlist(){
        $guests = DB::table('users')->where('status', 0)->get();
        // dd($guests);
        return view('Admin.users.guestlist',compact('guests'));
    }
}
