@extends('guest_layout.master')
@section('content')

<!-- #################### About page ################################# -->

<section class="top_banner inner_banner">
  <div class="container-fluid">
    <div class="inner-section">
      <div class="row banner-content">
        <div class="col-md-6 text_col">
          <div class="banner-heading">
            <h1><span class="yellow">Stream</span><span class="blue">Lode</span> can allow you to generate a revenue stream.</h1><span class="heading-pattern"><img src="{{ asset('streamlode-front-assets/images/star.png') }}"></span>
          </div>
          <div class="banner-text">
            <p>A revenue stream around your schedule, and your responsibilities, while working from home.</p><span class="text-pattern"><img src="{{ asset('streamlode-front-assets/images/text-star.png') }}"></span>
          </div>
        </div>
        <div class="col-md-6 media_col">
          <div class="banner-media">
            <img src="{{ asset('streamlode-front-assets/images/about-support-banner.png') }}" class="radius_top_50">
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<section class="choose-plan-section">
  <div class="dark_navigation up">
    <div class="container-fluid">
      <div class="dark-nav">
        <ul class="nav-list" id="filter-list">
          <li class="nav-list-item active" id="all" data-target="legal_content"><a href="#all">Legal</a></li>
          <li class="nav-list-item" id="standar-tier" data-target="community_guidelines"><a href="#community-guidelines" >Community guidelines</a></li>
          <li class="nav-list-item" id="premium-tier" data-target="help_content"><a href="#help-content">Help</a></li>
          <li class="nav-list-item" id="group-tier" data-target="suggestions_content"><a href="#suggestions-content" >Suggestions</a></li>
          <li class="nav-list-item" id="group-tier" data-target="privacy_content"><a href="#privacy-content">Privacy Policy</a></li>
        </ul>
      </div>
    </div>

  </div>
  <div class="plans-section">
    <div class="container">

      <div class="about-content   show_box" id="legal_content">
        <div class="section-head text-center">
          <h2><span class="yellow">Stream</span><span class="blue">Lode</span> Legal</h2>
        </div>
        <div class="about_module_wrapper">
          <div class="About_module">
            <h3>What is Lorem Ipsum?</h3>
            Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.
          </div>
          <div class="About_module">
            <h3>Why do we use it?</h3>
            It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using 'Content here, content here', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text.
          </div>
          <div class="About_module">
            <h3>Where does it come from?</h3>
            Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.
          </div>
          <div class="About_module">
            <h3>Where can I get some?</h3>
            It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using 'Content here, content here', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text.
          </div>
          <div class="About_module">
            <h3>The standard Lorem Ipsum passage, used since the 1500s</h3>
            It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using 'Content here, content here', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text.
          </div>
          <div class="About_module">
            <h3>1914 translation by H. Rackham</h3>
            Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.
          </div>
          <div class="About_module">
            <h3>Lorem Ipsum is simply dummy text?</h3>
            It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using 'Content here, content here', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text.
          </div>
        </div>
      </div>
      <div class="about-content" id="community_guidelines">
        <div class="section-head text-center">
          <h2>Community guidelines</h2>
        </div>
        <div class="about_module_wrapper">
          <div class="About_module">
            <h3>What is Lorem Ipsum?</h3>
            Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.
          </div>
          <div class="About_module">
            <h3>Why do we use it?</h3>
            It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using 'Content here, content here', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text.
          </div>
          <div class="About_module">
            <h3>Where does it come from?</h3>
            Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.
          </div>
          <div class="About_module">
            <h3>Where can I get some?</h3>
            It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using 'Content here, content here', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text.
          </div>
          <div class="About_module">
            <h3>The standard Lorem Ipsum passage, used since the 1500s</h3>
            It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using 'Content here, content here', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text.
          </div>
          <div class="About_module">
            <h3>1914 translation by H. Rackham</h3>
            Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.
          </div>
          <div class="About_module">
            <h3>Lorem Ipsum is simply dummy text?</h3>
            It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using 'Content here, content here', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text.
          </div>
        </div>
      </div>
      <div class="about-content  " id="help_content">
        <div class="section-head text-center">
          <h2><span class="yellow">Get in</span><span class="blue"> touch</span></h2>
        </div>
        <?php 
          $admin_data =  App\Models\Sitemeta::first();
          
          ?> 
        <div class="about_module_wrapper">
          <div class="contact-nfo-wrapper">
            <div class="row contact-row">
              <div class="col-md-4 contact-address-col">
                <div class="address-list">
                  <ul>
                    <li><i class="fa-solid fa-envelope"></i> <a href="mailto:{{ $admin_data['help_email'] ?? 'Support@streamlode.com' }}">{{ $admin_data['help_email'] ?? 'Support@streamlode.com' }}</a></li>
                    <li><i class="fa-solid fa-house"></i> United States</li>
                  </ul>
                </div>
              </div>
              <div class="col-md-8 contact-form-col">
                <form id="help-form" method="post" action="{{route('help-page')}}">    
                   <div class="form-part">
                      <div class="form-group">
                        @csrf
                        <label for="fname">Full Name</label>
                        <input class="form-control" type="text" id="fname" name="fname" maxlength="30">
                        <span class="text-danger" id="fname_error"></span>
                      </div>
                      <div class="form-group">
                        <label for="email">Email Address</label>
                        <input class="form-control" type="email" id="email" name="email" maxlength ="50">
                        <span class="text-danger" id="email_error"></span>
                      </div>
                      <div class="form-group">
                        <label for="email">Message</label>
                        <textarea class="form-control"id="message" name="message"></textarea>
                        <span class="text-danger" id="message_error"></span>
                      </div>
                      <!-- <div class="form-group check-group">
                         <input type="checkbox" id="check_reminder">
                        <label for="check_reminder"> Remember Me</label>
                      </div> -->

                      <div class="button-wrapper">
                          <button type="submit" class="btn-main">Submit</button>
                      </div>
                    </div>
                    </form>

              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="about-content" id="suggestions_content">
        <div class="section-head text-center">
          <h2>Suggestions</h2>
        </div>
        <div class="about_module_wrapper">
          <div class="About_module">
            <h3>What is Lorem Ipsum?</h3>
            Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.
          </div>
          <div class="About_module">
            <h3>Why do we use it?</h3>
            It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using 'Content here, content here', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text.
          </div>
          <div class="About_module">
            <h3>Where does it come from?</h3>
            Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.
          </div>
          <div class="About_module">
            <h3>Where can I get some?</h3>
            It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using 'Content here, content here', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text.
          </div>
          <div class="About_module">
            <h3>The standard Lorem Ipsum passage, used since the 1500s</h3>
            It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using 'Content here, content here', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text.
          </div>
          <div class="About_module">
            <h3>1914 translation by H. Rackham</h3>
            Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.
          </div>
          <div class="About_module">
            <h3>Lorem Ipsum is simply dummy text?</h3>
            It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using 'Content here, content here', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text.
          </div>
        </div>
      </div>
      <div class="about-content  " id="privacy_content">
        <div class="section-head text-center">
          <h2>Privacy Policy</h2>
        </div>
        <div class="about_module_wrapper">
          <div class="About_module">
            <h3>What is Lorem Ipsum?</h3>
            Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.
          </div>
          <div class="About_module">
            <h3>Why do we use it?</h3>
            It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using 'Content here, content here', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text.
          </div>
          <div class="About_module">
            <h3>Where does it come from?</h3>
            Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.
          </div>
          <div class="About_module">
            <h3>Where can I get some?</h3>
            It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using 'Content here, content here', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text.
          </div>
          <div class="About_module">
            <h3>The standard Lorem Ipsum passage, used since the 1500s</h3>
            It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using 'Content here, content here', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text.
          </div>
          <div class="About_module">
            <h3>1914 translation by H. Rackham</h3>
            Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.
          </div>
          <div class="About_module">
            <h3>Lorem Ipsum is simply dummy text?</h3>
            It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using 'Content here, content here', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text.
          </div>
        </div>
      </div>

    </div>
  </div>
