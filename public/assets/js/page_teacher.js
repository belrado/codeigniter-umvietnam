(function($){
	$('.click-teacher-box').on({
		click:function(e){
			
			var _thisids = $(this).data('teacherid');
			var wrapper = $(this).closest('.subject-teacher-box');
			if($(this).hasClass('active')){
				
				
				console.log('ddt')
				
				wrapper.find('.click-teacher-box').removeClass('active');
				wrapper.find('.inner-box').removeClass('active');
			}else{
				wrapper.find('.click-teacher-box').removeClass('active');
				wrapper.find('.inner-box').removeClass('active');
				$(this).addClass('active');
				$('#view-teacher-'+_thisids).addClass('active');
			}	
		}
	});
	$('.page-tabbtn-sec').find('a').on({
		click:function(e){
			e.preventDefault ? e.preventDefault() : (e.returnValue = false);
			if(!$(this).hasClass('active')){
				var ids = $(this).attr('href');
				if(ids == 'javascript:;'){
					$('.page-tabbtn-sec').find('a').removeClass('active');
					$('.psu-subject-wrapper>li').removeClass('active');
					$(this).addClass('active');
					$('.psu-subject-wrapper>li').addClass('active');
				}else{
					$('.page-tabbtn-sec').find('a').removeClass('active');
					$('.psu-subject-wrapper>li').removeClass('active');
					$(this).addClass('active');
					$(ids).addClass('active');
				}				
			}

		}
	})
})(jQuery);