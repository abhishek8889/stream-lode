@extends('host_layout.master')
@section('content')
<div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Payment Methods</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
            {{ Breadcrumbs::render('payment-methods') }}
            </ol>
          </div>
        </div>
      </div>
</div>
<div class="col-12">
        <div class="card">
            <div class="card-body table-responsive p-0">
                <table class="table table-hover text-nowrap">
                    <thead>
                        <tr>
                            <th>Sr. no</th>
                            <th>Brand</th>
                            <th>Ends in </th>
                            <th>Expire on</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                        <tbody>
                            @if($payment_methods)
                            <?php  $count = 0; ?>
                            @foreach($payment_methods as $pm)
                            <tr class="text-left">
                                <?php $count = $count+1; ?>
                                <td>{{ $count }}.</td>
                                <td>{{ $pm['brand'] }}</td>
                                <td>{{ $pm['last_4'] }}</td>
                                <td>{{ $pm['expire_month'] }}/{{ $pm['expire_year'] }}</td>
                                <td>
                                    <button href="{{ url('delete-payment-methods/'.$pm['id']) }}" class="delete_payment_method btn btn-danger"> <i class="fa fa-trash "></i></button>
                                </td>
                            </tr>
                            @endforeach
                            @endif
                        </tbody>
                </table>
            </div>
            <div class="d-flex justify-content-end">
                
            </div>
        </div>
    </div>
    <script>
    $('.delete_payment_method').click(function(e){
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