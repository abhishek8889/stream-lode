@extends('admin_layout.master')
@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title"><strong>Membership Tier List</strong></h3>
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
                            <th>Status</th>
                            <th>Created at</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                 
                    <tbody>
                        @if(!empty($membership_details))
                        <?php 
                            $membership_count = 0;
                        ?>
                        @foreach($membership_details as $membership)
                        <?php $membership_count++; ?>
                        <tr>
                           <td>{{ $membership_count}}</td>

                           @if(!empty($membership['name']))
                            <td>
                                @if(!empty($membership['logo_url']))
                                <img src="{{ $membership['logo_url'] }}" alt="{{ $membership['logo_name'] }}" width="40px">
                                @endif
                                <b>{{ $membership['name'] }}</b>
                            </td>
                           @endif

                           @if(!empty($membership['status']) || $membership['status'] == 1)
                            <td><span class="badge badge-pill badge-success">active</span></td>
                           @else
                           <td><span class="badge badge-pill badge-danger">in-active</span></td>
                           @endif

                           @if(!empty($membership['created_at']))
                           @foreach( $membership['created_at'] as $m)
                           <td>
                                {{ date("d-m-Y", ((int)$m / 1000) ) }}
                           </td>
                           @endforeach
                           @endif

                           <td>
                                <a href="{{ url('admin/update-membership-tier/'.$membership['_id']) }}" class="btn btn-info"><i class="fa fa-edit "></i></a>
                                <a href="{{ url('admin/delete-membership-tier/'.$membership['_id']) }}" class="btn btn-danger"> <i class="fa fa-trash "></i></a>
                           </td>
                        </tr>
                        @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection