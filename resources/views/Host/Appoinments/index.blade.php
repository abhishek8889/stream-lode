@extends('host_layout.master')
@section('content')

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
                      <th>Start Time</th>
                      <th>End Time</th>
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
                        <?php 
                        $startdate =  Date("M/d/Y h:i", strtotime("0 minutes", strtotime($hs->start)));
                        $enddate =  Date("M/d/Y h:i", strtotime("0 minutes", strtotime($hs->end)));
                        ?>
                        <td>{{$startdate}}</td>
                        <td>{{$enddate}}</td>
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