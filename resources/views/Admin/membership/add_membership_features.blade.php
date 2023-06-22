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
              {{ Breadcrumbs::render('features') }}
            </ol> 
          </div>
        </div>
      </div>
    </div>
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
                                        <input type="text" class="form-control" id="feature_name" name="feature_name" placeholder="Feature name" maxlength="100"> 
                                        <span class="text-danger" id="name_error"></span>
                                        @error('feature_name')
                                            <div class="text text-danger">{{ $message }}</div>
                                        @enderror  
                                    </div>
                                    <div class="form-group">
                                        <input type="text" class="form-control" id="description" name="description" placeholder="Description" maxlength="200">   
                                        <span class="text-danger" id="description_error"></span>
                                        @error('description')
                                            <div class="text text-danger">{{ $message }}</div>
                                        @enderror
                                     </div> 
                                    <div class="form-group">
                                        <button class="btn btn-success" id="submit">Submit</button>
                                        <button type="button" class="btn btn-danger" id ="addnew" style="display:none;" >Add New</button>
                                       
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
          $('#addnew').css('display','');
          $('#submit').html('Update');
        id = $(this).attr('data-id');
        $.ajax({
            method: 'post',
            url: '{{ route('featureedit') }}',
            data: {id:id, res:1 , _token: '{{csrf_token()}}'},
            dataType: 'json',
            success: function(response){
                // console.log(response);
                window.scrollTo(0, 0);
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
    $(document).ready(function(){
      $('#addnew').click(function(){
                $(this).css('display','none');
                $('#feature_name').val('');
                $('#description').val('');
                $('#id').val('');
                $('#submit').html('Submit');
      });
    });
    $('#feature_name').on('keyup',function(){
            val = $(this).val();
            console.log(val.length);
            if(val.length >= 200){
                $('#name_error').html('feature name must be less than 100 words');
            }else{
                $('#name_error').html('');
            }
        });
      $('#description').on('keyup',function(){
            val = $(this).val();
            // console.log(val.length);
            if(val.length >= 200){
                $('#description_error').html('description must be lesser than 200 words');
            }else{
                $('#description_error').html('');
            }
        });
</script>
@endsection