<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

class MainController extends Controller
{
    //
    protected $user_name;
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->user_name = Auth::user()->first_name;
            echo $this->user_name;
            return $next($request);
        });
        // echo $this->user_name;
    }

}
