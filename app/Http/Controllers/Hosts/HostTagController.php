<?php

namespace App\Http\Controllers\Hosts;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tags;
use DB;

class HostTagController extends Controller
{
    public function index(){
        // $user_id = 
        $tags = DB::table('tags')->where('user_id',auth()->user()->id)->get();
        return view('Host.account-details.tags.index',compact('tags'));
    }
    public function addTags(Request $req){
        $req->validate([
            'tag_name' =>'required'
        ]);
        $tags = new Tags;
        $tags->user_id = $req->id;
        $tags->name = $req->tag_name;
        $tags->save();
        return redirect('/'.auth()->user()->unique_id.'/'.'tags')->with(['success'=>'New Tag generated succesfully']);
    }
    public function editTags(Request $req){
        $tags = Tags::find($req->tag_id);
        $tags->name = $req->tag_name;
        $tags->update();
        return array('success'=>'your tag is succesfully edited.');
    }
    public function deleteTags(Request $req){
        $tags = Tags::find($req->tag_id);
        $tags->delete();
        return array('success'=>'your tag is deleted succesfully');
    }
}
