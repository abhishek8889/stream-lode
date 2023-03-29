@extends('host_layout.master')
@section('content')
<div class="col-12">
        <div class="card">
            <div class="card-header">
                <div class="card-tools">
                    <div class="input-group input-group-sm" style="width: 150px;">
                        <input type="text" name="table_search" class="form-control float-right" placeholder="Search">
                        <div class="input-group-append">
                            <button type="submit" class="btn btn-default">
                            <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body table-responsive p-0">
                <table class="table table-hover text-nowrap">
                    <thead>
                        <tr>
                            <th>Sr. no</th>
                            <th>Coupon Name</th>
                            <th>Coupon Code</th>
                            <th>Percentage Off</th>
                            <th>Durations</th>
                            <th>Durations Times</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                        <tbody>
                            <?php $count = 0; ?>
                        @foreach($discount_coupons as $dc)
                            <tr>
                                <?php $count = $count+1; ?>
                                <td>{{ $count }}</td>
                                <td>{{$dc->coupon_name ?? ''}}</td>
                                <td>{{$dc->coupon_code ?? ''}}</td>
                                <td>{{ $dc->percentage_off ?? '' }}</td>
                                <td>{{ $dc->duration ?? '' }}</td>
                                <td>{{ $dc->duration_times ?? '' }}</td>
                                <td>@if($dc->status == 1)<span class="badge badge-success" >active</span> @else<span class="badge badge-danger" >not-active</span>@endif</td>
                                <td>
                                <a href="{{ route('coupons-create',['id'=>Auth::user()->unique_id]) }}/{{ $dc->_id }}" class="btn btn-info"><i class="fa fa-edit "></i></a>
                                <a href="{{ url(Auth::user()->unique_id.'/coupons/delete/'.$dc->_id ) }}" class="btn btn-danger"> <i class="fa fa-trash "></i></a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                </table>
            </div>
            <div class="d-flex justify-content-end">
                
            </div>
        </div>
    </div>

@endsection