@extends('guest_layout.master')
@section('content')
<section class="top_banner home_banner">
  <div class="container-fluid">
    <div class="inner-section">
      <p class="copyright-text">©2023</p>
      <div class="header-button-wrapper">
        <div class="banner-heading d-flex">
          <h1>The income generating <span class="blue">conferencing</span> platform.</h1><span class="heading-pattern"><img src="{{ asset('streamlode-front-assets/images/star.png') }}"></span>
        </div>
        <div class="button-box">
            <a href="{{ url('membership') }}#membership-tiers" class="round-cta">
                <span class="cta__text">Get Started</span>
                <svg viewBox="-1 -1 202 102" preserveAspectRatio="none">
                    <ellipse class="ellipse" cx="100" cy="50" rx="100" ry="50" stroke-width="1" stroke="currentColor" fill="none"></ellipse>
                </svg>
            </a>
        </div>
      </div>
      <div class="row counter-row">
        <div class="col-md-4 counter-col">
          <div class="box-wrapper">
            <div class="image-box">
              <img src="{{  asset('streamlode-front-assets/images/smiling-clients.png') }}">
            </div>
            <div class="coumter-side">
              <h3><span class="count" id="smile_clients">239</span> + </h3>
              <p>Smiling Clients</p>
            </div>
          </div>
        </div>
        <div class="col-md-8 description-col">
          <div class="description-text">
            <p>StreamLode is for anyone who can provide virtual instruction and, consultation through a video call. StreamLode allows professionals to reach new customers and generate income, without ever leaving their home or office.</p>
          </div>
        </div>
      </div>
      <div class="baner_fullwidth_module">
        <div class="text-button-wrapper">
          <div class="row  text-button-row">
            <div class="text-side-col col-md-8">
              <div class="float-text">
                <p>StreamLode can provide you access to clients from around the world. Anywhere a potential client is based with an internet connection, they can access your StreamLode page, and pay for your knowledge and expertise.</p>
              </div>
            </div>
            <div class="down-button-col col-md-4">
              <a href="#" class="scroll-down-button down" id="banner_image_scroll"><i class="fa-solid fa-arrow-down"></i></a>
            </div>
          </div>
          </div>
          <div class="banner_ull-image">
            <img src="{{  asset('streamlode-front-assets/images/shutterstock_1818698438.jpg') }}" alt="image" class="border-top-120">
          </div>
        
      </div>
    </div>
  </div>
  <div class="dark_navigation up">
    <div class="container-fluid">
      <div class="dark-nav">
        <ul>
          <li><a href="#">Legal</a></li>
          <li><a href="#">Community guidelines</a></li>
          <li><a href="#">Help</a></li>
          <li><a href="#">Suggestions</a></li>
          <li><a href="#">Privacy Policy</a></li>
        </ul>
      </div>
    </div>
  </div>
</section>

<section class="new-section what_is_load_section py_150">
  <div class="container-fluid">
    <div class="inner-section">
      <div class="row">
        <div class="col-md-4 head-col">
          <h2>What is 
<span class="yellow">stream</span><span class="blue">Lode?</span></h2>
        </div>
        <div class="col-md-8 description-col">
          <p>StreamLode is an income generating platform that can be used for businesses and individuals who can provide specialized information for people around the world. Anywhere there is an internet, Streamlode is there to reach your potential customers. All your potential customers will have to do is, reach your personal StreamLode page, click on a day on your StreamLode Calendar, then select a meeting period that you have set up for customers. An email will then be sent to that customer, which will remind them of their appointment with you. </p>
          <div class="divider">
            <div class="divide-element"></div>
          </div>
          <p>When its time for their appointment with you, they can then click the meeting link, apply the payment for your fees, then they will be taken to a virtual meeting room that you are hosting. After the meeting has been completed for the full meeting time, you will then collect the payment for your time and services. A small percentage of your fee (less than 12%) is collected by StreamLode. The rest is all yours to keep. There is a $10 minimum fee for all of your sessions with your customers.</p>
        </div>
      </div>
    </div>
  </div>
</section>

<section class="new-section benefits-section dark py-170 right_top-or-leftbt-blue">
  <div class="container-fluid">
    <div class="section-head text-center">
      <h2><span class="subheading">Benefits of</span>
      <span class="yellow">Stream</span><span class="blue">Lode!</span></h2>
    </div>
    <div class="benefits-wrapper">
      <div class="image_box_wrapper d-flex align-items-center">
        <div class="image-box hover-zoom radius-50">
          <img src="{{  asset('streamlode-front-assets/images/shutterstock_1571410972 1.png') }}">
        </div>
        <div class="text-wrapper">
          <div class="text-box">
            <p>StreamLode can allow you to generate a revenue stream around your schedule, around your responsibilities, while working from home.</p>
          </div>
        </div>
      </div>
      <div class="image_box_wrapper d-flex align-items-center">
        <div class="image-box hover-zoom radius-50">
          <img src="{{  asset('streamlode-front-assets/images/shutterstock_1460195933 1.png') }}">
        </div>
        <div class="text-wrapper">
          <div class="text-box">
            <p>Much like other social media sites, StreamLode allows people from around the world to find your individual page, by your page name or specialized tags.</p>
          </div>
        </div>
      </div>
      <div class="image_box_wrapper d-flex align-items-center">
        <div class="image-box hover-zoom radius-50">
          <img src="{{  asset('streamlode-front-assets/images/shutterstock_1194109243 1.png') }}">
        </div>
        <div class="text-wrapper">
          <div class="text-box">
            <p>StreamLode provides stream hosts a platform to host specialized instructional sessions, based on their skill set.</p>
          </div>
        </div>
      </div>
      <!-- <div class="image_box_wrapper d-flex align-items-center">
        <div class="image-box hover-zoom radius-50">
          <img src="{{  asset('streamlode-front-assets/images/shutterstock_2072488901 1.png') }}">
        </div>
        <div class="text-wrapper">
          <div class="text-box">
            <p>Multiple paying clients can be hosted during one session, allowing you to generate more revenue at a faster rate.</p>
          </div>
        </div>
      </div> -->
    </div>
  </div>
</section>

<section class="rolling-section">
  <div class="container-fluid">
    <div class="inner-section text-center">
    <div class="marquee">
      <div class="marquee--inner">
        <span class="marquee-span">
          <h2>We Have <span class="image"><image src="{{  asset('streamlode-front-assets/images/marque-image.png') }}"></span><span class="blue"> Great</span> Hosts For You!</h2>
        </span>
      </div>
    </div>
  </div>
  </div>
</section>

@endsection