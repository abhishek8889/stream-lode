@extends('guest_layout.master')
@section('content')
<style>
  .search-filter {
    display: flex;
    align-items: center;

}

.search-filter label {
    margin: 0px 10px 0px 0px;
     color: #C2C2C2;
}

select#searchcat {
    padding: 16.5px 19px;
    font-size: 17px;
    background: #000;
    color: #C2C2C2;
    border: 1px solid #313131;
}
</style>
<!-- #################### Search Host ################################# -->

<section class="top_banner inner_banner">
  <div class="container-fluid">
    <div class="inner-section">
      <div class="row banner-content">
        <div class="col-md-6 text_col">
          <div class="banner-heading">
            <h1>Want <span class="yellow">another</span> <span class="blue"> expert?</span> Type a topic below.</h1><span class="heading-pattern"><img src="{{ asset('streamlode-front-assets/images/star.png') }}"></span>
          </div>
          <div class="banner-text">
            <p>StreamLode can help you find a professional for your business needs or for your personal interests.</p><span class="text-pattern"><img src="{{ asset('streamlode-front-assets/images/text-star.png') }}"></span>
          </div>
        </div>
        <div class="col-md-6 media_col">
          <div class="banner-media">
            <img src="{{ asset('streamlode-front-assets/images/search-host-banner.png') }}" class="radius_top_50">
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<section class="search_host_section">
  <div class="dark_navigation serach-navigation">
    <div class="container">
      <div class="search-wrapper">
        <form>
          <div class="input-group">
            <div class="input-group-prepend">
              <!-- <button class="btn dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Select Tag</button>
              <div class="dropdown-menu">
                <a class="dropdown-item" href="#">Action</a>
                <a class="dropdown-item" href="#">Another action</a>
                <a class="dropdown-item" href="#">Something else here</a>
              </div> -->
              <div class="search-filter">
                <label>Search By: </label>
              <select name="name1" id="searchcat">
                  <option value="1">Name</option>
                  <option value="2">Page Name</option>
                  <option value="3">Tag</option>
              </select>
          </div>
            </div>
            <input type="search" class="form-control" id="searchbox" placeholder="Write Your Keyword..">
            <button type="submit" class="cta cta-yellow" id="searchbtn"><i class="fa-solid fa-magnifying-glass"></i></button>
          </div>
        </form>
      </div>
    </div>
  </div>
</section>
<section class="host-section">
  <div class="container-fluid">
    <div class="host-filter">
      <div class="row align-items-center">
        <div class="col-md-6" id = "hostscount">
          @if(isset($hosts) || !empty($hosts))
          <p>Showing all {{ count($hosts) }} results</p>
          @else
          <p>No result found</p>
          @endif
        </div>
        <div class="col-md-6">
          <!-- <div class="search-filter">
            <label>Search By: </label>
        <select name="name1" id="searchcat">
            <option value="1">Name</option>
            <option value="2">Page Name</option>
            <option value="3">Tag</option>
        </select>
          </div> -->
        </div>
      </div>
    </div>
    <div class="host-wrapper">
      <div class="row host-row">

      <!-- host box start -->
    
      @forelse($hosts as $host)
        <div class="col-lg-3 col-md-6 col-sm-6 host-col ">
          <div class="host-box">
            <div class="box-up">
              <div class="image-box hover-zoom" style="max-height:293px;">
                @if(isset($host['profile_image_url']) || !empty($host['profile_image_url'])) 
                <img src="{{ asset('Assets/images/user-profile-images/') }}/{{ $host['profile_image_name'] }}">
                @else
                <img src="{{ asset('Assets/images/default-avatar.jpg') }}">
                @endif
              </div>
              <div class="box-body">
                <h3 class="host-name"><span class="yellow">{{ isset($host['first_name'])?$host['first_name']: '' }}</span><span class="blue"> {{ isset($host['last_name'])?$host['last_name']:''; }} </span></h3>
                <?php 
                $host_id = '';
                foreach($host['_id'] as $i){
                  $host_id = $i;
                }
                
                $host_tags = App\Models\Tags::where('user_id',$host_id)->get(['name']);
                 
                ?>
                <h6 class="host_tag">
                  <?php $x = 0; ?>
                @forelse($host_tags as $tag)
                <?php $x = $x+1; ?>
                <?php if($x != 1){ echo ',';} ?> 
                <span>
                  {{ $tag['name'] }}
                </span>
                @empty
                @endforelse
                </h6>
              </div>
            </div>
            <div class="box-footer">
              <a href="{{ url('/details/'.$host['unique_id']) }}">More info <i class="fa-solid fa-arrow-right"></i></a>
            </div>
          </div>
        </div>
      @empty
          <p>No data found</p>
      @endforelse
        
       <!-- Host box end -->

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
  $(document).ready(function(){
    $('#searchbtn').click(function(e){
      e.preventDefault();
      data1 = $('#searchbox').val();
      cat = $('#searchcat').val();
      // console.log(cat);
      // console.log(data);
      $.ajax({
          method: 'post',
          url: '{{url('searchhost')}}',
          dataType: 'json',
          data: {data:data1, cat:cat ,_token: '{{csrf_token()}}'}, 
          success: function(response)
			{
        // console.log(response);
       if(cat == 3){
            var res = response.filter(function (el) {
            return el != null && el != "";
       });
       if(data1){
        var unique = [];
          var distinct = [];
          for( let i = 0; i < res.length; i++ ){
            if( !unique[res[i]._id]){
              distinct.push(res[i]);
              unique[res[i]._id] = 1;
            }
        }
       }else{
          distinct = res;
       }
          data = distinct;
      }else{
          data = response;
      }
                // console.log(res);
        divdata = [];
        $.each(data, function(key,value){
          if(value.profile_image_url){
            img = '{{url('public/Assets/images/user-profile-images')}}/'+value.profile_image_name;
          }else{
            img = '{{ asset('Assets/images/default-avatar.jpg') }}';
          }
        html = '<div class="col-lg-3 col-md-6 col-sm-6 host-col "><div class="host-box"><div class="box-up"><div class="image-box hover-zoom" style="max-height:293px;"><img src="'+img+'"></div><div class="box-body"><h3 class="host-name"><span class="yellow">'+value.first_name+'</span><span class="blue"> '+value.last_name+'</span></h3></div></div><div class="box-footer"><a href="{{ url('/details/') }}/'+value.unique_id+'">More info <i class="fa-solid fa-arrow-right"></i></a></div></div></div>';
       
        divdata.push(html);
        });
        $('#hostscount').html('Showing all '+divdata.length+' results');
        $('.host-row').html(divdata);
      }
      });
    });
  });
</script>


@endsection

