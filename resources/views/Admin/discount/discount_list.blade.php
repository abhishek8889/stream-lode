@extends('admin_layout.master')
@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title"><strong>Discount Coupons List</strong></h3>
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
                            <th>Name</th>
                            <th>Type</th>
                            <th>Coupon code</th>
                            <th>Value</th>
                            <th>Durations</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                 
                    <tbody>
                        <?php $x = 0; ?>
                        @foreach($discount_list as $discount)
                        <?php $x++; ?>
                        <tr>
                           <td>{{ $x }}</td>
                           <td>{{ $discount->coupon_name }}</td>
                           <td>{{ $discount->discount_type }}</td>
                           <td>{{ $discount->coupon_code }}</td>
                           @if( $discount->discount_type == 'amount_off' )
                           <td>{{ $discount->amount_off .'('. $discount->currency .')' }}</td>
                           @else
                           <td>{{ $discount->percent_off }}</td>
                           @endif
                            <td>{{ $discount->duration .'('.$discount->duration_in_months.' months)' }}</td>
                            
                            @if($discount->status == 1)
                            <td><span  class="badge badge-success">active</span></td>
                            @else
                            <td><span  class="badge badge-danger">inactive</span></td>
                            @endif
                            <td>
                                <a href="{{ url('/admin/generate-discount') }}/{{ $discount->_id }}" class="btn btn-info"><i class="fa fa-edit "></i></a>
                                <a href="#" class="btn btn-danger"> <i class="fa fa-trash "></i></a>
                           </td>
                        </tr>
                        @endforeach
                    </tbody>
                    
                </table>
            </div>
            <div class="d-flex justify-content-end">
                {!! $discount_list !!}
            </div>
        </div>
    </div>
</div>
@endsection