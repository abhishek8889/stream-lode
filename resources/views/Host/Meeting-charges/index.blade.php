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
                   
                        <!-- <input type="text" name="table_search" class="form-control float-right" placeholder="Search">
                        <div class="input-group-append">
                            <button type="submit" class="btn btn-default">
                            <i class="fas fa-search"></i>
                            </button>
                        </div> -->
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
                                <td>${{ number_format($mc->amount,2) }}</td> 
                                <td>
                                <a href="{{ url(Auth()->user()->unique_id.'/meeting-charges/add/'.$mc->_id) }}" class="btn btn-info"><i class="fa fa-edit "></i></a>
                                <button href="{{ url(Auth()->user()->unique_id.'/meeting-charges/delete/'.$mc->_id) }}" class="delete_meeting_charges btn btn-danger"> <i class="fa fa-trash "></i></button>
                                </td>
                            </tr>
                            @empty
                            <td><p>You don't have any meeting charges</p></td>
                            @endforelse
                          
                           </tbody>
                </table>
                {{ $meetingcharges->links() }}
            </div>
            <div class="d-flex justify-content-end">
                
            </div>
        </div>
    </div>
</div>
<script>
$('.delete_meeting_charges').click(function(e){
        e.preventDefault();
       link = $(this).attr('href');
       Swal.fire({
                      title: 'Are you sure to delete this?',
                      showCancelButton: true,
                      confirmButtonText: 'yes',
                      confirmButtonColor: '#008000',
                      cancelButtonText: 'no',
                      cancelButtonColor: '#d33',

                    }).then((result) => {
                      if (result.isConfirmed) {
                        window.location.href = link;
                      } 
                    });  
      });
     </script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endsection