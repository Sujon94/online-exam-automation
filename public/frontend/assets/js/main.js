(function($) {
  'use strict';     
    /*--------------------
      Preloader js
    -------------------*/ 
      var prealoaderOption = $(window);
      prealoaderOption.on("load", function () {
          var preloader = jQuery('.sk-cube-grid');
          var preloaderArea = jQuery('.preloader-area');
          preloader.fadeOut();
          preloaderArea.delay(350).fadeOut('slow');
      });

    /*--------------------
      Sticky header js
    -------------------*/ 
    $(window).on('scroll',function() {    
        var scroll = $(window).scrollTop();
         if (scroll < 100) {
          $("#header-area").removeClass("sticky");
         }else{
          $("#header-area").addClass("sticky");
         }
    }); 

    /*--------------------
      Responsive menu js
    -------------------*/ 
    $('.main-menu nav').meanmenu({
      meanMenuContainer: '.mobile-menu',
      meanScreenWidth: "766"
    });

    /*--------------------
      nav search js
    -------------------*/ 
    $(".search-icon").find(".fa-search").on('click', function() {
      $(".search-form").toggle();
      return false;
    });
   
    /*--------------------
      slick slider js
    -------------------*/  
    $(".regular").slick({
      dots: false,
      arrows: true,
      autoplay: true,
      infinite: true,
      slidesToShow:1,
      speed: 200,
      slidesToScroll: 1,
      responsive: [
        {
          breakpoint: 480,
          settings: {
            dots:true,
            arrows:false
          }
        }
      ]
    });
    $('.responsive').slick({
      dots: true,
      infinite: true,
      speed: 300,
      slidesToShow: 1,
      slidesToScroll: 1,
      autoplay: false,
      arrows:false
    });
    
    /*---------------  
      counterup JS
    ----------------*/   
    $('.counter').counterUp({
        delay: 60,
        time: 6000
    });

    /*-------------------
      magnifiq popup JS
    ----------------------*/ 
    $('.gallery-single').magnificPopup({
      type:'image',
      gallery:{
        enabled:true
      }
    });
    $('.video-play').magnificPopup({
      type: 'iframe',
      removalDelay: 300,
      mainClass: 'mfp-fade'
    });
    
    /*-------------------
      Countdown Timer js
    ---------------------*/
    if($('.event-time-countdown').length){  
      $('.event-time-countdown').each(function() {
      var $this = $(this), finalDate = $(this).data('countdown');
      $this.countdown(finalDate, function(event) {
        var $this = $(this).html(event.strftime('' + '<div class="counter-column"><div class="inner"><span class="count">%D</span>Days</div></div> ' + '<div class="counter-column"><div class="inner"><span class="count">%H</span>Hours</div></div>  ' + '<div class="counter-column"><div class="inner"><span class="count">%M</span>Mins</div></div>  ' + '<div class="counter-column"><div class="inner"><span class="count">%S</span>Secs</div></div>'));
      });
     });
    }

    /*-------------------
        Scroll top js
    ---------------------*/
    $(window).on('scroll', function() {
      if ($(this).scrollTop() > 100) {
          $('#scroll-up').fadeIn();
      } else {
          $('#scroll-up').fadeOut();
      }
    });
    $('#scroll-up').on('click', function() {
      $("html, body").animate({
          scrollTop: 0
      }, 600);
      return false;
    });



})(window.jQuery);


