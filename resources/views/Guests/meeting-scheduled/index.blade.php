@extends('guest_layout.master')
@section('content')
<?php 
$time = date('Y-m-d H:i');
?>
<div class="container-fluid mt-5" style="min-height: 249px;">
    <h3 class="text-center">Your Scheduled Meetings </h3>
        <div class="d-flex justify-content-center row">
            <div class="col-md-12" style ="box-shadow: 2px 2px 10px 0px rgb(190, 108, 170);">
                <div class="rounded">
                    @if($appoinments)
                    <div class="table-responsive table-borderless text-center">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>S. No.</th>
                                    <th>Host Name</th>
                                    <th>Host Email</th>
                                    <th>Meeting Starting Time</th>
                                    <th>Meeting End Time</th>
                                    <th>Action</th>
                                    <th>Message</th>
                                   
                                </tr>
                            </thead>
                            <?php $count = 0; ?>
                            <tbody class="table-body">
                                @foreach($appoinments as $ap)
                                <tr class="cell-1">
                                    <?php $count = $count+1; ?>
                                    <td>{{ $count }}</td>
                                    <td>{{ $ap->user['first_name'] }} {{ $ap->user['last_name'] }}</td>
                                    <td>{{ $ap->user['email'] }}</td>
                                    <?php 
                                    $sartdate = Date("M/d/Y h:i A", strtotime("0 minutes", strtotime($ap->start)));
                                    $enddate = Date("M/d/Y h:i A", strtotime("0 minutes", strtotime($ap->end)));
                                    ?>
                                    <td>{{ $sartdate }}</td>
                                    <td>{{ $enddate }}</td>
                                    <!-- <td>@if($time > $ap->end)<span class="badge badge-success"> done </span>@else <span class="badge badge-danger"> pending</span> @endif </td> -->
                                    <td><button href="{{ url('scheduledmeeting/cancel') }}/{{ $ap->_id }}" class="cancel-appointment btn btn-danger btn-sm" id="cancel-appointment">Cancel</button></td>
                                    <td><a href="{{ url('message') }}/{{ $ap->user['unique_id'] }}" class="btn btn-scucess"> Message <span class="badge badge-warning navbar-badge    ">{{ count($ap->messages) ?? 0 }}</span> </a></td>
                                </tr>
                               @endforeach
                            </tbody>
                        </table>
                    </div>
                    @else
                <h1>Currently you don't have any meeting</h1>
                    @endif
                </div>
            </div>
        </div>
    </div>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(document).ready(function(){
            $('.cancel-appointment').click(function(){
                href = $(this).attr('href');
               
                Swal.fire({
                      title: 'Are you sure to cancel this appointment!',
                      showCancelButton: true,
                      confirmButtonText: 'yes',
                      confirmButtonColor: '#008000',
                      cancelButtonText: 'no',
                      cancelButtonColor: '#d33',

                    }).then((result) => {
                      /* Read more about isConfirmed, isDenied below */
                      if (result.isConfirmed) {
                        window.location.href = href;
                      } 
                    })
            });
        });
    </script>
@endsection