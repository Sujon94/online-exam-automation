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
