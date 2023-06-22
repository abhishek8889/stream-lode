<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Visitor;

class HomeController extends Controller
{
    //
    public function index(){
        $clientIP = request()->ip();
        // dd($clientIP);
        if(!empty($clientIP)){
            if (Visitor::where('ip_address', '=', $clientIP)->exists()) {
                return view('Guests.home');
            }else{
                $Visitor = new Visitor;
                $Visitor->ip_address = $clientIP;
                $Visitor->save();
             }
        } 
        return view('Guests.home');
    }
}
