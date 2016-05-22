$(function(){
    $("#jqxMenu").jqxMenu({});

    $('.js-homeSlider').slick({
        dots: true,
        autoplay: true,
        arrows:false,
        infinite: true,
        speed: 700,
        pauseOnDotsHover: true,
        slidesToShow: 1,
        slidesToScroll: 1
    });

    $(".js-imageList div.slide").each(
          function(index) {
              $(this).css( "z-index", -index*2+2 );
          }
      );

    $('.js-imageList').slick({
      dots: false,
      infinite: false,
      speed: 700,
      slidesToShow: 6,
      slidesToScroll: 1,
      responsive: [{
          breakpoint: 1024,
          settings: {
              slidesToShow: 3,
              slidesToScroll: 1,
              infinite: true,
              dots: false
          }
      }, {
          breakpoint: 600,
          settings: {
              slidesToShow: 2,
              slidesToScroll: 1
          }
      }, {
          breakpoint: 480,
          settings: {
              slidesToShow: 2,
              slidesToScroll: 1
          }
      }]
  });

  $('.js-homeSliderLogo').slick({
      dots: true,
      arrows:false,
      infinite: true,
      speed:800,
      pauseOnDotsHover: true,
      slidesToShow: 4,
      slidesToScroll: 4
  });
})