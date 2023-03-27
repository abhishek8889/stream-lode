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
              {{ Breadcrumbs::render('edit-membership') }}
            </ol> 
          </div>
        </div>
      </div>
    </div>
<section class="content">
<div class="card card-primary">
    <div class="card-header">
    <h3 class="card-title"><strong>Add Membership Tier</strong></h3>
    </div>
    <!-- /.card-header -->
    <!-- form start -->
    <form action="{{ route('update-membership-tier') }}" method="POST" enctype="multipart/form-data" class="form-horizontal">
        @csrf
        <input type="hidden" name="id" value="{{ $membership_data['_id'] ?? '' }}">
        <div class="row">
            <div class="card-body col-md-6">
                <div class="form-group row">
                    <label for="name" class="col-sm-3 col-form-label">Name</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" id="name" placeholder="Name" name="name" value="{{ $membership_data['name'] ?? '' }}" disabled >
                    </div>
                </div>
                <div class="form-group row">
                    <label for="slug" class="col-sm-3 col-form-label">Slug</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" id="slug" placeholder="Slug" name="slug" value="{{ $membership_data['slug'] ?? '' }}" disabled>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="inputEmail3" class="col-sm-3 col-form-label">Price</label>
                    <div class="col-sm-9">
                        <input type="number" step="0.01" class="form-control" id="inputEmail3" placeholder="USD($)" name="price" value="{{ $membership_data['amount'] ?? '' }}" disabled>
                    </div>
                </div>
                <!-- currency code -->
                <div class="form-group row">
                    <label for="inputEmail3" class="col-sm-3 col-form-label">Currency code</label>
                    <div class="col-sm-9">
                        <select id="" class="form-control" id="inputEmail3" name="currency_code" disabled>
                            <option value="usd" <?php if($membership_data['type'] == 'usd'){ echo 'slected'; } ?> >USD</option>
                        </select>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="inputEmail3" class="col-sm-3 col-form-label" >Membership Type</label>
                    <div class="col-sm-9">
                        <select id="" class="form-control" id="inputEmail3" name="membership_type" disabled>
                            <option value="recurring" <?php if($membership_data['type'] == 'recurring'){ echo 'slected'; } ?> >Recurring</option>
                            <option value="one-time" <?php if($membership_data['type'] == 'one-time'){ echo 'slected'; } ?> >one time</option>
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="inputEmail3" class="col-sm-3 col-form-label" >Interval</label>
                    <div class="col-sm-9">
                        <select id="" class="form-control" id="inputEmail3" name="interval_time" disabled>
                            <option value="month" <?php if($membership_data['interval'] == 'month'){ echo 'slected'; } ?>>Monthly</option>
                            <!-- <option value="6 months">6 Months</option>
                            <option value="9 months">9 Months</option>
                            <option value="yearly">Yearly</option> -->
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="inputEmail3" class="col-sm-3 col-form-label">Features</label>
                    <div class="col-sm-9" style="max-height: 161px; overflow: auto;">
                        <!-- <div class="btn btn-info" id="addFeatures"> Add features </div>
                        <div class="" id="featureBox"></div> -->
                 
                        @foreach($features as $f)
                    <div>
                        <input type="checkbox" name="membership_fetaures[]" id="feature{{ $f['id'] }}" value="{{ $f['id'] }}" <?php if(in_array($f['id'],$membership_data['membership_features'] )){ echo 'checked'; } ?> multiple>
                        <label for="feature{{ $f['id'] }}">{{ $f['feature_name'] }} </label>
                        <button type="button" class="btn" data-toggle="popover" title="{{ $f['description'] }}" data-content="done" ><i class="fas fa-info-circle"></i></button>
                    </div>
                        @endforeach
                   
                    </div>
                </div>
                <div class="form-group row">
                    <label for="inputEmail3" class="col-sm-3 col-form-label">Description</label>
                    <div class="col-sm-9">
                        <textarea name="description" class="form-control" id="inputEmail3" id="" cols="10" rows="3">{{ $membership_data['description'] }}</textarea>
                    </div>
                </div>
            </div>
            <!-- <div class="card-body col-md-4">
                <div class="form-group row">
                    <div class="col-sm-8">
                        <input type="file" class="form-control" id="inputEmail3" name="card_logo" />
                    </div>
                </div>
            </div> -->
        </div>
        <div class="card-footer">
            <button type="submit" class="btn btn-primary">Update membership tier</button>
        </div>
    </form>
</div>
</section>
@endsection