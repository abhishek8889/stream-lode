@extends('host_layout.master')
@section('content')
<div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0"> </h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
            {{ Breadcrumbs::render('questionnaire-add') }}
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
<div class="container col-12" id="addcontainer">
<div class="card card-info">
              <div class="card-header">
                <h3 class="card-title"><b>Guest Questions</b></h3>
                
              </div>
                <div class="card-body">
                    <div class="col-6">
                            <form action="{{ url('/'.Auth()->user()->unique_id.'/questionnaire/add') }}" method="post" id="form" class="p-4">
                                
                                @csrf
                                <input type="hidden" name="id" id ="id" value="{{ $edit_data->_id ?? ''}}">
                                <div class="from-group">
                                        <label for="question">Question</label>
                                        <input type="text" name="question" id="question" class="form-control" value="{{ $edit_data->question ?? ''}}" maxlength="200">
                                        <span class="text-danger" id="question_error"></span>
                                        @error('question')
                                            <div class="text text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="answer">Answer type</label>
                                        <select name="answer_type" id="answer" class="form-control">
                                        <option value="input" id="input"@if($edit_data) @if($edit_data->answer_type == 'input') selected @endif @endif>input</option>    
                                        <option value="checkbox" id="checkbox" @if($edit_data) @if($edit_data->answer_type == 'checkbox') selected @endif @endif >checkbox</option>
                                            
                                        </select>
                                        @error('answer_type')
                                            <div class="text text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group" id="inputbox">
                                        <div class="row">
                                            <div class="col-lg-9" id="inputdiv">
                                            @if($edit_data)
                                                @if($edit_data->checkboxname)
                                                    @foreach($edit_data->checkboxname as $data)
                                                    <input type="text" name="checkboxname[]" id ="checkbox_name" class="form-control mt-1" value="{{$data ?? ''}}" maxlength="30">
                                                    @endforeach
                                                @endif
                                            @endif
                                            </div>
                                            <span class="text-danger" id="checkbox_error"></span>
                                            <div class="col-lg-3">
                                            <button type="button" id="addnew" class="btn btn-dark">Add option</button>
                                            </div>
                                        </div>
                                    </div>
                                    @if($edit_data)
                                    <button type="submit" class="btn btn-dark">Update</button>
                                    <a href="{{ url('/'.Auth()->user()->unique_id.'/addquestionnaire') }}" class="btn btn-success">Add New</a>
                                    @else
                                    <button type="submit" class="btn btn-dark"> submit</button>
                                    @endif
                                </form>

                        </div>
                    </div>      
               </div>
  </div>

<script>
        $(document).ready(function(){
                if($('#answer').val()=='checkbox'){
                    $('#inputbox').show();
                }else{
                    $('#inputbox').hide();
                    $('#inputdiv').html('');
                }
            $('#answer').change(function(){
                if($(this).val()=='checkbox'){
                    $('#inputbox').show();
                    $('#inputdiv').append('<input type="text" name="checkboxname[]" id="checkbox_name" class="form-control mt-1" maxlength="30">');
                }else{
                    $('#inputbox').hide();
                    $('#inputdiv').html('');
                }
            });
            $('#addnew').click(function(){
                $('#inputdiv').append('<input type="text" name="checkboxname[]" id="checkbox_name" class="form-control mt-1" maxlength="30">');
            });
        });
    
        $('#question').on('keyup',function(){
            val = $(this).val();
            // console.log(val.length);
            if(val.length >= 200){
                $('#question_error').html('Question character limit is 200 words only');
            }else{
                $('#question_error').html('');
            }
        });
        // $("input#checkbox_name").on('keyup',function(){
    $("body").delegate("#checkbox_name","keyup",function(e){
            val = $(this).val();
            if(val.length > 30){
                $('span#checkbox_error').html('Checkbox names character limit is 30 words only');
                $('#addnew').hide();
            }else{
                $('span#checkbox_error').html('');
                $('#addnew').show();
            }
        });

</script>
@endsection