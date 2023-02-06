<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

use App\Models\HostAvailablity;
use App\Models\HostAppointments;
use Illuminate\Support\Facades\DB;
use stdClass;

class SearchHostController extends Controller
{
    //
    public function index(){
        $hosts = DB::table('users')->where('status',1)->get();
        // $tags = Tags::where('user_id','63c942d6aa1425079f0bae4c')->get();
        // dd($tags);
        return view('Guests.search-host.index',compact('hosts'));
    }
    public function hostDetail(Request $req , $unique_id){
        $host_data = User::where('unique_id',$unique_id)->first();
        $host_details = DB::table('users')->where('unique_id',$unique_id)->first();
      
        $host_availablity = HostAvailablity::where('host_id',$host_data['_id'])->get(['title','start','end','status']);
        // $availablity = new stdClass;
        // foreach($host_availablity as $avilable){
        //     if($avilable->status == 1){
        //         $availablity->id = $avilable['id'];
        //         $availablity->title = $avilable['title'];
        //         $availablity->start = $avilable['start'];
        //         $availablity->end = $avilable['end'];
        //         $availablity->status = $avilable['status'];
        //     } 
        // }
        // dd($availablity);
        return view('Guests.search-host.host-detail',compact('host_details'));
    }
}
