<?php

namespace App\Http\Controllers\Admin\users;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use DB;
use Hash;
class HostController extends Controller
{
    public function hostList(){
        $hosts = DB::table('users')->where('status', 1)->get();
        
        return view('Admin.users.hostlist',compact('hosts'));
    }
    public function hostDetail(Request $req , $id){
        $host_detail = DB::table('users')->where('unique_id', $id)->first();
        return view('Admin.users.host_detail',compact('host_detail'));
    }
    public function hostDelete($id){
        DB::table('users')->where('unique_id', $id)->delete();
        return redirect('/admin/host-list')->with('success','User is deleted succesfully');
    }
    public function hostGeneralsUpdate(Request $req){
        // return $req->all();
        $host_id = $req->id;
        $host_unique_id = $req->unique_id;
        $user = User::find($host_id);
        if($req->newPassword != null && $req->confirmNewPassword != null){
            // update user with password 
            $req->validate([
                'newPassword' => 'required',
                'confirmNewPassword' => 'required|min:6|same:newPassword|'
                ],[
                    'newPassword.required' => 'This field is required.',
                    'confirmNewPassword.required' => "Password and confirm password both field are required if you want to change host's password. ",
                    'confirmNewPassword.min:6' => "Host's new password must be atleast 6 character",
                    'confirmNewPassword.same:newPassword' => "Your confirm new password must be same as new password."
                ] 
            );
            $password_change_status = User::find($host_id)->update(['password'=> Hash::make($req->confirmNewPassword)]);
            $user->first_name = $req->first_name;
            $user->last_name = $req->last_name;
            $user->email = $req->email;
            $user->phone = $req->phone;
            if(isset($req->hide_profile) || $req->hide_profile == "on"){
                $user->public_visibility = 0; // public visibility 0 means private
            }else{
                $user->public_visibility = 1; // public visibility 1 means public
            }
            $user->update();
            return redirect('/admin/host-details/'.$host_unique_id)->with('success','Host '.$req->first_name . ' '. $req->last_name. 'updated succesfully.');
        }else{
            $user->first_name = $req->first_name;
            $user->last_name = $req->last_name;
            $user->email = $req->email;
            $user->phone = $req->phone;
            if(isset($req->hide_profile) || $req->hide_profile == "on"){
                $user->public_visibility = 0; // public visibility 0 means private
            }else{
                $user->public_visibility = 1; // public visibility 1 means public
            }
            $user->update();
            return redirect('/admin/host-details/'.$host_unique_id)->with('success','Host '.$req->first_name . ' '. $req->last_name. 'updated succesfully.');

        }
    }
}
