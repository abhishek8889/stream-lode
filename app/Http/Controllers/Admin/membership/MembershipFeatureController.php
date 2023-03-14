<?php

namespace App\Http\Controllers\Admin\membership;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MembershipFeature;
use App\Models\MembershipTier;


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
            $membership = MembershipTier::get();
            foreach($membership as $m){
                $id = MembershipTier::find($m['_id']);
                $featureid = $id->membership_features;
                // $id[] = $m['_id'];
                if(($key = array_search($req->id, $featureid)) !== false) {
                    unset($featureid[$key]);
                }
                $id->membership_features = $featureid;
                $id->update();

            }
            return response()->json('done');
        }
    }
}
