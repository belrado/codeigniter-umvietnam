(function($){
	$(document).ready(function(){
        $('.shortterm-about-layer').PsuChildAllHeight({
            elem:'.shortterm-about-layer',
            elem_clild:'.inner-box',
            elem_child_sec:'>li'
        });
        $('.courses-img-sec').slick({
            centerMode: true,
          centerPadding: '285px',
          slidesToShow: 1,
          slidesToScroll: 1,
            nextArrow:'<button type="button" class="slick-next slick-btns">next</button>',
            prevArrow:'<button type="button" class="slick-prev slick-btns">prev</button>',
            responsive:[
                {
                    breakpoint: 1280,
                    settings: {
                        slidesToShow:1,
                        centerPadding:'100px'
                    }
                },
              {
                  breakpoint: 959,
                  settings: {
                     slidesToShow:1,
                     centerPadding:'50px'
                  }
              },
              {
                  breakpoint: 677,
                  settings: {
                      slidesToShow:1,
                      centerPadding:'20px'
                  }
              }
          ]
        });
    });
})(jQuery);
