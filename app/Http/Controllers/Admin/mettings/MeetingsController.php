<?php

namespace App\Http\Controllers\Admin\mettings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\HostAppointments;
use App\Models\User;


class MeetingsController extends Controller
{
  public function index(){
    $user = User::where('status',1)->with('appoinments')->paginate(5);
    // dd($user);
    return view('Admin.mettings.index',compact('user'));
  }
}
