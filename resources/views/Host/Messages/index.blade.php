@extends('host_layout.master')
@section('content')
<div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
          <h3  >Messages</h3>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
            {{ Breadcrumbs::render('host-message') }}
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
 <div class="container-fluid">
    <div class="row">
      <div class="col-lg-3">
        <!-- messageusers list -->
      <div class="card direct-chat direct-chat-primary" >
            <div class="card-body" >


               <!-- Conversations are loaded here -->
               <div class="direct-chat-messages" style="height:505px;">
               <button class="btn btn-dark addnew" data-toggle="modal" data-target="#exampleModal" style="width:100%;" >Add New</button>
                    <div class="direct-chat-msg px-3">
                         <hr>
                        @foreach($users as $h)
                        <div class="d-flex" style="justify-content: space-between;">
                               <a class="userlink" href="{{ url(Auth::user()->unique_id.'/message/'.$h['_id']) }}" url="{{ url(Auth::user()->unique_id.'/message/'.$h['_id']) }}"><p><strong>{{$h['first_name']}}</strong></p></a>
                           <span class="badge badge-info right user{{$h['_id']}}">{{ count($h['adminmessage']) ?? 0}}</span> 
                        </div> 
                         <hr>
                       @endforeach
                    </div>
                </div>
            </div>
        </div>
      </div>

      <!-- host scheduled list -->
      
              <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="exampleModalLabel">Users List</h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="modal-body" style="height: 300px; overflow: auto;">
                      <div class="container col-10">
                      <div class="direct-chat-msg px-3">

                      <div>
                          <a href="{{ url(Auth::user()->unique_id.'/message/'.$admin->_id) }}"><p><strong>{{ $admin->first_name }}</strong></p></a>
                          <hr>
                        </div>
                        @foreach($host_schedule as $u)
                          <div>
                          <a href="{{ url(Auth::user()->unique_id.'/message/'.$u->user_id) }}"><p><strong>{{ $u->guest_name }}</strong></p></a>
                          <hr>
                          </div>
                        @endforeach 
                    </div>
                      </div>
                    </div>
                    <div class="modal-footer">
                    </div>
                  </div>
                </div>
              </div>
                  
      <div class="col-lg-9">
        @if($idd)
      <div class="card direct-chat direct-chat-primary" >
            <div class="card-header">
            @if($user->profile_image_name)
              <img class="direct-chat-img" src="{{ $user->profile_image_url }}" alt="message user image">
            @else
               <img class="direct-chat-img" src="{{url('Assets/images/default-avatar.jpg')}}" alt="message user image">
            @endif

            <h5 class="m-2"><b>{{ $user->first_name ?? '' }} {{ $user->last_name ?? '' }}</b></h5>
            </div>
            <div class="card-body" >
               <!-- Conversations are loaded here -->
               <div class="direct-chat-messages" style="display: flex; flex-direction: column-reverse; height:380px;">
                    <div class="direct-chat-msg messagesappend" id="messages">
                        @foreach($messages as $m)
                    <div class="direct-chat-msg <?php if($m['sender_id'] == Auth()->user()->id){ }?>">
                    <div class="direct-chat-infos clearfix">
                      <span class="direct-chat-name <?php if($m['sender_id'] == Auth()->user()->id){ echo 'float-right'; }else{ echo 'float-left'; }?>">{{$m['username']}}</span>
                        
                      <?php
                       $time = Date("Y-m-d H:i", strtotime("0 minutes", strtotime($m['created_at']))); 
                       ?>
                      <span class="direct-chat-name <?php if($m['sender_id'] == Auth()->user()->id){ echo 'float-left'; }else{ echo 'float-right'; }?>">{{$time}}</span>
                    </div>
                    <div class="direct-chat-text m-0" >
                      <?php echo $m['message']; ?>
                    </div>
                    <!-- /.direct-chat-text -->
                  </div>
                       @endforeach
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <form id="message" action="{{ url('send-message') }}" method="post">
                  @csrf
                  <div class="input-group">
                    <input type="hidden"  id ="reciever_id" name="reciever_id" value="{{ $idd ?? '' }}">
                    <input type="hidden"  id ="sender_id"   name="sender_id" value="{{ Auth() ->user()->id ?? '' }}">
                    <input type="hidden" name="username" value="{{ Auth() ->user()->first_name ?? '' }}">
                    <input type="text" id ="messageinput" name="message" placeholder="Type Message ..." class="form-control">
                    <span class="input-group-append">
                      <button class="btn btn-primary">Send</button>
                    </span>
                  </div>
                </form>
              </div>
    </div>
    @endif
    </div>
      </div>
    </div>
 </div>
 <script> 
 $('.userlink').click(function(e){
  e.preventDefault();
  var pageurl = $(this).attr('url');
  history.pushState(null, '', pageurl);
  location.reload();

 });
$(document).ready(function(){
       reciever_id = $('#reciever_id').val();
       sender_id = $('#sender_id').val()
  //  console.log(sender_id+reciever_id);
  $.ajax({
          method: 'post',
          url: '{{ url('host/updatemessage') }}',
          dataType: 'json',
          data: {reciever_id:reciever_id ,sender_id:sender_id, _token: '{{csrf_token()}}'},
          success: function(response)
                    { 
                      // console.log(sender_id);
                      $('#'+reciever_id).hide();
                    let messagecount = parseInt(response.length);
                    let notificationcount = parseInt($('#notificationcount').html());
                    let messagecount1 = parseInt($('#messagecount').html());
                    $('#messagecount').html(messagecount1-messagecount);
                    let span = parseInt($('.user'+reciever_id).html());
                    $('.user'+reciever_id).html(0);
                    console.log(span);
                    console.log(messagecount1);
                    // $('#notificationcount').html(messagecount1-messagecount);
                    }

          });
});

$(document).ready(function(){
      $('#message').on('submit',function(e){
         if($('#messageinput').val() == ''){
            return false;
        }
        e.preventDefault();
        formdata = new FormData(this);
      //   console.log(formdata);
        $.ajax({
         method: 'post',
         url: '{{url('send-message')}}',
         data: formdata,
         dataType: 'json',
         contentType: false,
         processData: false,
         success: function(response)
         {
           console.log(response);
           $('#messageinput').val('');
           let timeString_ = moment(response.created_at).format("YYYY-MM-DD HH:mm");
           $('#messages').append('<div class="direct-chat-msg" ><div class="direct-chat-infos clearfix"><span class="direct-chat-name float-right">'+response.username+'</span><span class="direct-chat-name float-left">'+timeString_+'</span></div><div class="direct-chat-text m-0">'+response.message+'</div></div>');
           // $(".direct-chat-messages").load(location.href + " .direct-chat-messages");
         }
        });
      });
    });

</script>

@endsection