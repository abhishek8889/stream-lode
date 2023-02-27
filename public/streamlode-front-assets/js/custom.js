  
$(document).ready(function(){
  $('.step_form').slick({
      slidesToShow: 1,
      adaptiveHeight: true,
      draggable: false,
       dots: false,
      prevArrow: false,
	  infinite:false,
      nextArrow: false

    });
    
  $('#firstStep').click(function(){
	  var first_name = $('#first_name').val();
	  // alert(first_name);
     $('.step_form').slick('slickGoTo', 1);
    }); 
  /*$('#secondStep').click(function(){
     $('.step_form').slick('slickGoTo', 2);
    }); 
  $('#paypalStep').click(function(){
     $('.step_form').slick('slickGoTo', 2);
    });
  $('#thirdstep').click(function(){
     $('.step_form').slick('slickGoTo', 3);
    });
  $('#fourthstep').click(function(){
     $('.step_form').slick('slickGoTo', 4);
    });
  $('#stepfive').click(function(){
     $('.step_form').slick('slickGoTo', 5);
    }); 
  
  $('.prevStep').click(function(){
      var step = $(this).attr('data-prev');
      $('.step_form').slick('slickGoTo', step);
    }); 
  
  $('.step_form').on('afterChange', function(event, slick, currentSlide, nextSlide){
        if(currentSlide === 1 ){
            $('.first-slide').addClass('step_disabled');
        }else{
            $('.first-slide').removeClass('step_disabled');
        }

        if(currentSlide === 2 ){
            $('.scond-slide').addClass('step_disabled');
            $('.first-slide').addClass('step_disabled');
        }else{
            $('.scond-slide').removeClass('step_disabled');
        }
      
      var activeCls = currentSlide+1;
      $("ul.navlist li").removeClass('active').each(function(index){
          if(index < activeCls){
            $(this).addClass('active');
          }
        });
  });*/

  });
  $(document).ready(function(){
    $("#paypal").hide();
    $(".paywith").on('click',function(){
      let paywith = $(this).attr('paywith');
      if(paywith == 'paypal'){
        $("#paypal").show();
        $("#card-pay-btn").hide();
        $("#card").hide();
      }
      if(paywith == "card"){
        $("#card").show();
        $("#card-pay-btn").show();
        $("#paypal").hide();
      }
    });
    $(".lab").on('click',function(){
      $("#coup-code").toggle();
    });
   
  });
  
 
  $(document).ready(function(){

  $('.review-slider').slick({
        slidesToShow: 3,
        slidesToScroll: 1,
        dots: true,
        arrows: false,
        focusOnSelect: true,
        responsive: [
            {
              breakpoint: 1199,
              settings: {
                slidesToShow: 2,  
                }
            },
            {
              breakpoint: 420,
              settings: {
                slidesToShow: 1,
                slidesToScroll: 1,
                }
            }
        ]
    });
});


// document.addEventListener("DOMContentLoaded", () => {

//  function counter(id, start, end, duration) {
//   let obj = document.getElementById(id),
//    current = start,
//    range = end - start,
//    increment = end > start ? 1 : -1,
//    step = Math.abs(Math.floor(duration / range)),
//    timer = setInterval(() => {
//     current += increment;
//     obj.textContent = current;
//     if (current == end) {
//      clearInterval(timer);
//     }
//    }, step);
//  }
//  counter("smile_clients", 0, 239, 5000);
// });


jQuery(document).ready(function() {
jQuery(".down").click(function() {
     jQuery('html, body').animate({
         scrollTop: jQuery(".up").offset().top }, 1500);
 });
});


// about page nav

  jQuery(document).ready(function(){
    $("ul.nav-list li").on('click',function(){
        let target_class = $(this).attr('data-target');
        $("ul.nav-list li.nav-list-item").removeClass('active');
        $(this).addClass('active');
        $(".about-content").removeClass('show_box');
        $("#"+target_class).addClass('show_box');    
    });
    
  });


// filter pricing plans
filterSelection("all")
function filterSelection(c) {
  var x, i;
  x = document.getElementsByClassName("filter_item");
  if (c == "all") c = "";
  for (i = 0; i < x.length; i++) {
    w3RemoveClass(x[i], "show_box");
    if (x[i].className.indexOf(c) > -1) w3AddClass(x[i], "show_box");
  }
}

function w3AddClass(element, name) {
  var i, arr1, arr2;
  arr1 = element.className.split(" ");
  arr2 = name.split(" ");
  for (i = 0; i < arr2.length; i++) {
    if (arr1.indexOf(arr2[i]) == -1) {element.className += " " + arr2[i];}
  }
}

function w3RemoveClass(element, name) {
  var i, arr1, arr2;
  arr1 = element.className.split(" ");
  arr2 = name.split(" ");
  for (i = 0; i < arr2.length; i++) {
    while (arr1.indexOf(arr2[i]) > -1) {
      arr1.splice(arr1.indexOf(arr2[i]), 1);     
    }
  }
  element.className = arr1.join(" ");
}

// Add active class to the current button (highlight it)
/*
var btnContainer = document.getElementById("filter-list");
var btns = btnContainer.getElementsByClassName("nave-list-item");

for (var i = 0; i < btns.length; i++) {
  btns[i].addEventListener("click", function(){
    var current = document.getElementsByClassName("active");
    current[0].className = current[0].className.replace(" active", "");
    this.className += " active";
  });
}*/
