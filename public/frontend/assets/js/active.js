(function($) {
  'use strict';     
    /*----------------------
      Isotope js
    -----------------------*/
    $('#gallery').imagesLoaded( function() {
        var $grid = $('.grid-area').isotope({
          itemSelector: '.single-item',
          layoutMode: 'fitRows'
        });
        // filter items on button click
        $('.portfolio-button').on( 'click', 'button', function() {
          var filterValue = $(this).attr('data-filter');
          $grid.isotope({ filter: filterValue });
        });
        // change is-checked class on buttons
        $('.portfolio-button').each(function (i, buttonGroup) {
            var $buttonGroup = $(buttonGroup);
            $buttonGroup.on('click', 'button', function () {
                $buttonGroup.find('.is-checked').removeClass('is-checked');
                $(this).addClass('is-checked');
            });
        });
    });
})(window.jQuery);
