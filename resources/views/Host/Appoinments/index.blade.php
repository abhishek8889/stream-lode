@extends('host_layout.master')
@section('content')
<pre>
<?php
//  print_r($host_schedule); 
?>
</pre>
<div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Appoinments</h3>

                <div class="card-tools">
                
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0" style="height: 300px;">
                <table class="table table-head-fixed text-nowrap">
                  <thead>
                    <tr>
                      <th>Sr no.</th>
                      <th>Guest Name</th>
                      <th>Email</th>
                      <th>Start Time</th>
                      <th>End Time</th>
                      <th></th>
                    </tr>
                  </thead>
                  <?php $count = 0; ?>
                  <tbody>
                    @if($host_schedule)
                    @forelse ($host_schedule as $hs)
                      <tr>
                        <?php $count = $count+1; ?>
                        <td>{{$count}}</td>
                        <td>{{$hs->guest_name}}</td>
                        <td>{{$hs->guest_email}}</td>
                        <td>{{$hs->start}}</td>
                        <td>{{$hs->end}}</td>
                        <td>
                          <a href="{{ url(auth()->user()->unique_id.'/vedio-conference') }}">
                            <i class="fa fa-video-camera" aria-hidden="true"></i>
                          </a>
                        </td>
                      </tr>
                    @empty
                      <tr>
                        <td class="text text-bold text-danger">You have no appointments</td>
                      </tr>
                    @endforelse
                    @endif
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
</div>
@endsection