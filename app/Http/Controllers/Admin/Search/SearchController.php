<?php

namespace App\Http\Controllers\Admin\Search;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Messages;
use App\Models\MembershipTier;
use App\Models\MembershipPaymentsData;
use App\Models\StreamPayment;
use App\Events\Message;
use DB;
use Hash;
use Auth;
use File;
class SearchController extends Controller
{
    public function index(Request $request){
        if($request->has('hostlist')){
            $searchQuery = $request->search;
            if($searchQuery == null){
                $users = User::where('status', 1)
                ->with(['adminmessage' => function($query){
                    $query->where('receiver_id',Auth::user()->id);
                },'MembershipTier'])
                ->paginate(10);
            }else{
            $users = User::where('unique_id', 'LIKE', "%" . $searchQuery . "%")
                ->where('status', 1)
                ->with(['adminmessage' => function($query){
                    $query->where('receiver_id',Auth::user()->id);
                },'MembershipTier'])
                ->paginate(10);
            }
            return response()->json($users);
        }

        if($request->has('guestlist')){
            $searchQuery = $request->search;
            if($searchQuery == null){
                $guests = DB::table('users')->where('status', 0)->paginate(10);
            }else{
                $guests = DB::table('users')->where('first_name', 'LIKE', "%" . $searchQuery . "%")->where('status', 0)->paginate(10);
            }
            
           return response()->json($guests);
        }

        if($request->has('paymentList')){

            $searchQuery = $request->input('search');
            $userIds = MembershipPaymentsData::pluck('user_id')->unique()->toArray();
            $membership_payments_list = [];
           
            foreach ($userIds as $userId) {
                 if($searchQuery == null){
                    $user = User::with(['payments' => function ($query) {
                        $query->orderBy('created_at', 'DESC');
                    },'MembershipTier'])->find($userId);
            }else{
                $user = User::where('unique_id', 'LIKE', '%' . $searchQuery . '%')
                    ->with(['payments' => function ($query) {
                        $query->orderBy('created_at', 'DESC');
                    },'MembershipTier'])->find($userId);
                }

                if ($user) {
                    $membership_payments_list[] = $user;
                }
            }

            return response()->json($membership_payments_list);

        }

        if ($request->has('streamPayment')) {
            $searchQuery = $request->search;
            $stream_payments = StreamPayment::with('appoinments', 'appoinments.user')->get();
            $userdata = array();
            foreach ($stream_payments as $d) {
                $userdata[] = $d['appoinments']['user'];
            }
            $data = array_unique($userdata, SORT_REGULAR);
            $stream_data = array();
            foreach ($data as $d) {
                $stream_data[] = User::where('unique_id', 'LIKE', '%' . $searchQuery . '%')
                    ->with(['appoinments' => function($response) {
                        $response->orderBy('created_at', 'DESC');
                    }])
                    ->with(['streampayment' => function($response) {
                        $response->orderBy('created_at', 'DESC');
                    }])
                    ->get(); 
            }
            return response()->json($stream_data);
        }
        


        return response()->json(['error' => 'Search query missing']);
    }
    
    
}
