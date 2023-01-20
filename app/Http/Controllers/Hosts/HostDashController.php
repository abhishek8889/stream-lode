<?php

namespace App\Http\Controllers\Hosts;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HostDashController extends Controller
{
    public function index(){
        return view('Host.Dashboard.index');
    }
}
