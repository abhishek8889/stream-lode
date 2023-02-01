<?php

namespace App\Http\Controllers\Hosts;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HostCalendar extends Controller
{
    //
    public function index(){
        return view("Host.calendar.index");
    }
}
