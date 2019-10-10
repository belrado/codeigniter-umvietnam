(function($){
	//var mainJsBnr = new $.KYS_SlideJS();
	//mainJsBnr.absolute_css		= true;
	//mainJsBnr.transition_css	= true;
	//mainJsBnr.fullSize 			= false;
	//mainJsBnr.timeSpeed			= 12000;
	//mainJsBnr.init();
	$('.main-important-link').PsuChildAllHeight({
		elem:'.main-important-link',
		elem_clild:'.link-text',
		elem_child_sec:'.link-contents'
	});
	$('.main-uofm-admission-list').PsuChildAllHeight({
		elem:'.main-uofm-admission-list',
		elem_clild:'.inner-box',
		elem_child_sec:'>li'
	});
	$('.main-admission-process-list').PsuChildAllHeight({
		elem:'.main-admission-process-list',
		elem_clild:'.contents-box',
		elem_child_sec:'.inner-box'
	});
	/* 상단 이벤트가 열려있다면 (클릭해서 누른게 아니라면 !== click_open) 휠버튼 내렸을때 사라지게함 */
	var winScrollTopPos 	= $(window).scrollTop();
	var mainHeaderEventElem = $('#header_event_menu');
	var startScrollHeaderEventExec = function(){
		if(!mainHeaderEventElem.hasClass('click_open')){
			if(winScrollTopPos +200 < $(window).scrollTop() || winScrollTopPos -200 > $(window).scrollTop()){
				mainHeaderEventElem.removeClass('active').removeClass('show').removeClass('click_open');
			}
		}
	}
	setTimeout(function(){
		//winScrollTopPos 	= $(window).scrollTop();
		$(window).on('scroll', startScrollHeaderEventExec);
	},1000);

	$(window).on('resize load scroll', function(){
		//settingCount('#main-psuresult-list');
	});
})(jQuery);
