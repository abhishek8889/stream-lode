@extends('host_layout.master')
@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Register Your account</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
            {{ Breadcrumbs::render('host-general-settings') }}
            </ol>
          </div>
        </div>
      </div>
    </div>
    <!-- /.content-header -->
    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
            <div class="card card-info">
                <form action="{{ url('register-host-stripe-account') }}" method="POST">
                    <div class="card-body">
                        <div class="col-md-10" >
                            <div class="userform">
                                @csrf
                                <input type="hidden" name="id" value="{{ auth()->user()->id }}">
                                <div class="form-group row">
                                    <label for="account_holder_name" class="col-sm-3 col-form-label">Account Holder Name</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" id="account_holder_name" name="account_holder_name" placeholder="Account Holder Name" value="">
                                        @error('account_holder_name')
                                            <div class="text text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="inputEmail3" class="col-sm-3 col-form-label">Email</label>
                                    <div class="col-sm-9">
                                        <input type="email" class="form-control" id="inputEmail3" name="email" placeholder="Email" value="{{ isset(auth()->user()->email)?auth()->user()->email:''; }}">
                                        @error('email')
                                            <div class="text text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="business_phone" class="col-sm-3 col-form-label">Business phone number</label>
                                    <div class="col-sm-9">
                                        <input type="number" class="form-control" id="business_phone" name="business_phone" placeholder="Enter Your Business Contact Number" value="">
                                        @error('business_phone')
                                            <div class="text text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="business_site" class="col-sm-3 col-form-label">Business website</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" id="business_site" name="business_site" placeholder="Enter Your Business website" value="">
                                        @error('business_site')
                                            <div class="text text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="country" class="col-sm-3 col-form-label">Country</label>
                                    <div class="col-sm-9">
                                        <select name="country" id="country" class="form-control">
                                            <option value="US">US</option>
                                        </select>
                                        @error('country')
                                            <div class="text text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="bank_acc_number" class="col-sm-3 col-form-label">Bank account number</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" id="bank_acc_number" name="bank_acc_number" placeholder="Bank Account Number" value="">
                                        @error('bank_acc_number')
                                            <div class="text text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="acc_routing_num" class="col-sm-3 col-form-label">Account routing number</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" id="acc_routing_num" name="acc_routing_num" placeholder="Account routing number" value="">
                                        @error('acc_routing_num')
                                            <div class="text text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="bank_acc_region" class="col-sm-3 col-form-label">Bank account region</label>
                                    <div class="col-sm-9">
                                        <select name="bank_acc_region" id="bank_acc_region" class="form-control">
                                            <option value="US">US</option>
                                        </select>
                                        @error('bank_acc_region')
                                            <div class="text text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="region_currency" class="col-sm-3 col-form-label">Region currency</label>
                                    <div class="col-sm-9">
                                        <select name="region_currency" id="region_currency" class="form-control">
                                            <option value="USD">USD</option>
                                        </select>
                                        @error('region_currency')
                                            <div class="text text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-9">
                                        <input type="checkbox" name="terms_of_service" id="terms_of_service" />
                                    </div>
                                    <label for="terms_of_service" class="col-sm-3 col-form-label">Terms of service agreement</label>
                                    @error('terms_of_service')
                                        <div class="text text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-info">Register</button>
                    </div>
                </form>
            </div>
        </div>
    </section>
@endsection