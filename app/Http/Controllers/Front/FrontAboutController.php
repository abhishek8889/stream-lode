<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Mail\HelpMail;
use App\Models\User;
use App\Models\Sitemeta;
use Illuminate\Support\Facades\Mail;

class FrontAboutController extends Controller
{
    //
    public function index(){
        return view('Guests.about.index');
    }
    public function helpFormSubmit(Request $request){
        $admin = Sitemeta::first();
        $request->validate([
            'fname' => 'required',
            'email' => 'required',
            'message' => 'required',
        ]);
        $mailData = array(
            'name' => $request->fname,
            'email' => $request->email,
            'message' => $request->message
        );
        
        $mail = Mail::to($admin->help_email)->send(new HelpMail($mailData));
        return response()->json('successfully sent mail');
        // return $mail;
    }
}
