<?php

namespace App\Http\Controllers\Hosts;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\HostQuestionnaire;


class QuestionaryController extends Controller
{
    public function index(){
        $question_data = HostQuestionnaire::where('host_id',Auth()->user()->id)->paginate(10);
        
        return view('Host.Questionary.index',compact('question_data'));
    }
    public function AddQuestion($id,$idd = null){
        $edit_data = HostQuestionnaire::find($idd);
        return view('Host.Questionary.addquestion',compact('edit_data'));
    }
    public function AddQuestionary(Request $request){
        $request->validate([
            'question' => 'required|max:200',
            'answer_type' => 'required',
        ]);
        if($request->answer_type == 'checkbox'){
            $data = array_filter($request->checkboxname);
            if(count($data) == 0 || count($data) == 1){
                return redirect()->back()->with('error','your checkbox names are not sufficient');
            }
         
        }else{
            $data = null;
        }
        if($request->id){
        $question = HostQuestionnaire::find($request->id);
        $question->question = $request->question;
        $question->answer_type = $request->answer_type;
        $question->host_id = Auth()->user()->id;
        $question->checkboxname = $data;
        $question->update();
        return redirect()->back()->with('success','successfully update data');
        }else{
        $question = new HostQuestionnaire();
        $question->question = $request->question;
        $question->answer_type = $request->answer_type;
        $question->host_id = Auth()->user()->id;
        $question->checkboxname = $data;
        $question->save();
        return redirect()->back()->with('success','successfully saved data');
        }
    
        
      }
      public function delete(Request $request){
         $data = HostQuestionnaire::find($request->id)->delete();
         return response()->json($data);
    }
}
