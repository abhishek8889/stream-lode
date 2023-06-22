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
              {{ Breadcrumbs::render('stream-payment') }}
            </ol> 
          </div>
        </div>
      </div>
</div>
<div class="container-fluid">
<div class="card">
            <div class="card-header">
            <h3 class="card-title"><strong>Stream Payments List</strong></h3>
                <div class="card-tools">
                    <div class="input-group input-group-sm" style="width: 150px;">
                        <input type="text" name="table_search" class="form-control float-right" placeholder="Search" id="inputsearch">
                        <div class="input-group-append">
                            <button type="submit" id="searchbtn" class="btn btn-default">
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
                            <th>Host name</th>
                            <th>Host unique id</th>
                            <th>Duration</th>
                            <th>Status</th>
                            <th>Amount</th>
                            <th>Created at</th>
                            <th>View</th>
                        </tr>
                    </thead>
                 
                    <tbody>
                      <?php $count = 0; ?>
        @foreach($stream_data as $data)
        <?php $count++ ?>
                    <tr>
                           <td><b>{{ $count }}</b></td>
                           <td><b>{{ $data[0]->first_name ?? '' }}</b></td>
                           <td><b>{{ $data[0]->unique_id ?? '' }}</b></td>  
                           <td class="text-uppercase text-info"><b>{{ $data[0]['appoinments'][0]->duration_in_minutes ?? 0 }} minutes</b></td>
                           <td><span class="badge badge-success"> succesfull</span></td> 
                           <td><b>${{ $data[0]['streampayment'][0]->total ?? '' }}</b></td>
                           <td> {{$data[0]['streampayment'][0]['created_at'] ?? '' }}</td>
                           <td>
                                <a href="{{ url('admin/stream-payments') }}/{{ $data[0]->unique_id }}" class="btn btn-info"><i class="fa fa-eye"></i></a>
                           </td>
                    </tr>
        @endforeach                     
                    </tbody>
                </table>
            </div>
        </div>
</div>
@endsection