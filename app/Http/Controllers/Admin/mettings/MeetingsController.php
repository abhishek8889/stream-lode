<?php

namespace App\Http\Controllers\Admin\mettings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\HostAppointments;

class MeetingsController extends Controller
{
  public function index(){
    $data = HostAppointments::with(['user'])->get();
    dd($data);
    // echo '<pre>';
    // print_r($data);
    // echo '</pre>';
    return view('Admin.mettings.index');
  }
}
