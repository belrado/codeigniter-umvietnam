(function($){
	$('.psufaq-list').find('.question-sec').on({
		click:function(){
			var _this = $(this);
			if(!$(this).parent().hasClass('open')){
				var questionHeight 			= _this.height();
				var questionInnerHeight 	= _this.innerHeight();
				var answerHeight 			= _this.next('.answer-sec').innerHeight();
				var _thisIndex 				= _this.parent().index();
				_this.parent().addClass('open');
				_this.parent().removeClass('close');
				_this.parent().css({'height':questionInnerHeight+'px'})
				_this.parent().stop(true,true).animate({'height':questionInnerHeight+answerHeight+'px'},250,function(){
					$(this).css({'height':'auto'});
				});
			}else{
				var openQuestionHeight = _this.innerHeight();
				_this.stop(true,true).parent().animate({'height':openQuestionHeight+'px'},250, function(){
					$(this).addClass('close');
					$(this).removeClass('open');
					$(this).css({'height':'auto'});
				});
			}		
		}
	});
})(jQuery);