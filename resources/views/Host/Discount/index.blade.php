@extends('host_layout.master')
@section('content')
<div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Discount Coupons</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
            {{ Breadcrumbs::render('Coupons') }}
            </ol>
          </div>
        </div>
      </div>
</div>
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
                            <th>Used Times</th>
                            <th>Expire On</th>
                            <th>Action</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                        <tbody>
                            <?php $count = 0; ?>
                        @foreach($discount_coupons as $dc)
                            <tr class="text-center">
                                <?php $count = $count+1; ?>
                                <td>{{ $count }}.</td>
                                <td>{{$dc->coupon_name ?? ''}}</td>
                                <td>{{$dc->coupon_code ?? ''}}</td>
                                <td>{{ $dc->percentage_off ?? '' }}%</td>
                                <td><span class="badge badge-pill badge-success">{{ $dc->duration ?? '' }}</span></td>
                                <td>{{ $dc->duration_times ?? '-' }}</td>
                                <td>{{ $dc->coupon_used ?? '-' }}</td>
                                <td>{{ $dc->expiredate ?? '' }}</td>
                                <td>
                                <a href="{{ route('coupons-create',['id'=>Auth::user()->unique_id]) }}/{{ $dc->_id }}" class="btn btn-info"><i class="fa fa-edit "></i></a>
                                <a href="{{ url(Auth::user()->unique_id.'/coupons/delete/'.$dc->_id ) }}" class="btn btn-danger"> <i class="fa fa-trash "></i></a>
                                </td>
                                <td><div class="custom-control custom-switch">
                              <input type="checkbox" class="custom-control-input" data-id ="{{ $dc->_id }} " id="customSwitches{{ $dc->_id }}" name="hide_profile" status ="{{ $dc->status }}" @if($dc->status == 1) checked @endif>
                              <label class="custom-control-label" for="customSwitches{{ $dc->_id }}"></label>
                            </div></td>
                               
                            </tr>
                            @endforeach
                        </tbody>
                </table>
            </div>
            <div class="d-flex justify-content-end">
                
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function(){
            $('.custom-control-input').change(function(){
               let status = $(this).attr('status');
               let id = $(this).attr('data-id');
               $.ajax({
                method: 'post',
			    url: '{{route('coupon-disable',['id'=>Auth::user()->unique_id])}}',
			    dataType: 'json',
			    data: {id:id,status:status,_token:"{{ csrf_token() }}"},
			    success: function(response)
			         {
                        console.log(status);
                        if(status == 0){
                            $('#customSwitches'+id).attr('status',1);
                        }else{
                            $('#customSwitches'+id).attr('status',0);   
                        }
                }
               });
            })
        });
    </script>

@endsection 