<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use DB;
class UserListController extends Controller
{
    public function hostList(){
        $hosts = DB::table('users')->where('status', 1)->get();
        return view('Admin.users.hostlist',compact('hosts'));
    }
    public function hostDetail(Request $req , $id){
        $host_detail = DB::table('users')->where('unique_id', $id)->first();
        // dd($host_detail);
        return view('Admin.users.host_detail',compact('host_detail'));
    }
    public function hostDelete($id){
        
        DB::table('users')->where('unique_id', $id)->delete();
        return redirect('/admin/host-list')->with('success','User is deleted succesfully');
    }
}