</section>

<section class="rolling-section">
  <div class="container-fluid">
    <div class="inner-section text-center">
    <div class="marquee">
      <div class="marquee--inner">
        <span class="marquee-span">
          <h2>We Have <span class="image"><img src="{{ asset('streamlode-front-assets/images/marque-image.png') }}"></span><span class="blue"> Great</span> Hosts For You!</h2>
        </span>
      </div>
    </div>
  </div>
  </div>
</section>
<script>
  $('#help-form').on('submit',function(e){
    e.preventDefault();
    formdata = new FormData(this);
    // console.log(formdata);
    $.ajax({
         method: 'post',
         url: '{{route('help-page')}}',
         data: formdata,
         dataType: 'json',
         contentType: false,
         processData: false,
         success: function(response)
         {
          swal({
                title: "Success !",
                text: "Successfully sent email to admin",
                icon: "success",
                button: "Dismiss",
              });
              $('#fname').val('');
              $('#email').val('');
              $('#message').val('');
              $('#fname_error').html('');
          $('#email_error').html('');
          $('#message_error').html('');
         },
         error: function(error){

          validation_error = JSON.parse(error.responseText).errors;
          console.log(validation_error);
          $('#fname_error').html(validation_error.fname);
          $('#email_error').html(validation_error.email);
          $('#message_error').html(validation_error.message);
         }
  });
});
</script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert"></script>
@endsection