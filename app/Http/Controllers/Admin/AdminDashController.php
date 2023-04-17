<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MembershipPaymentsData;
use App\Models\User;
use App\Models\Visitor;

class AdminDashController extends Controller
{
    public function index(){
        /// Membership total payment //
        $membership_payments = MembershipPaymentsData::where('payment_status','succesfull')->get();
        $total_membership_amount = 0;
        if(count($membership_payments) != 0){
            foreach($membership_payments as $mp){
            $payments[] = $mp->total;
            $payments[] = $mp->payment_amount;
            }
            if($payments){
                $total_membership_amount = array_sum($payments);
            }
        }
        // Users count
        $users = User::get();
        $Visitors = Visitor::count();
        return view("Admin.Dashboard.index",compact('total_membership_amount','users','Visitors'));
    }
}
