@extends('admin_layout.master')
@section('content')
<div class="container">
<div class="card direct-chat direct-chat-primary">
              <div class="card-header ui-sortable-handle" style="cursor: move;">
                <h3 class="card-title">Send messages to all hosts</h3>
              </div>
                <!-- <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="remove">
                    <i class="fas fa-times"></i>
                  </button>
                
              </div>-->
              <div class="card-body"  >
              <div class="direct-chat-messages" style="display: flex; flex-direction: column-reverse; height:65vh;">
                  <div class="direct-chat-msg" id="notificationbox">
                    @foreach($messages as $m)
                    <div class="direct-chat-msg right">
                    <div class="direct-chat-infos clearfix">
                      <span class="direct-chat-name float-right">{{$m['username']}}</span>
                    </div>
                    <div class="direct-chat-text" style="margin-right:0px;text-align: right; margin-left:40%;">
                    {{$m['message']}}
                    </div>
                    <!-- /.direct-chat-text -->
                  </div>
                    @endforeach
                  </div>
                </div>
              </div>
              <div class="card-footer">
                <form id="messageform" method="post">
                    @csrf
                  <div class="input-group">
                    <input type="hidden" name="username" value="{{Auth::user()->first_name}}">
                    <input type="hidden" name="sender_id" value="{{ Auth()->user()->id }}">
                    <input type="text" name="message" id="messageinput" placeholder="Type Message ..." class="form-control">
                    <span class="input-group-append">
                      <button class="btn btn-primary">Post</button>
                    </span>
                  </div>
                </form>
              </div>
              <!-- /.card-footer-->
            </div>
    </div>
    
    <script>
        
        $(document).ready(function(){
           $('#messageform').on('submit',function(e){
            e.preventDefault();
            formdata = new FormData(this);
            // console.log(formdata);
            $.ajax({
                method: 'post',
                url: '{{ route('sendnotice') }}',
                data: formdata,
                dataType: 'json',
                contentType: false,
                processData: false,
                success: function(response)
                {
                  console.log(response);
                    $('#messageinput').val('');
                    toastr.options =

                  {

                    "closeButton" : true,

                    "progressBar" : true

                      }

                 toastr.success("Successfully send message to all hosts");
                }
            });
           });
        });
    </script>
    <script>
     
    </script>
@endsection