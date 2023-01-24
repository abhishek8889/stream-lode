<?php

namespace App\Http\Controllers\Hosts;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MembershipTier;

class HostMembershipController extends Controller
{
    public function index(){
        $membership_details = MembershipTier::all();
        // dd($membership_details);
        return view('Host.membership.index',compact('membership_details'));
    }
    public function subscribe(Request $req){
       return view('Host.membership.subscribe');
    }
}
