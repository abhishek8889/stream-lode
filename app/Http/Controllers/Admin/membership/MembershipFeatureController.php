<?php

namespace App\Http\Controllers\Admin\membership;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MembershipFeature;


class MembershipFeatureController extends Controller
{
    public function index(){
        $features = MembershipFeature::get();
        // dd($features);

        return view('Admin.membership.add_membership_features',compact('features'));
    }
    public function featureadd(Request $req){
        $req->validate([
            'feature_name' => 'required',
            'description' => 'required'
        ]);
        if($req->id == null){
            $feature = new MembershipFeature();
            $feature->feature_name = $req->feature_name;
            $feature->description = $req->description;
            $feature->save();
            return back()->with('success','successfully saved feature');
        }else{
            $feature = MembershipFeature::find($req->id);
            $feature->feature_name = $req->feature_name;
            $feature->description = $req->description;
            $feature->update();
            return back()->with('success','successfully updated feature');
        }

    }
    public function edit(Request $req){
        if($req->res == 1){
        $data = MembershipFeature::find($req->id);
        return response()->json($data);
        }elseif($req->res == 0){
            $data = MembershipFeature::find($req->id);
            $data->delete();
            return response()->json('done');
        }
    }
}
