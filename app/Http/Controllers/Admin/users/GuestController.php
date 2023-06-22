<?php

namespace App\Http\Controllers\Admin\users;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Hash;
use App\Models\User;

class GuestController extends Controller
{
    //
    public function guestlist(){
        $guests = DB::table('users')->where('status', 0)->paginate(10);
        return view('Admin.users.guestlist',compact('guests'));
    }
    public function hostdetail($id){
     $guest_detail = User::find($id);
     return view('Admin.users.guest_detail',compact('guest_detail'));
    }
    public function update(Request $req){
        if($req->newPassword && $req->confirmNewPassword){
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
        $change_password = User::find($req->id)->update(['password'=>Hash::make($req->confirmNewPassword)]);
    }
    $guest_detail = User::find($req->id);
    $guest_detail->first_name = $req->first_name;
    $guest_detail->last_name = $req->last_name;
    $guest_detail->email = $req->email;
    $guest_detail->update();
    return redirect()->back()->with('success','successfully updated user details');
        
    }
    public function guestdelete($id){
        $guest = User::find($id)->delete();
        return redirect()->back()->with('success','success deleted guest');

    }
}
