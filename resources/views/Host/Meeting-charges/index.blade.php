@extends('host_layout.master')
@section('content')

<div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Add Meeting Charges</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
            {{ Breadcrumbs::render('meeting-charges') }}
            </ol>
          </div>
        </div>
      </div>
    </div>
<div class="container">
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
                            <th>Duration</th>
                            <th>Amount</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                        <tbody>
                            <?php $count = 0; ?>
                           
                            @forelse($meetingcharges as $mc)
                            <?php $count = $count+1; ?>
                            <tr >
                                <td>{{ $count }}.</td>
                                <td>{{ $mc->duration_in_minutes }} minutes</td>
                                <td>${{ $mc->amount }}</td>
                                <td>
                                <a href="{{ url(Auth()->user()->unique_id.'/meeting-charges/add/'.$mc->_id) }}" class="btn btn-info"><i class="fa fa-edit "></i></a>
                                <a href="{{ url(Auth()->user()->unique_id.'/meeting-charges/delete/'.$mc->_id) }}" class="btn btn-danger"> <i class="fa fa-trash "></i></a>
                                </td>
                            </tr>
                            @empty
                            <td><p>there is no meeting charges</p></td>
                            @endforelse
                          
                           </tbody>
                </table>
            </div>
            <div class="d-flex justify-content-end">
                
            </div>
        </div>
    </div>
</div>

@endsection