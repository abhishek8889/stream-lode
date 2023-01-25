<?php

namespace App\Http\Controllers\Hosts;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MembershipTier;

class HostDashController extends Controller
{
    public function index(){
        $membership_details = '';
        $membership_name = '';
        if(isset(auth()->user()->membership_id) || !empty(auth()->user()->membership_id))
        {
            $membership_details = MembershipTier::Where('_id',auth()->user()->membership_id)->first();
            $membership_name = $membership_details['name'];
           
        }
       
        return view('Host.Dashboard.index',compact('membership_details'));
    }
}
