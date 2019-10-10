(function($){
	$(document).ready(function(){
		var setjs_fullheight =  function(){
			var h = $(window).innerHeight();
			$('.jselem>.inner-box').css({'height':h+'px'});
			$('#wrapper').css({'height':'auto', 'overflow':'hidden'});
		}
		$('.mainJs-slickjs').on('init', function(event, slick){
			$(this).find('.jselem').eq(0).addClass('active');
		});
		$('.mainJs-slickjs').slick({
			autoplay:true,
			autoplaySpeed:10000,
			dots: false,
			pauseOnHover:true,
			pauseOnFocus:false,
			infinite: true,
			speed: 500,
			fade: true,
			cssEase: 'linear',
			arrows:false,
			responsive:[
				{
					breakpoint: 768,
					settings: {
						infinite: true
					}
				}
			]
		});
		$('.mainJs-slickjs').on('beforeChange', function(event, slick, currentSlide, nextSlide){
			$(this).find('.jselem').removeClass('active');
			$(this).find('.jselem').eq(nextSlide).addClass('active');
		});
		setjs_fullheight();
		$(window).on('load resize', function(){
			setjs_fullheight();
		});
		$('.main-important-program').PsuChildAllHeight({
			elem:'.main-important-program',
			elem_clild:'.title-sec',
			elem_child_sec:'.program-title'
		});
		$('.main-important-program').PsuChildAllHeight({
			elem:'.main-important-program',
			elem_clild:'a',
			elem_child_sec:'.program-list'
		});
	    $('.main-presentation').slick({
			autoplay:true,
			autoplaySpeed:6000,
			speed: 1000,
			dots: false,
	        vertical:true,
	        verticalSwiping:true,
			slidesToShow: 1,
	        infinite: true,
	        nextArrow:'<button type="button" class="slick-prev slick-btns">prev</button>',
	        prevArrow:'<button type="button" class="slick-next slick-btns">next</button>',
			responsive:[
  	          {
  	              breakpoint: 959,
  	              settings: {
					  vertical:false,
					  verticalSwiping:false
  	              }
  	          }
  	      ]
	    });
	    $('.main-bbs-list').slick({
			autoplay:true,
			autoplaySpeed:6000,
	      	dots: false,
	      	infinite: true,
	      	speed: 800,
	      slidesToShow: 3,
	      cssEase: 'linear',
	      nextArrow:'<button type="button" class="slick-prev slick-btns">prev</button>',
	      prevArrow:'<button type="button" class="slick-next slick-btns">next</button>',
	      responsive:[
	          {
	              breakpoint: 1239,
	              settings: {
	                  slidesToShow: 2
	              }
	          },
	          {
	              breakpoint: 767,
	              settings: {
	                  slidesToShow: 1
	              }
	          }
	      ]
	    });
	});
})(jQuery);
