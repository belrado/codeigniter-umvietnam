<?php if($home_popup && (function_exists('get_cookie') && !get_cookie('eventpop')) && (isset($is_main) && $is_main)) : ?>
	<!-- // 3개까지만 노출되게 하셈 // -->
	<div class="main-begin-event-pop" id="main-begin-event-pop" data-eventkey="<?=$this->security->get_csrf_hash()?>">
		<h2 class="blind">UMV EVENT!</h2>
		<div class="event-pop">
			<?php foreach($home_popup as $val) : ?>
			<?php if($val['pop_viewtype']=='onlytext') continue; ?>
			<div class="box">
				<div class="inner-box">
					<h3 class="blind"><?=fnc_set_htmls_strip($val['pop_subject_'.$umv_lang], true)?></h3>
					<?php if(!empty($val['pop_link'])) : ?>
					<a href="<?=$this->homelanguage->set_lang_home_uri($val['pop_link'], $umv_lang)?>">
						<img src="<?=fnc_set_htmls_strip($val['pop_file_path_'.$umv_lang], true)?>" alt="<?=fnc_set_htmls_strip($val['pop_alt_'.$umv_lang], true)?>" />
					</a>
					<?php else : ?>
					<img src="<?=fnc_set_htmls_strip($val['pop_file_path_'.$umv_lang], true)?>" alt="<?=fnc_set_htmls_strip($val['pop_alt_'.$umv_lang], true)?>" />
					<?php endif ?>
				</div>
			</div>
			<?php endforeach ?>
			<div class="controller">
				<label class="today-hide-sec btn-layout"><input type="checkbox" name="today_hide" class="today-hide" /> <?=$lang_menu['do_not_show_today']?></label>
				<input type="button" class="close-btn btn-layout" value="<?=$lang_menu['close']?>" />
			</div>
		</div>
		<div class="popbg"></div>
	</div>
	<script>
		var MainBeginEventPop = (function(){
			console.log('init')
			var maxWidth	= 390;
			var popWrap		= $('#main-begin-event-pop');
			var popList		= popWrap.find('.event-pop');
			var popChild	= popList.find('.box');
			var popLen 		= popChild.length;
			var headerEventState = function(popWrap){
				if(popWrap.length>0){
					if(popWrap.css('display') === 'block'){
						$('#header-wrap').addClass('opacity1');
						$('#header_event_menu').removeClass('active').removeClass('show').removeClass('click_open');
					}else{
						$('#header-wrap').removeClass('opacity1');
						$('#header_event_menu').addClass('active').addClass('show').addClass('click_open');
					}
				}else{
					$('#header-wrap').removeClass('opacity1');
					$('#header_event_menu').addClass('active').addClass('show').addClass('click_open');
				}
			}
			setTimeout(function(){
				headerEventState(popWrap);
			}, 300);
			$(window).resize(function(){
				headerEventState($('#main-begin-event-pop'));
			});
			// 상단 이벤트 메뉴에 이벤트 추가
			$('#header_event_menu .umenus, #header_event_pop .close_btn').on({
				click:function(){
					if($('#main-begin-event-pop').length>0){
						$('#header-wrap').removeClass('opacity1');
						$('#main-begin-event-pop').remove();
					}
				}
			});
			popList.css({'max-width':(maxWidth*popLen)+'px'});
			popChild.css('width', (100/popLen)+'%');
			popWrap.find('.popbg, .close-btn').on({
				click:function(){
					popWrap.remove();
					headerEventState($('#main-begin-event-pop'));
					if(popWrap.find('input[name="today_hide"]').is(':checked')){
						try{
							var action = "/setTodayCookie";
							var token  = popWrap.data('eventkey');
							$.ajax({
								type:'post',
								url:action,
								data:{
									'cookie_name':'eventpop',
									'day_type':'today',
									'csrf_token_home':token
								},
								dataType:"JSON",
								success:function(data){
									if(data.home_token){
										var return_token = data.home_token;
										$('input[name="csrf_token_home"]').val(return_token);
									}
								},
								error:function(xhr, status, error){
									console.log(status, error);
								}
							});
						}catch(e){}
					}
				}
			});
		})();
	</script>
<?php endif ?>
