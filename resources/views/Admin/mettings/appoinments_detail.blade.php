@extends('admin_layout.master')
@section('content')
<div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <!-- <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Dashboard v1</li> -->
              {{ Breadcrumbs::render('meetings-detail') }}
            </ol> 
          </div>
        </div>
      </div>
    </div>
<div class="container-fluid">
 <div class="card">
              <div class="card-header">
                <h3 class="card-title">Hosts</h3>
              </div>
             
              <div class="card-body">
                <table class="table table-bordered">
                  <thead>
                    <tr>
                      <th style="width: 10px">#</th>
                      <th>Guest Name</th>
                      <th>Guest Email</th>
                      <th>Host Email</th>
                      <th>Start Time</th>
                      <th>End Time</th>
                      <th>Duration</th>
                      <th>Payment Status</th>
                    </tr>
                  </thead>
                  <?php $count = 0; ?>
                    <tbody>
                        @foreach($data as $d)
                        <?php $count++; ?>
                          <tr>
                                <td>{{ $count }}</td>
                                <td>{{ $d->guest_name }}</td>
                                <td>{{ $d->guest_email }}</td>
                                <td>{{ $d['user']->email }}</td>
                                <?php $start_time = date("M/d/Y h:i:s A", strtotime($d->start)); ?>
                                <td>{{ $start_time }}</td>
                                <?php $end_time = date("M/d/Y h:i:s A", strtotime($d->end)); ?>
                                <td>{{ $end_time }}</td>
                                <td>{{ $d->duration_in_minutes }} minutes</td>
                                <td class="text-center">
                                @if($d->payment_status == 1)
                                <span class="badge bg-success" >Done</span>
                                @else
                                <span class="badge bg-danger" >pending</span>
                                @endif
                                </td>
                             </tr>
                        @endforeach
             </tbody>
             
                </table>
              </div>
              {!! $data->links() !!}
            </div>
 </div>
@endsection