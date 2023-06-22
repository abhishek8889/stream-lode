<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MembershipPaymentsData;
use App\Models\User;
use App\Models\Visitor;
use DB;
class AdminDashController extends Controller
{
    public function index(){
        /// Membership total payment //
        $membership_payments = MembershipPaymentsData::where('payment_status','succesfull')->get();
        $total_membership_amount = 0;
        $payments = array();
        if(count($membership_payments) != 0){
            foreach($membership_payments as $mp){
            $payments[] = $mp->total;
            $payments[] = $mp->payment_amount;
            }
            if($payments){
                $total_membership_amount = array_sum($payments);
            }
        }
        $total_membership_amount = array_sum($payments);
        /// Users count
        $users = User::where('status','!=',2)->get();
        $Visitors = Visitor::count();

        //  Count total streaming Income
        $streams_payment = DB::table('streams_payment')->where('total','!=',null)->get(['total']);
        $streamspayment = array();
        for($i = 0; $i < count($streams_payment); $i++){
            if(count($streams_payment[$i]) == 2){
                $streamspayment[] = $streams_payment[$i]['total'];
            }
        }
       return view("Admin.Dashboard.index",compact('total_membership_amount','users','Visitors','streamspayment'));
    }
}
