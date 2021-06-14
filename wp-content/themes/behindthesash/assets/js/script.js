/*jslint browser: true*/
/*global $, jQuery, Modernizr, enquire*/
(function (window, document, $) {
  // var $html = $('html'),
  //   mobileOnly = "screen and (max-width:47.9375em)", // 767px.
  //   mobileLandscape = "(min-width:30em)", // 480px.
  //   tablet = "(min-width:48em)"; // 768px.
  // Contact form 7 redirect after submit.
  document.addEventListener( 'wpcf7mailsent', function( event ) {
    if ( '69' == event.detail.contactFormId ) {
        window.location.href = window.location.protocol + '//' + window.location.hostname + '/thank-you/';
    }
  }, false );

  // Js code.
  $( document ).ready(function() {
    // Remove attr title.
    $('a, img').removeAttr('title');

    $('.iscwp-outer-wrap').addClass('js-slick-instagram');

    $('.js-slick-logo').slick({
      prevArrow: '<span class="slick-logo-carousel-prev"></span>',
      nextArrow: '<span class="slick-logo-carousel-next"></span>',
      slidesToShow: 6,
      slidesToScroll: 1,
      autoplay: true,
      autoplaySpeed: 2000,
      dots: false,
      arrows: false,
      responsive: [
        {
          breakpoint: 768,
          settings: {
            slidesToShow: 1,
            slidesToScroll: 1,
            arrows: true,
          }
        },
      ]
    });

    $('.js-slick-banner').slick({
      prevArrow: '<span class="slick-banner-prev"></span>',
      nextArrow: '<span class="slick-banner-next"></span>',
      slidesToShow: 1,
      slidesToScroll: 1,
      autoplay: true,
      speed: 800,
      fade: true,
      autoplaySpeed: 2500,
      dots: true,
      arrows: true,
      responsive: [
        {
          breakpoint: 768,
          settings: {
            slidesToShow: 1,
            slidesToScroll: 1,
          }
        },
      ]
    });

    $('.js-slick-instagram').slick({
      centerMode: true,
      centerPadding: '110px',
      slidesToShow: 3,
      responsive: [
        {
          breakpoint: 768,
          settings: {
            slidesToShow: 1,
            centerMode: true,
            centerPadding: '17px',
          }
        }
      ]
    });

    // slick resize
    $(window).on('resize orientationchange', function () {
      $('.js-slick-logo').not('.slick-initialized').slick('resize');
      $('.js-slick-banner').not('.slick-initialized').slick('resize');
    });

    if($('.js-hover').length) {
      var $imgNormal = '';
      $('.js-hover').mouseover(function(){
        var $imgHover = $(this).attr('data-imghover');
        $imgNormal = $(this).find('img').attr('src'); 

        $(this).find('img').attr('srcset', $imgHover);
        $(this).find('img').attr('src', $imgHover);
      }).mouseleave(function() {
        console.log($imgNormal);
        $(this).find('img').attr('srcset', $imgNormal);
        $(this).find('img').attr('src', $imgNormal);
      });
    }

    // js lightbox form

      $('.js-lightbox').click(function(e) {
        e.preventDefault();
        $('.is-lightbox').toggleClass('active');
        $('body').toggleClass('no-scroll');
      });

      $(document).mouseup(function (e) {
          var popup = $(".lightbox-form");
          if (!$('.js-lightbox').is(e.target) && !popup.is(e.target) && popup.has(e.target).length == 0) {
              popup.closest('.lightbox-formwrap').removeClass('active');
              $('body').removeClass('no-scroll');
          }
      });

      $('.js-close-form').click(function () {
        $(this).parents('.is-lightbox').toggleClass('active');
        $('body').toggleClass('no-scroll');
      });
  });

}(this, this.document, this.jQuery));
