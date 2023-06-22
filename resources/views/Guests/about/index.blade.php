@extends('guest_layout.master')
@section('content')

<!-- #################### About page ################################# -->

<section class="top_banner inner_banner">
  <div class="container-fluid">
    <div class="inner-section">
      <div class="row banner-content">
        <div class="col-md-6 text_col">
          <div class="banner-heading">
            <h1><span class="yellow">Stream</span><span class="blue">Lode</span> can Allow You to generate a Revenue Stream.</h1><span class="heading-pattern"><img src="{{ asset('streamlode-front-assets/images/star.png') }}"></span>
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
          <li class="nav-list-item" id="standar-tier" data-target="community_guidelines"><a href="#standar-tier" >Community guidelines</a></li>
          <li class="nav-list-item" id="premium-tier" data-target="help_content"><a href="#premium-tier">Help</a></li>
          <li class="nav-list-item" id="group-tier" data-target="suggestions_content"><a href="#group-tier" >Suggestions</a></li>
          <li class="nav-list-item" id="group-tier" data-target="privacy_content"><a href="#group-tier">Privacy Policy</a></li>
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
        <div class="about_module_wrapper">
          <div class="contact-nfo-wrapper">
            <div class="row contact-row">
              <div class="col-md-4 contact-address-col">
                <div class="address-list">
                  <ul>
                    <li><i class="fa-solid fa-envelope"></i> <a href="mailto:info@streamlode.com"> info@streamlode.com</a></li>
                    <li><i class="fa-solid fa-house"></i> 621 Bingamon Road Independence, OH 44131</li>
                  </ul>
                </div>
              </div>
              <div class="col-md-8 contact-form-col">
                <div class="form-part">
                      <div class="form-group">
                        <label for="fname">First And Last Name</label>
                        <input class="form-control" type="text" id="fname" name="fname">
                      </div>
                      <div class="form-group">
                        <label for="email">Email Address</label>
                        <input class="form-control" type="text" id="email" name="email">
                      </div>
                      <div class="form-group">
                        <label for="email">Message</label>
                        <textarea class="form-control"id="message" name="message"></textarea>
                      </div>
                      <div class="form-group check-group">
                         <input type="checkbox" id="check_reminder">
                        <label for="check_reminder"> Remember Me</label>
                      </div>

                      <div class="button-wrapper">
                          <button type="button" class="btn-main">Submit</button>
                      </div>
                    </div>
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
          <h2>We Have <span class="image"><img src="{{ asset('streamlode-front-assets/images/marque-image.png') }}"></span> <span class="yellow">A</span><span class="blue"> Great</span> Hosts For You!</h2>
        </span>
      </div>
    </div>
  </div>
  </div>
</section>
@endsection