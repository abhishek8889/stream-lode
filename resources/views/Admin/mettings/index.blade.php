@extends('admin_layout.master')
@section('content')

<?php
// foreach($user as $u){
//   print_r($u[0]['first_name']);
// echo '<br>';

// }
// die();
//  dd($user);
 ?>
 <div class="container-fluid">
 <div class="card">
              <div class="card-header">
                <h3 class="card-title">Hosts</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table class="table table-bordered">
                  <thead>
                    <tr>
                      <th style="width: 10px">#</th>
                      <th>Host Name</th>
                      <th>Email</th>
                      <th>Unique id</th>
                      <th style="width: 40px">Appoinments</th>
                    </tr>
                  </thead>
                  <?php $count = 0; ?>
                  <tbody>
                    @foreach($user as $u)
                    <?php $count = $count+1; ?>
                    <tr>
                      <td>{{ $count }}</td>
                      <td>{{ $u[0]['first_name'] ?? ''.' '.$u[0]['last_name'] ?? '' }}</td>
                      <td>
                        {{ $u[0]['email'] ?? '' }}
                      </td>
                      <td>
                        {{ $u[0]['unique_id'] ?? '' }}
                      </td>
                      <td><span class="badge bg-danger"  data-toggle="modal" data-target="#exampleModal{{ $u[0]['id'] }}">Appoinments</span></td>
                    </tr>

                   
                    @endforeach
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
              <div class="card-footer clearfix">
              
              </div>
            </div>
 </div>
 @foreach($user as $u)
 <div class="modal fade bd-example-modal-lg" id="exampleModal{{ $u[0]['id'] }}" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                          <div class="modal-dialog modal-lg" role="document">
                            <div class="modal-content">
                              <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">{{ $u[0]['first_name'] ?? ''.' '.$u[0]['last_name'] ?? ''.' appoinments' }}</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                  <span aria-hidden="true">&times;</span>
                                </button>
                              </div>
                              <div class="modal-body">
                              <div class="card">
                                        <div class="card-body p-0">
                                            <table class="table table-striped">
                                            <thead>
                                                <tr>
                                                <th >Guest Name</th>
                                                <th>Email</th>
                                                <th>Starting time</th>
                                                <th>End time</th>
                                                </tr>
                                            </thead>

                                            <tbody>
                                                @forelse($u[0]['appoinments'] as $ap)
                                                <tr>
                                                <td>{{ $ap['guest_name'] }}</td>
                                                <td>{{$ap['guest_email']}}</td>
                                                <td>
                                                    <?php $sartdate = Date("M/d/Y H:i", strtotime("0 minutes", strtotime($ap['start'])));
                                                    $enddate = Date("M/d/Y H:i", strtotime("0 minutes", strtotime($ap['end'])));
                                                    ?>
                                                  {{ $sartdate }}  
                                                </td>
                                                <td>{{ $enddate }}</td>
                                                </tr>
                                                @empty
                                               <tr>
                                                <td>
                                                    No Appoinments 
                                                </td>
                                               </tr>
                                              @endforelse
                                           
                                            </tbody>
                                            </table>
                                        </div>
            </div>
                              </div>
                              
                            </div>
                          </div>
                    </div>
    @endforeach
   
@endsection