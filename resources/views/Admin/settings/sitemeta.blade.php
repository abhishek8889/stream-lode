@extends('admin_layout.master')
@section('content')
<div class="container-fluid">
            <div class="card card-info" style="min-height:500px;">
              <div class="card-header">
                <h3 class="card-title"><b>Site Settings</b></h3>
              </div>
                <div class="card-body">
                  <div class="col-md-9">
                    <!-- form  -->
                    <div class="userform">
                      <form action="{{ route('site-meta-add') }}" method="POST">
                        @csrf                    
                        <div class="form-group row">
                                    <label for="helpemail" class="col-sm-2 col-form-label">Support email</label>
                                    <div class="col-sm-10">
                                        <input type="email" class="form-control" id="helpemail" name="help_email" value="{{ $sitemeta['help_email'] ?? '' }}" />
                                    <span class="text-center" id="email_error"></span>
                                    </div>
                         </div>
                        <div class="form-group row">
                                    <label for="facebook" class="col-sm-2 col-form-label">Facebook link</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="inputName2" name="facebook" value="{{ $sitemeta['facebook_link'] ?? '' }}" />
                                    </div>
                                    </div>
                        <div class="form-group row">
                                    <label for="twitter" class="col-sm-2 col-form-label">Twitter link</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="twitter" name="twitter" value="{{ $sitemeta['twitter_link'] ?? '' }}" />
                                    </div>
                        </div>
                        <div class="form-group row">
                                    <label for="linkedin" class="col-sm-2 col-form-label">Linkedin link</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="linkedin" name="linkedin" value="{{ $sitemeta['linkedin_link'] ?? '' }}" />
                                    </div>
                        </div>
                        <div class="form-group row">
                                    <label for="instagram" class="col-sm-2 col-form-label">Instagram link</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="instagram" name="instagram" value="{{ $sitemeta['instagram_link'] ?? '' }}" />
                                    </div>
                        </div>
                        <div class="form-group row">
                          <div class="col-sm-10">
                          <button class="btn btn-info">Update</button>
                          </div>
                        </div>
                   </div>
                  </div>
                </div>
                <div class="card-footer">
                  
                </div> 
            </form>
              
            </div>
      </div>

@endsection