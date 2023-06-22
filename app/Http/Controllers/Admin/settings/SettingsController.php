<?php

namespace App\Http\Controllers\Admin\settings;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Sitemeta;
use File;

class SettingsController extends Controller
{
    //
    public function index(){
        return view('Admin.settings.generals');
    }
    public function adminUpdate(Request $req){
        // return $req->all();
        // dd($req->id);
        $req->validate([
            'email' => 'required',
        ]);
        
        $user = User::find($req->id);
        $user->first_name = $req->first_name;
        $user->last_name = $req->last_name;
        $user->phone = $req->phone;
        $user->email = $req->email;
        $user->update();
        return redirect(url('/admin/general-settings'))->with('success','Updates are succesfully done.');
    }
    public function addProfilePic(Request $req){
        // return $req->all();
        
        $req->validate([
            'profile_img' => 'required',
        ],
        [
            'profile_img.required' => 'You have to choose any image before upload.',
        ]);
        $user = User::find($req->id);
        if($req->profile_exist == '1'){
            if($req->hasfile('profile_img')){
                $destination = public_path().'/Assets/images/user-profile-images/'. auth()->user()->profile_image_name;
                if(File::exists($destination)){
                    File::delete($destination);
                }
                $file = $req->file('profile_img');
                $name = time().rand(1,100).'.'.$file->extension();
                $file->move(public_path().'/Assets/images/user-profile-images/', $name);
                $user->profile_image_name = $name;
                $user->profile_image_url = asset('Assets/images/user-profile-images/'.$name);
                $user->update();
            }
            return redirect('/admin/general-settings')->with('success','Profile picture uploaded succesfully.');
        }else{
            if($req->hasfile('profile_img')){
                $file = $req->file('profile_img');
                $name = time().rand(1,100).'.'.$file->extension();
                $file->move(public_path().'/Assets/images/user-profile-images/', $name);
                $user->profile_image_name = $name;
                $user->profile_image_url = asset('Assets/images/user-profile-images/'.$name);
                $user->save();
            }
            return redirect('/admin/general-settings')->with('success','New profile picture added succesfully.');
        }
       
    }
    public function sitemeta(){
        $sitemeta = Sitemeta::first();
       return view('Admin.settings.sitemeta',compact('sitemeta'));
    }
    public function sitemetaadd(Request $request){
        $sitemeta = Sitemeta::first()->_id;
      $request->validate([
        'help_email' => 'required'
      ]);
        $sitemeta = Sitemeta::find($sitemeta);
        $sitemeta->help_email = $request->help_email;
        $sitemeta->facebook_link = $request->facebook;
        $sitemeta->twitter_link = $request->twitter;
        $sitemeta->linkedin_link = $request->linkedin;
        $sitemeta->instagram_link = $request->instagram;
        $sitemeta->update();
return redirect()->back()->with('success','successfully update site meta');

        
    }
    public function changepassword(){
        
    return view('Admin.settings.changepassword');
    }
   
}
