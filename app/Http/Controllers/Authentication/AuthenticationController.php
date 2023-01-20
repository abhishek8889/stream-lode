<?php

namespace App\Http\Controllers\Authentication;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Hash;
use Auth;


class AuthenticationController extends Controller
{
    public function login(){
        return view('Authentications.login');
    }
    public function register(){
        return view('Authentications.register');
    }
    public function loginProcess(request $req){
      
        $email = $req->email;
        $password = $req->password;
        $credentials = array('email'=>$email, 'password' => $password);
        if (Auth::attempt($credentials)) {
            if(auth()->user()->status == 0){
                return redirect('/');
            }
            else if(auth()->user()->status == 1){
                return redirect('/'.auth()->user()->unique_id);
            }
            else if(auth()->user()->status == 2){
                return redirect('admin/dashboard');
            }else{
                return false;
            }
        }else{
            return 'there is an error';
        }
    }
    public function registerProcess(request $req){
    //   dd($req);
       $req->validate([
        'first_name' => 'required',
        'last_name' => 'required',
        'unique_id' => 'required|unique:users',
        'email' => 'required|email|unique:users',
        'phone' => 'required',
        'password'=>'required|min:6',

        ]);
        // $email = $req->email;
        // $str_result = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
        // $random_string = substr(str_shuffle($str_result),0,5);
        // if(strpos($req->name, ' ')){
        //     $first_name = substr($req->name, 0, strpos($req->name, ' '));
        // }else{
        //    $first_name = $req->name;
        // }
        // $unique_id = $first_name. rand(pow(10, 8 - 1), pow(10, 8) -1);

        $password = Hash::make($req->password);
        $data = array(
            'first_name' => $req->first_name,
            'last_name' => $req->last_name,
            'email' => $req->email,
            'unique_id' => $req->unique_id,
            'phone' => $req->phone,
            'public_visibility' => 1,
            'password' => $password,
            'status' => 0 // user status 0 = guest ; 1 = host ; 2 = admin
        );
        User::create($data);
         
         return redirect()->route('login');
    }
    public function updatePassword(Request $req){
        $req->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:6',
            'confirm_new_password' => 'required_with:new_password|same:new_password|'
            ],[
                'current_password.required' => 'Your current password must be required',
                'new_password.required' => 'Your new password must be required',
                'new_password.min:6' => 'Your new password must be atleast 6 character',
                'confirm_new_password.required' => 'Your confirm new password must be required',
                'confirm_new_password.same:new_password' => 'Your confirm new password must be same as new password'
            ] 
        );
        $matchPassword=  Hash::check($req->current_password, auth()->user()->password);
        if($matchPassword == true){
            $password_change_status = User::find(auth()->user()->id)->update(['password'=> Hash::make($req->confirm_new_password)]);
            if($password_change_status == true){
                // logout from other session remain
                return redirect('/'.auth()->user()->unique_id.'/change-password')->with('success','Your password is changed succesfully.');
            }
        }else{
            return redirect('/'.auth()->user()->unique_id.'/change-password')->with('error','Your old password is not matched.');
        }
    }
    public function logout(){
    Auth::logout();
    return redirect('/')->with('success',"You have logged out succesfully");
    }
}
