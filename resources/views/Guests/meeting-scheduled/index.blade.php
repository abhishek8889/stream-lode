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
                                    <th>Status</th>
                                   
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
                                    <td>{{ $ap->start }}</td>
                                    <td>{{ $ap->end }}</td>
                                    <td>@if($time > $ap->end) done @else not done @endif </td>
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

@endsection