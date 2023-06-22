@extends('host_layout.master')
@section('content')

<div class="container">
  <div class="card direct-chat direct-chat-primary">
            <div class="card-body">
                  <div class="direct-chat-messages" style="display: flex; flex-direction: column-reverse; height:65vh;">
                        <div class="direct-chat-msg" id="adminnotificationbox">
                             @foreach($notification as $d) 
                             <div class="direct-chat-msg">
                                  <div class="direct-chat-infos clearfix">
                                    <span class="direct-chat-name">{{$d['username']}}</span>
                                    <?php
                                    $time = Date("Y-m-d h:i A", strtotime("0 minutes", strtotime($d['created_at']))); 
                                    ?>
                                    <span class="direct-chat-name float-right">{{ $time }}</span>
                                  </div>
                                  <div class="direct-chat-text" style="margin-left:0px;">
                                    {{$d['message']}}
                                  </div>
                              <!-- /.direct-chat-text -->
                              </div>
                             @endforeach
                        </div>
                  </div>
            </div>
                 
                  <!-- /.card-footer-->
  </div>
</div>

<script>
    $(document).ready(function(){
            $.ajax({
                method: 'post',
                url: '{{ url('/'.Auth()->user()->unique_id.'/seenupdate') }}',
                data: { seen:1 , _token:'{{ csrf_token() }}'},
                dataType: 'json',
                success:function(response){
          $('#notificationcount').html(parseInt($('#notificationcount').html())-parseInt(response));

                }
            });
    });
</script>
@endsection