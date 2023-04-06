@extends('host_layout.master')
@section('content')
<div class="container col-12">
            <div class="card card-info ">
              <div class="card-header">
                <h3 class="card-title">Horizontal Form</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form action="{{ route('meeting-add',['id' => Auth()->user()->unique_id]) }}" method="POST" class="form-horizontal">
                @csrf
                <div class="card-body col-6">
                  <div class="form-group row">
                    <label for="duration" class="col-sm-2 col-form-label">Duration In Minutes</label>
                    <div class="col-sm-10">
                      <input type="number" class="form-control" id="duration" name="duration" placeholder="Duration" value="{{ $meetingcharges['duration'] ?? '' }}">
                    </div>
                    @error('duration')
                            <div class="text text-danger">{{ $message }}</div>
                    @enderror
                  </div>
                  <div class="form-group row">
                    <label for="payment" class="col-sm-2 col-form-label">Payment</label>
                    <div class="col-sm-10">
                      <input type="number" class="form-control" id="payment" name="payment" placeholder="Payment" value="{{ $meetingcharges['payment'] ?? '' }}">
                    </div>
                    @error('payment')
                            <div class="text text-danger">{{ $message }}</div>
                    @enderror
                  </div>
                <div class="card-footer">
                  <button type="submit" class="btn btn-info">Save</button>
                  @if($meetingcharges)
                  <a class="btn btn-success" href="{{ url(Auth()->user()->unique_id.'/meeting-charges/add') }}">Add New</a>
                  @endif
                </div>
                <!-- /.card-footer -->
              </form>
            </div>
</div>
</div>
<script>
    $(document).ready(function(){
        $('#duration').change(function(){
          duration = parseInt($(this).val());
          if(duration < 30){
            $('#duration').val('30');
          }
        });
    })
</script>
@endsection