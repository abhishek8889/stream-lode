@extends('admin_layout.master')
@section('content')
<div class="container col-6">

            <div class="card card-info">
              <div class="card-header">
                <h3 class="card-title"><b>Add Membership Features</b></h3>
                
              </div>
              <!-- /.card-header -->
              <!-- form start -->
                <div class="card-body">
                  
                        <div class="userform">
                            <form action="{{ route('featureadd') }}" method="POST" >
                                <div class="form-group">
                                    @csrf
                                    <input type="hidden" id ="id" name="id" value="">
                                    <div class="form-group">
                                        <input type="text" class="form-control" id="feature_name" name="feature_name" placeholder="Feature name">   
                                    </div>
                                    <div class="form-group">
                                        <input type="text" class="form-control" id="description" name="description" placeholder="Description">   
                                    </div> 
                                    <div class="form-group">
                                        <button class="btn btn-success">Submit</button>
                                       
                                    </div>                           
                                </div>
                            </form>
                        </div>
               </div>
            </div>
      </div>
<div class="container">
<div class="card">
              <div class="card-header">
                <h3 class="card-title">Membership Features List</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body" style="max-height: 393px; overflow: auto;">
                <table class="table table-bordered">
                  <thead>
                    <tr>
                      <th style="width: 10px">#</th>
                      <th>Feature Name</th>
                      <th>Description</th>
                      <th>edit</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php $count = 0; ?>
                    @foreach($features as $f)
                    <?php $count = $count+1; ?>
                    <tr>
                      <td>{{ $count }}.</td>
                      <td>{{ $f->feature_name }}</td>
                      <td>
                      {{ $f->description }}
                      </td>
                      <td><span class="btn edit-tag" data-id="{{$f->id}}" > <i class="fa fa-edit"></i> </span> <span class="btn delete-tag" data-id="{{$f->id}}" > <i class="fa fa-trash"></i> </span></td>
                    </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>
              <div class="card-footer clearfix">
              
              </div>
            </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/sweetalert"></script>
<script>
    $(document).ready(function(){
        $('.edit-tag').click(function(){
        id = $(this).attr('data-id');
        $.ajax({
            method: 'post',
            url: '{{ route('featureedit') }}',
            data: {id:id, res:1 , _token: '{{csrf_token()}}'},
            dataType: 'json',
            success: function(response){
                // console.log(response);
                $('#feature_name').val(response.feature_name);
                $('#description').val(response.description);
                $('#id').val(response._id);
            }
        });
        });
    });

    $(document).ready(function(){
        $('.delete-tag').click(function(){
            id = $(this).attr('data-id');
            $.ajax({
            method: 'post',
            url: '{{ route('featureedit') }}',
            data: {id:id, res:0 , _token: '{{csrf_token()}}'},
            dataType: 'json',
            success: function(response){
                console.log(response);
                $('.loader').hide();
              swal({
                    title: "Feature is deleted succesfully.",
                    text: "Make sure you have to update your membership tier included this feature",
                    icon: "success",
                    button: "Go back.",
                }).then((value) => {
                  location.reload();
                  });
            }
        });
        });
    });
    
</script>
@endsection