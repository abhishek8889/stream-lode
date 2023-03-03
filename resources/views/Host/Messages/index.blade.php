@extends('host_layout.master')
@section('content')
<pre>
<?php 
//  print_r($messages);
 ?>
 </pre>
 <div class="container col-10">
    
    <div class="card direct-chat direct-chat-primary">
            <div class="card-body">
               <!-- Conversations are loaded here -->
               <div class="direct-chat-messages" style="display: flex; flex-direction: column-reverse;">
                    <div class="direct-chat-msg">
                               @foreach($messages as $m)
                            <div class="direct-chat-text mt-1" style="margin: 0 0 0 0;">
                             {{$m['message']}}
                            </div>
                       @endforeach
                    </div>
                </div>
            </div>
    </div>
 </div>

@endsection